<?php
/**
 * a provider provides workouts of a specific type
 * this class implements a template method pattern
 * within the generate() function, so have a look
 * if you want to extend it
 * @author clemens
 */
abstract class WorkoutProvider {
	/**
	 * the athlete
	 */
	protected $athlete;
	/**
	 * minutes for this provider
	 */
	protected $timeBudget;
	
	/**
	 * accumulated workout duration
	 */
	protected $workoutDurations = 0;
	
	/**
	 * the phase array we're in
	 * @var array
	 */
	protected $phase;
	
	/**
	 * array of generated workouts
	 */
	protected $workouts = array();
	
	/**
	 * date the plan was generated for
	 * @var DateTime
	 */
	protected $generateWeek;
	
	/**
	 * the sport type the provider is made for
	 * OVERRIDE that if you extend this class!
	 * @var String
	 */
	protected $SPORT = null;
	
	/**
	 * bytecache for getModificator()
	 * @var array
	 */
	protected $modificatorCount = array(
		"E1" => 0,
		"E2" => 0,
		"E3" => 0,
		"F1" => 0,
		"F2" => 0,
		"F3" => 0,
		"S1" => 0,
		"S2" => 0,
		"S3" => 0,
		"M1" => 0,
		"M2" => 0,
		"M3" => 0,
		"M4" => 0,
		"M5" => 0,
		"initialized" => false // flag wether the cache has been initialized yet
	);
	
	/**
	 * the constructor has to be initialized with the weekly hours available,
	 * and the current phase we're in (Base1, Buid2, etc.)
	 * @param Database $DB database object
	 * @param Integer $timeBudget time budget for this provider measured in MINUTES
	 * @param Array $phase phase array as generated from mesocycleprovider
	 */
	public function __construct(Database $DB, Athlete $athlete, $timeBudget, $phase) {
		$this->DB = $DB;
		$this->athlete = $athlete;
		$this->timeBudget = $timeBudget; // MINUTES!
		$this->phase = $phase;
	}
	
	/**
	 * add a workout as long as the hour budget will tolerate it
	 * @param Workout $workout
	 * @param boolean $checkTime set to false if time budget should not be checked. 
	 * 		Just meant to be used for adding test and lsd workouts
	 * @return boolean false if no workouts can be added anymore, true if everything is fine
	 */
	protected function addWorkout(Workout $workout, $checkTime=true) {
		// there is no budget left, so we won't add this workout
		if ($checkTime && $this->workoutDurations >= $this->timeBudget) {
			throw new Exception("Not enough timeBudget left to add workout");
		}
		
		$this->workoutDurations += $workout->getDuration();
		$this->workouts[] = $workout;
		
		// TODO apply downscaling / fallback
		// if the workout is too long to fit the time budget
		// we'll make it fit by subtracting overtime.
		// if this drops the workout length to less than 30 minutes
		// we'll just drop it
		$openTime = $this->timeBudget - $this->workoutDurations;
		
		// oops - we've spent more time than we have (once again...)
		if ($openTime < 0) {
			$lastWorkout = $this->workouts[(count($this->workouts) - 1)];
			$lastWorkout->setDuration(
				$lastWorkout->getDuration() + $openTime // remember: openTime is negative!
			);
			
			// now check if the last workout is still long enough
			if ($lastWorkout->getDuration() < 30) {
				array_pop($this->workouts);
			}
			
			// TODO maybe we should readd the cleared points to the time budget?
			
			// since we just deleted the last workout we have to return false
			return false;
		}
		return true;
	}
	
	/**
	 * generates a lsd workout for a specific race
	 * @param Race $ldRace the next long-distance race
	 * @return Workout a workout or false
	 */
	protected abstract function generateLSDWorkout(Race $ldRace);
	
	/**
	 * generates a test workout to assess your training status
	 * @return Workout a workout or false
	 */
	protected abstract function generateTestWorkout();
	
	/**
	 * Retrieve the specific workouttypesequence for this sport
	 * like TriRunWorkouttypeSequence for running
	 *
	 * @param Database $DB db reference
	 * @param String $phase current phase
	 * @param Athlete $athlete athlete reference
	 * @param DateTime $week current week
	 * @return Sequence a workout sequence
	 */
	protected abstract function getWorkoutTypeSequence(Database $DB, $phase, Athlete $athlete, DateTime $week);
	
	/**
	 * determine workout duration based on
	 * - next A race, or your training target (Ironman, Half Marathon, ...)
	 * - personal modificator
	 * - the training type
	 * - past utilization of a specific training type (increase duration for repaetently used trainings)
	 * @param String $type training type like E1...
	 * @param String $raceType identifier like TRIATHLON_IRONMAN
	 * @return int workout duration in minutes
	 */
	protected abstract function getDuration($trainingType, $raceType);
	
	/**
	 * generate a new workout of an appropriate type
	 * @param String $type the workout type like E1...
	 * @param int $duration in minutes
	 * @return Workout
	 */
	protected abstract function newWorkout($type, $duration);
	
	/**
	 * generate workouts based on the provider class
	 * 
	 * this is our base method for the template method pattern.
	 * the function will first check for the athlete's next
	 * a race, and generate an lsd workout. then a new workout-
	 * typesequence is instantiated, and workouts are added.
	 * the duation is retrieved from getDuration().
	 * 
	 * This is the invocation sequence that is used.
	 * 
	 * $this->generateLSDWorkout()
	 * $this->generateTestWorkout()
	 * $this->getWorkoutTypeSequence()
	 * $this->getDuration()
	 * 
	 * @param DateTime $week generate the workout for a given week which starts at date
	 * @return unknown_type
	 */
	public final function generate(DateTime $week) {
		$this->generateWeek = $week;
		$nextA = $this->athlete->getSchedule()->getNextARace($week);

		// determine if LSD run is needed
		$ldRace = $this->athlete->getSchedule()->getNextLDRace($week);

		// lsd trainings start 12 weeks before the event
		if ($ldRace && $ldRace->getWeeksTillRaceday($week) <= 12) {
			$lsdWorkout = $this->generateLSDWorkout($ldRace);
			if ($lsdWorkout) {
				$this->addWorkout($lsdWorkout, false);
			}
		}
		
		// add a test workout if this is a recovery week
		if ($this->phase["recovery"]) {
			$testWorkout = $this->generateTestWorkout();
			if ($testWorkout) {
				$this->addWorkout($testWorkout, false);
			}
		}
		
		// distribute remaining minutes as long as there are some
		$wType = $this->getWorkoutTypeSequence(
			$this->DB, $this->phase["phase"], $this->athlete, $week
		);

		$i = 0;
		while ($this->timeBudget > $this->workoutDurations) {
			$i++;
			$type = $wType->next();
			$duration = $this->getDuration($type, $nextA->getType());
			$this->addWorkout($this->newWorkout($type, $duration));
			if ($i == 100) {
				throw new Exception("Provider generated 100 Workouts - " .
					"looks like an endless loop");
			}
		}

		// finally persist the sequences
		$wType->save();
		return $this->workouts;
	}
	
	/**
	 * stores generated workouts back to the database
	 * @param $purge wether to purge old trainings of this week. defaults to true
	 */
	public function save($purge=true) {
		if (count($this->workouts) == 0) {
			return false;
		}
		$week = $this->generateWeek->format("Y-m-d");

		$sql = "INSERT INTO scheduledtrainings (athlete_id, week, sport, type, duration, lsd, trimp) VALUES\n";
		
		$sqlArr = array();
		reset($this->workouts);
		while (list($k, $w) = each($this->workouts)) {
			$sqlArr[] = "(" . $this->athlete->getId() . ", '" .
				$week . "', '" .
					$w->getSport() . "', " .
				"'" . $w->getType() . "', " . $w->getDuration() . ", " . 
				intval($w->isLsd()) . ", " . $w->getTRIMP() . ")";
		}
		
		$sql .= implode(",\n", $sqlArr);

		// delete old entries first
		if ($purge) {
			$delSql = "DELETE FROM scheduledtrainings WHERE athlete_id = " .
				$this->athlete->getId() . " AND week = '$week'";
			$this->DB->query($delSql);
		}
		
		// now save new ones
		$this->DB->query($sql);
	}

	/**
	 * calculates a training modificator based on the past 
	 * utilization (last 4 weeks) of a specific training type
	 * @param String $type training type like E1, S2, ...
	 * @return double training modificator like 1.3 or 1.05
	 */
	protected function getModificator($type) {
		// test workouts will not be modified
		if ($type == "TS" || $type == "TL") {
			return 1;
		}
		
		// prefill cache if it has not been initialized yet
		if (!$this->modificatorCount["initialized"]) {
			$lastWeek = clone $this->generateWeek;
			$lastWeek = $lastWeek->sub(new DateInterval("P7D"))->format("Y-m-d");
			
			// time frame is from last week 4 weeks back; exclude PREP & TRANS phases 
			$sql = "SELECT s.type, count(*) c FROM scheduledtrainings s
				INNER JOIN mesocyclephases m ON s.week = m.date 
				WHERE s.sport = '{$this->SPORT}'
				AND m.phase != 'PREP'
				AND m.phase != 'TRANS'
				AND s.week >= date_sub('$lastWeek', INTERVAL 4 WEEK)
				AND s.week <= '$lastWeek'
				GROUP BY type";

			$res = $this->DB->query($sql);
			if ($res) {
				while(list($k,$v) = each($res)) {
					$this->modificatorCount[$v["type"]] = intval($v["c"]);
				}
			}
			$this->modificatorCount["initialized"] = true;
		}
		
		$modificator = 1 + ($this->modificatorCount[$type] * 0.1);
		$this->modificatorCount[$type]++;
		return $modificator;
	}
}
?>