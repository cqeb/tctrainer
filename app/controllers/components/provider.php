<?php
// include all core components

// TODO this is just plain ugly with cake - find a better solution for this
require_once ROOT . DS . APP_DIR . '/core/athlete/athlete.class.php';
require_once ROOT . DS . APP_DIR . '/core/helpers/database.class.php';
require_once ROOT . DS . APP_DIR . '/core/helpers/datetimehelper.class.php';
require_once ROOT . DS . APP_DIR . '/core/providers/workoutprovider.class.php';
require_once ROOT . DS . APP_DIR . '/core/providers/mesocyclephasetableprovider.class.php';
require_once ROOT . DS . APP_DIR . '/core/providers/mesocycleprovider.class.php';
require_once ROOT . DS . APP_DIR . '/core/providers/trirunprovider.class.php';
require_once ROOT . DS . APP_DIR . '/core/providers/tribikeprovider.class.php';
require_once ROOT . DS . APP_DIR . '/core/providers/triswimprovider.class.php';
require_once ROOT . DS . APP_DIR . '/core/schedule/schedule.class.php';
require_once ROOT . DS . APP_DIR . '/core/schedule/race.class.php';
require_once ROOT . DS . APP_DIR . '/core/sequences/sequence.class.php';
require_once ROOT . DS . APP_DIR . '/core/sequences/workouttypesequence.class.php';
require_once ROOT . DS . APP_DIR . '/core/sequences/trirunworkouttypesequence.class.php';
require_once ROOT . DS . APP_DIR . '/core/sequences/tribikeworkouttypesequence.class.php';
require_once ROOT . DS . APP_DIR . '/core/sequences/triswimworkouttypesequence.class.php';
require_once ROOT . DS . APP_DIR . '/core/workouts/workout.class.php';
require_once ROOT . DS . APP_DIR . '/core/workouts/swimworkout.class.php';
require_once ROOT . DS . APP_DIR . '/core/workouts/bikeworkout.class.php';
require_once ROOT . DS . APP_DIR . '/core/workouts/runworkout.class.php';
require_once ROOT . DS . APP_DIR . '/core/renderers/workoutrenderer.class.php';
require_once ROOT . DS . APP_DIR . '/config/database.php';


class ProviderComponent extends Object {
	public $components = array('Session', 'Unitcalc');
	public $helpers = array('Session');
	private $DB;
	private $athlete;
	
	/**
	 * initializes the provider component
	 * @param unknown_type $controller not needed
	 * @param unknown_type $settings not needed
	 */
	public function initialize($controller, $settings) {
                $config = new DATABASE_CONFIG();
                $this->DB = new Database($config->default['login'],$config->default['password'],$config->default['database'],$config->default['host']);
	}
	
	/**
	 * retrieve the athlete
	 */
	public function getAthlete( $athlete_id = null ) {

		if (!$this->athlete) {		
			$this->athlete = new Athlete($this->DB, $this->Session->read('userobject'));
		}

		return $this->athlete;
	}
	
	/**
	 * get a plan
	 */
	public function getPlan($html_output = true) {
		// cut preview time to a maximum of 3 weeks
		if (array_key_exists('o', $_GET) && intval($_GET['o']) > 3 && !$this->getAthlete()->isAdvancedFeatures()) {
			$_GET['o'] == 3;
		}
		
		if (!$this->getAthlete()->isValid()) {
			return '<div class="statusbox error"><p>' .
				__("Sorry, you are not eligible to receive training plans as your PREMIUM membership has expired or you resigned our terms and conditions.", true) . 
				'</p><button onclick="document.location=\'/trainer/payments/subscribe_triplans\'">' .
				__('Become PREMIUM', true) . 
				'</button></div>' . 
				"<script type=\"text/javascript\">
					$('#plan').fadeTo('#normal', 1);
					$('#loader, #toggleDesc, #prev, #next').hide();
				</script>";
		}
		

		// start benchmark timer		
		$timerStart = microtime(true);
		
		$genWeek = DateTimeHelper::getWeekStartDay(new DateTime());

		if (isset($_GET['o'])) {
			$offset = intval($_GET['o']) * 7;
			if ($offset >= 0) {
				$genWeek->add(new DateInterval("P" . $offset . "D"));
			} else {
				$genWeek->sub(new DateInterval("P" . ($offset * -1) . "D"));
			}
		}
		
		// generate mesocycle
		$mcp = new MesoCycleProvider($this->DB, $this->getAthlete(), clone $genWeek);
		$time = $mcp->getTrainingTime($genWeek);

		// now generate workouts
		$phase = $mcp->getPhase($genWeek);
		
		$swimWorkouts = array();
		$bikeWorkouts = array();
		$runWorkouts = array();
		
		switch($this->getMultisportType($this->getAthlete()->getSport())) {
			case 'TRIATHLON':
				$tsp = new TriSwimProvider($this->DB, $this->getAthlete(), $mcp->getTrainingTime($genWeek, 'SWIM'), $phase);
				$swimWorkouts = $tsp->generate($genWeek);
				$tsp->save(); 
				
				$tbp = new TriBikeProvider($this->DB, $this->getAthlete(), $mcp->getTrainingTime($genWeek, 'BIKE'), $phase);
				$bikeWorkouts = $tbp->generate($genWeek);
				$tbp->save(); 

				$trp = new TriRunProvider($this->DB, $this->getAthlete(), $mcp->getTrainingTime($genWeek, 'RUN'), $phase);
				$runWorkouts = $trp->generate($genWeek);
				$trp->save();
				break;
            case 'DUATHLON':
            	$tbp = new TriBikeProvider($this->DB, $this->getAthlete(), $mcp->getTrainingTime($genWeek, 'BIKE'), $phase);
				$bikeWorkouts = $tbp->generate($genWeek);
				$tbp->save();
				
				$trp = new TriRunProvider($this->DB, $this->getAthlete(), $mcp->getTrainingTime($genWeek, 'RUN'), $phase);
				$runWorkouts = $trp->generate($genWeek);
				$trp->save();
				break;
			case 'RUN':
				$trp = new TriRunProvider($this->DB, $this->getAthlete(), $mcp->getTrainingTime($genWeek, 'RUN'), $phase);
				$runWorkouts = $trp->generate($genWeek);
				$trp->save();
				break;
			case 'BIKE':
            	$tbp = new TriBikeProvider($this->DB, $this->getAthlete(), $mcp->getTrainingTime($genWeek, 'BIKE'), $phase);
				$bikeWorkouts = $tbp->generate($genWeek);
				$tbp->save();
				break;
			default:
				break;
		}
		
		$workouts = array_merge($swimWorkouts, $bikeWorkouts, $runWorkouts);

		// sort those workouts by trimp
		uasort($workouts, 'ProviderComponent::sortWorkouts');
		
		// link workouts to completed trainings
		$workouts = $this->linkWorkouts($workouts, $genWeek);
		
		$html = "<h1>" . __("Week", true) . " " . 
			$this->Unitcalc->check_date($genWeek->format("Y-m-d")) . 
			"</h1>";
		
		switch (substr($phase['phase'],0,4)) {
			case "PREP":
				$phaseName = __('Preparative Training', true);
				break;
			case "BUIL":
				$phaseName = __('Progressive Training', true);
				break;
			case "PEAK":
				$phaseName = __('Peak Training', true);
				break;
			case "RACE":
				$phaseName = __('Race Week', true);
				break;
			case "BASE":
			default:
				$phaseName = __('Basic Training', true);
				break;
		}

		$html .= '<p id="phaseinfo">' . $phaseName;
		if ($phase['recovery']) {
			$html .= ' (' . __('Recovery Week', true) . ')';
		}
		$html .= "</p>";
		
		$html .= WorkoutRenderer::render($workouts, $this->getAthlete());
		
		// also attach time and workout settings
		$html .= $this->getJSWorkoutSettings($genWeek->format("Y-m-d"), $this->getAthlete()->getId()); 
		
		// add generate time
		$benchmarkTime = microtime(true) - $timerStart;
		//$html .= "\n<!-- generated in {$benchmarkTime}s -->\n";

		if ( $html_output != true ) {
			WorkoutRenderer::render_events($workouts, $this->getAthlete(), $time, $phase, $genWeek);
		} else
			return $html;			
	}
	
	/**
	 * link trainings from the plan to completed trainings of this week
	 * @param array $workouts array of workouts in the plan
	 * @param DateTime $week training plan week start day
	 * @return array of workouts with reference to a completed training
	 */
	private function linkWorkouts($workouts, $week) {
		$trainings = $this->DB->query("SELECT id, sportstype, workouttype
			FROM trainingstatistics
			WHERE date >= '" . $week->format("Y-m-d") . "' 
			AND date < DATE_ADD('" . $week->format("Y-m-d") . "', INTERVAL 1 WEEK)
			AND workouttype != ''
			AND user_id = " . $this->athlete->getId());
		
		if (count($trainings) === 0) {
			return $workouts;
		}
		
		// now match registered trainings to workouts
		reset($workouts);
		while (list($k, $w) = each(&$workouts)) {
			reset($trainings);
			while (list($l, $t) = each($trainings)) {
				if ($t['sportstype'] === $w->getSport() &&
					$t['workouttype'] === $w->getType()) {
					$w->setTrainingId($t['id']);
					unset($trainings[$l]);
				}
			}
			
			// return if all trainings have been assigned
			if (count($trainings) === 0) {
				return $workouts;
			}
		}

		return $workouts;
	}
	
	/**
	 * this will sort workouts by their trimp value
	 * meant to be used with uasort
	 * @param Workout $a
	 * @param Workout $b
	 */
	public static function sortWorkouts(Workout $a, Workout $b) {
		// lsd workouts have highest pri
		if ($a->isLsd() && $b->isLsd()) {
			return 0;
		} else if ($a->isLsd() && !$b->isLsd()) {
			return -1;
		} else if (!$a->isLsd() && $b->isLsd()) {
			return 1;
		}
		
		// no special attention paid to test workouts here
		// because you don't absolutely HAVE to do them
		
		// ... then just compare by trimp values
		if ($a->getTRIMP() == $b->getTRIMP()) {
        	return 0;
    	}
    	return ($a->getTRIMP() < $b->getTRIMP()) ? 1 : -1;
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
		
		// TODO handle invalid ratio values here!
		
		return "<script type=\"text/javascript\">var workoutSettings = {
			time : " . $res[0]["time"] . ",
			usertime : " . $res[0]["usertime"] . ",
			ratio : $ratio,
			date : '" . $res[0]["date"] . "'
		};</script>";
	}
	 
	public function renderMesoCycle($date, $athleteId) {
		$res = $this->DB->query("SELECT time, date, phase, 
			(SELECT MAX(time) FROM mesocyclephases WHERE date >= '$date' AND athlete_id = $athleteId) max
			FROM mesocyclephases WHERE date >= '$date' AND athlete_id = $athleteId LIMIT 10");
		
		$html = "<div class='mesocycle'>";
		while (list($k, $v) = each($res)) {
			$h = intval($v["time"] / 4 );
			$w = intval(400/count($res));
			$p = intval(($v["max"] - $v["time"]) / 4);
			$html .= '<div style="height: ' . $h . 
				'px; width: ' . $w . 'px; margin-top: ' . $p . 'px; size:4px;" class="' . $v["phase"] . '">' . 
				$v["phase"] . '<br />' . intval($v["time"]/60) . ' h</div>';
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
	
	/**
	 * check if a new competition is to be added in the timespan till
	 * the nearest competition is scheduled. Meant to be called BEFORE
	 * the new competition is added to the database.
	 * @param string $date of the competition to be added or deleted. supply
	 * 		ISO timestamp value
	 * @param string $type of the competition
	 * @return false if nothing was purged 
	 */
	public function smartPurgeOnSave($date, $type) {
		// check if earlier entry exists
		$r = $this->DB->query("SELECT COUNT(*) c FROM competitions 
			WHERE competitiondate < '$date'
			AND user_id = " . $this->getAthlete()->getId());
		if ($r[0]['c'] > 0) {
			// there are earlier entries - do not purge
			//return false;
		}			

		// select if same entry already exists and nothing important changed
		$r = $this->DB->query("SELECT COUNT(*) c FROM competitions 
			WHERE competitiondate = '$date' AND sportstype = '$type'
			AND user_id = " . $this->getAthlete()->getId());
		if ($r[0]['c'] > 0) {
			// same entry exists - do not purge
			return false;
		}			

		// now check if the entry is before our earliest entry to date
		$r = $this->DB->query("SELECT COUNT(*) c FROM competitions 
			WHERE competitiondate > NOW()
			AND competitiondate < '$date'
			AND user_id = " . $this->getAthlete()->getId());
		if ($r[0]['c'] > 0) {
			// there is an earlier entry - do not purge
			//return false;
		}
		
		// it seems all checks failed, so we have to purge
		return $this->purge();
	}
	
	/**
	 * check if a new competition is to be delete in the timespan before
	 * the nearest competition is scheduled. Meant to be called BEFORE
	 * the new competition is deleted from the database.
	 * @param integer $id of the competition to be deleted
	 * @return false if nothing was purged 
	 */
	public function smartPurgeOnDelete($id) {
		// now check if the entry is before our earliest entry to date
		$r = $this->DB->query("SELECT COUNT(*) c FROM competitions 
			WHERE competitiondate > NOW()
			AND competitiondate < (
				SELECT competitiondate FROM competitions
				WHERE id = " . intval($id) . " 
				AND user_id = " . $this->getAthlete()->getId() . "
			)
			AND user_id = " . $this->getAthlete()->getId());
		if (array_key_exists('c', $r) && $r['c'] > 0) {
			// there is an earlier entry - do not purge
			return false;
		}
		
		// it seems all checks failed, so we have to purge
		return $this->purge();
	}
	
	/**
	 * internal purge function which will wipe the mesocycle and trainings
	 * only meant to be called from Provider::smartPurge()
	 */
	private function purge() {
		$date = DateTimeHelper::getWeekStartDay(new DateTime())->format("Y-m-d");
		$this->DB->query("DELETE FROM mesocyclephases WHERE date >= '$date' 
			AND athlete_id = " . $this->getAthlete()->getId());
		$this->DB->query("DELETE FROM scheduledtrainings WHERE week >= '$date' 
			AND athlete_id = " . $this->getAthlete()->getId());
		$this->DB->query("DELETE FROM trirunworkouttypesequence WHERE week >= '$date' 
			AND athlete_id = " . $this->getAthlete()->getId());
		$this->DB->query("DELETE FROM tribikeworkouttypesequence WHERE week >= '$date' 
			AND athlete_id = " . $this->getAthlete()->getId());
		$this->DB->query("DELETE FROM triswimworkouttypesequence WHERE week >= '$date' 
			AND athlete_id = " . $this->getAthlete()->getId());
		return true;
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
		MesoCyclePhaseTableProvider::recalcTimes($this->DB, $this->getAthlete());
	}
}

?>