<?php
// include all core components
// TODO this is just plain ugly with cake - find a better solution for this
require '../../app/core/athlete/athlete.class.php';
require '../../app/core/helpers/database.class.php';
require '../../app/core/helpers/datetimehelper.class.php';
require '../../app/core/providers/workoutprovider.class.php';
require '../../app/core/providers/mesocyclephasetableprovider.class.php';
require '../../app/core/providers/mesocycleprovider.class.php';
require '../../app/core/providers/trirunprovider.class.php';
require '../../app/core/providers/tribikeprovider.class.php';
require '../../app/core/schedule/schedule.class.php';
require '../../app/core/schedule/race.class.php';
require '../../app/core/sequences/sequence.class.php';
require '../../app/core/sequences/workouttypesequence.class.php';
require '../../app/core/sequences/trirunworkouttypesequence.class.php';
require '../../app/core/sequences/tribikeworkouttypesequence.class.php';
require '../../app/core/workouts/workout.class.php';
require '../../app/core/workouts/swimworkout.class.php';
require '../../app/core/workouts/bikeworkout.class.php';
require '../../app/core/workouts/runworkout.class.php';
require '../../app/core/renderers/workoutrenderer.class.php';

class ProviderComponent extends Object {
	var $components = array('Session');
	var $helpers = array('Session');
	var $DB;
	var $athlete;
	
	/**
	 * initializes the provider component
	 * @param unknown_type $controller not needed
	 * @param unknown_type $settings not needed
	 */
	public function initialize($controller, $settings) {
		// TODO omg change this!!!
		$this->DB = new Database("root", "", "trainer", "localhost");
		$this->athlete = new Athlete($this->DB, $this->Session->read('userobject'));
	}
	
	/**
	 * get a plan
	 */
	public function getPlan() {
		$genWeek = DateTimeHelper::getWeekStartDay(new DateTime());

		if (isset($_GET['o'])) {
			$offset = intval($_GET['o']) * 7;
			$genWeek->add(new DateInterval("P" . $offset . "D"));
		}
		
		$mcp = new MesoCycleProvider($this->DB, $this->athlete, $genWeek);
		$time = $mcp->getTrainingTime($genWeek);

		// now generate workouts
		$phase = $mcp->getPhase($genWeek);
		
		$swimWorkouts = array();
		$bikeWorkouts = array();
		$runWorkouts = array();
		
		switch($this->getMultisportType($this->athlete->getSport())) {
			case 'TRIATHLON':
				$swimWorkouts = array (
					new SwimWorkout($this->athlete, 'E1', $mcp->getTrainingTime($genWeek, 'SWIM')));
				
				$tbp = new TriBikeProvider($this->DB, $this->athlete, $mcp->getTrainingTime($genWeek, 'BIKE'), $phase);
				$bikeWorkouts = $tbp->generate($genWeek);
				$tbp->save(); 
				//array (
				//	new BikeWorkout($this->athlete, 'E1', $mcp->getTrainingTime($genWeek, 'BIKE')));

				$trp = new TriRunProvider($this->DB, $this->athlete, $mcp->getTrainingTime($genWeek, 'RUN'), $phase);
				$runWorkouts = $trp->generate($genWeek);
				$trp->save();
				break;
            case 'DUATHLON':
            	$bikeWorkouts = array (
					new BikeWorkout($this->athlete, 'E1', $mcp->getTrainingTime($genWeek, 'BIKE')));
				
				$trp = new TriRunProvider($this->DB, $this->athlete, $mcp->getTrainingTime($genWeek, 'RUN'), $phase);
				$runWorkouts = $trp->generate($genWeek);
				$trp->save();
				break;
			case 'RUN':
				$trp = new TriRunProvider($this->DB, $this->athlete, $mcp->getTrainingTime($genWeek, 'RUN'), $phase);
				$runWorkouts = $trp->generate($genWeek);
				$trp->save();
				break;
			case 'BIKE':
            	$bikeWorkouts = array (
					new BikeWorkout($this->athlete, 'E1', $mcp->getTrainingTime($genWeek, 'BIKE')));
				break;
			default:
				break;
		}
		
		$workouts = array_merge($swimWorkouts, $bikeWorkouts, $runWorkouts);

		$html = "<h1>Week " . $genWeek->format("d.m.Y") . " (" . $phase["phase"] . ")</h1>";
		$html .= WorkoutRenderer::render($workouts);
		
		// also attach time and workout settings
		$html .= $this->getJSWorkoutSettings($genWeek->format("Y-m-d"), $this->athlete->getId()); 
		return $html;
	}
	
	private function getJSWorkoutSettings($date, $userId) {
		$sql = "SELECT time, usertime, ratio, date FROM mesocyclephases WHERE athlete_id = $userId AND date = '$date'";
		$res = $this->DB->query($sql);
		if (count($res) != 1) {
			throw new Exception("Unexpected number of results in query '$sql'");
		}
		
		if ($res[0]["ratio"] != "") {
			$ratio = "[" . implode(",", explode(":", $res[0]["ratio"])) . "]";
		} else {
			$ratio = "[" . RATIO_TRIATHLON . "]";
		}
		
		return "<script type=\"text/javascript\">var workoutSettings = {
			time : " . $res[0]["time"] . ",
			usertime : " . $res[0]["usertime"] . ",
			ratio : $ratio,
			date : '" . $res[0]["date"] . "'
		};</script>";
	}
	 
	public function renderMesoCycle($date, $athleteId) {
		$res = $this->DB->query("SELECT time, phase, 
			(SELECT MAX(time) FROM mesocyclephases WHERE date >= '$date' AND athlete_id = $athleteId) max
			FROM mesocyclephases WHERE date >= '$date' AND athlete_id = $athleteId LIMIT 10");
		
		$html = "<div class='mesocycle'>";
		while (list($k, $v) = each($res)) {
			$h = intval($v["time"] / 4 );
			$p = intval(($v["max"] - $v["time"]) / 4);
			$html .= '<div style="height: ' . $h . 
				'px; margin-top: ' . $p . 'px">' . 
				$v["phase"] . '</div>';
		}
		$html .= "</div>";
		return $html;
	}
	
	/**
	 * persist workout settings to the database
	 * time, usertime and ratio settings
	 * @param $data
	 */
	public function saveWorkoutSettings($data) {
		$user = $this->Session->read('userobject');
		if ($data["time"] && $data["usertime"] && $data["ratio"] && $data["date"]) {
			// update time setting first
			$rows1 = $this->DB->query("UPDATE mesocyclephases SET usertime = " . intval($data["usertime"]) . 
				" WHERE athlete_id = " . $user["id"] . " AND date = '" . 
				mysql_escape_string($data["date"]). "'");
			// now save ratio
			$rows2 = $this->DB->query("UPDATE mesocyclephases SET ratio = '" . mysql_escape_string($data["ratio"]) . 
				"' WHERE athlete_id = " . $user["id"] . " AND date >= '" . 
				mysql_escape_string($data["date"]). "'");
				
			//if ($rows1 == 1 && $rows2 >= 1) {
				// TODO validate if updates were successful
				return true;
			//}
		}
		return false;
	}
	
	public function purge() {
			
	}
	
	/**
	 * calculates training time variation for a given amount of minutes
	 * will return an array containing min and max training time in minutes
	 * @param $minutes of training time
	 * @return array of min and max training time
	 */
	public function calcTrainingTimeVariation($minutes) {
		$ret = array("min" => 0, "max" => 0);
		$ret["min"] = intval($minutes * MesoCyclePhaseTableProvider::$TRAINING_TIME_FACTORS["BUILD1_RECOVERY"][0]);
		$ret["max"] = intval($minutes * MesoCyclePhaseTableProvider::$TRAINING_TIME_FACTORS["BASE3"][2]);
		return $ret;
	}
	
	/**
	 * retrieve multisport type from an athlete's typeofsport field
	 * for TRIATHLON IRONMAN it will be TRIATHLON
	 * for DUATHLON MIDDLE it will be DUATHLON
	 * for RUN ULTRA it will just be RUN
	 */
	public function getMultisportType($typeofsport) {
		switch ($typeofsport) {
			case 'TRIATHLON IRONMAN':
			case 'TRIATHLON HALFIRONMAN':
			case 'TRIATHLON OLYMPIC':
			case 'TRIATHLON SPRINT':
				return 'TRIATHLON';
				break;
            case 'DUATHLON MIDDLE':
            case 'DUATHLON SHORT':
            	return 'DUATHLON';
            	break;
			case 'RUN ULTRA':
			case 'RUN MARATHON':
			case 'RUN HALFMARATHON':
            case 'RUN 10K':
			case 'RUN 5K':
				return 'RUN';
				break;
			case 'BIKE ULTRA':
			case 'BIKE LONG':
 			case 'BIKE MIDDLE':
            case 'BIKE SHORT':
            	return 'BIKE';
            	break;
            default:
            	throw new Exception("Unknown multisport type $typeofsport");
				break;
		}
	}
	
	/**
	 * this will recalculate the training time track, which is needed when
	 * the user changes his average workout hours to fit his weekly
	 * training hours
	 */
	public function recalcTimes() {
		MesoCyclePhaseTableProvider::recalcTimes($this->DB, $this->athlete);
	}
}

?>