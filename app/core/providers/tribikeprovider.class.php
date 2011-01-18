<?php
/**
 * the TriBikeProvider provides triathlon-specific bike workouts
 * @author clemens
 */
class TriBikeProvider extends WorkoutProvider {
	protected $SPORT = 'BIKE';

	/**
	 * (non-PHPdoc)
	 * @see WorkoutProvider::generateLSDWorkout()
	 */
	protected function generateLSDWorkout(Race $ldRace) {
		$duration = BikeWorkout::$LSD_TIMES[$this->athlete->getLevel()]
			[$ldRace->getWeeksTillRaceday($this->generateWeek)];
		if ($duration == 0) {
			return false;
		}
		return new BikeWorkout($this->athlete, Workout::E2, $duration, true);
	}

	/**
	 * (non-PHPdoc)
	 * @see WorkoutProvider::generateTestWorkout()
	 */
	protected function generateTestWorkout() {
		$ldRace = $this->athlete->getSchedule()->getNextLDRace($this->generateWeek);

		// if the athlete got a long distance race defined
		// we let him do long test workouts
		if ($ldRace) {
			return new BikeWorkout($this->athlete, Workout::TEST_LONG, 60);
		} else {
			return new BikeWorkout($this->athlete, Workout::TEST_SHORT, 30);
		}
	}
	
	/**
	 * (non-PHPdoc)
	 * @see WorkoutProvider::getWorkoutTypeSequence()
	 */
	protected function getWorkoutTypeSequence(Database $DB, $phase, Athlete $athlete, DateTime $week) {
		return new TriBikeWorkoutTypeSequence(
			$this->DB, $this->phase["phase"], $this->athlete, $week);
	}
	
	/**
	 * (non-PHPdoc)
	 * @see WorkoutProvider::newWorkout()
	 */
	protected function newWorkout($type, $duration) {
		return new BikeWorkout($this->athlete, $type, $duration);
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
				switch($distance) {
					case "SPRINT":
						$d = 40;
						break;
					case "SHORT";
						$d = 60;
						break;
					case "MIDDLE":
						$d = 90;
						break;
					case "LONG":
						$d = 120;
						break;
				}
				break;
			case "E2":
				switch($distance) {
					case "SPRINT":
						$d = 100;
						break;
					case "SHORT";
						$d = 110;
						break;
					case "MIDDLE":
						$d = 150;
						break;
					case "LONG":
						$d = 200;
						break;
				}
				break;
			case "E3":
				switch($distance) {
					case "SPRINT":
						$d = 45;
						break;
					case "SHORT";
						$d = 60;
						break;
					case "MIDDLE":
						$d = 120;
						break;
					case "LONG":
						$d = 160;
						break;
				}
				break;
			// F-type and S-type workouts are quite harsh, 
			// so I'll keep them a bit shorter
			case "F1":
			case "F2":
			case "F3":
			case "S1":
			case "S2":
			case "S3":
				switch($distance) {
					case "SPRINT":
						$d = 30;
						break;
					case "SHORT";
						$d = 40;
						break;
					case "MIDDLE":
						$d = 90;
						break;
					case "LONG":
						$d = 120;
						break;
				}
				break;
			case "M1":
			case "M2":
			case "M3":
			case "M4":
			case "M5":
				switch($distance) {
					case "SPRINT":
						$d = 30;
						break;
					case "SHORT";
						$d = 50;
						break;
					case "MIDDLE":
						$d = 90;
						break;
					case "LONG":
						$d = 120;
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
}
?>