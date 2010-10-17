<?php
/**
 * a provider provides workouts of a specific type
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
	 * @param unknown_type $workout
	 * @return boolean false if no workouts can be added anymore, true if everything is fine
	 */
	protected function addWorkout(Workout $workout) {
		// there is no budget left, so we won't add this workout
		if ($this->workoutDurations >= $this->timeBudget) {
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
	 * generate workouts based on the provider class
	 * @param DateTime $week generate the workout for a given week which starts at date
	 * @return unknown_type
	 */
	public abstract function generate(DateTime $week);
	
	/**
	 * stores generated workouts back to the database
	 */
	public function save() {
		if (count($this->workouts) == 0) {
			return false;
		}
		$week = $this->generateWeek->format("Y-m-d");
		$delSql = "DELETE FROM scheduledtrainings WHERE athlete_id = " .
			$this->athlete->getId() . " AND week = '$week'";
		
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
		$this->DB->query($delSql);
		
		// now save new ones
		$this->DB->query($sql);
	}
}
?>