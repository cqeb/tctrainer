<?php
/**
 * the TriSwimProvider provides triathlon-specific swim workouts
 * @author clemens
 */
class TriSwimProvider extends WorkoutProvider {
	
	protected $SPORT = 'SWIM';

	/**
	 * (non-PHPdoc)
	 * @see WorkoutProvider::generateLSDWorkout()
	 */
	protected function generateLSDWorkout(Race $ldRace) {
		$duration = SwimWorkout::$LSD_TIMES[$this->athlete->getLevel()]
			[$ldRace->getWeeksTillRaceday($this->generateWeek)];
		if ($duration == 0) {
			return false;
		}
		return new SwimWorkout($this->athlete, Workout::E2, $duration, true);
	}

	/**
	 * (non-PHPdoc)
	 * @see WorkoutProvider::generateTestWorkout()
	 */
	protected function generateTestWorkout() {
		return false;
	}
	
	/**
	 * (non-PHPdoc)
	 * @see WorkoutProvider::getWorkoutTypeSequence()
	 */
	protected function getWorkoutTypeSequence(Database $DB, $phase, Athlete $athlete, DateTime $week) {
		return new TriSwimWorkoutTypeSequence(
			$this->DB, $this->phase["phase"], $this->athlete, $week);
	}
	
	/**
	 * (non-PHPdoc)
	 * @see WorkoutProvider::newWorkout()
	 */
	protected function newWorkout($type, $duration, $lsd=false) {
		return new SwimWorkout($this->athlete, $type, $duration, $lsd);
	}

	/**
	 * (non-PHPdoc)
	 * @see WorkoutProvider::getDuration()
	 */
	protected function getDuration($trainingType, $raceType) {
		// the determined duration
		$d = -1;
		$distance = Race::getDistanceClass($raceType);
		switch($trainingType) {
			case "E1":
			case "E2":
			case "E3":
			case "F1":
			case "F2":
			case "F3":
			case "S1":
			case "S2":
			case "S3":
			case "M1":
			case "M2":
			case "M3":
				switch($distance) {
					case "SPRINT":
						$d = 30;
						break;
					case "SHORT";
						$d = 40;
						break;
					case "MIDDLE":
						$d = 60;
						break;
					case "LONG":
						$d = 90;
						break;
				}
				break;
		}

		// apply modificator past trainings
		$m = $this->getModificator($trainingType);
		$d = $d * $m;
		
		// TODO apply personal modificator for this kind of training

		// check if we've got a duration or if there is a typo in the spec above
		if ($d == -1) {
			throw new Exception("Could not determine training duration for training type " .
				"{$trainingType}, race type {$raceType}, distance {$distance}");
		}

		// round to nearest five
		$d = round($d / 5) * 5;
		return $d;
	}
	
	/**
	 * (non-PHPdoc)
	 * @see WorkoutProvider::isSportMatching()
	 */
	protected function isSportMatching(Race $race) {
		$t = substr($race->getType(), 0, 3);
		if ($t === 'TRI') {
			return true;
		} else {
			return false;
		}
	}
}
?>