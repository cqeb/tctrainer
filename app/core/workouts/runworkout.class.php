<?php 
/**
 * run workout
 * @author clemens
 *
 */
class RunWorkout extends Workout {
	/**
	 * this identifies the workout as a run workout in the database
	 * @var string
	 */
	public static $SPORT = "RUN";
	
	/**
	 * array of lsd-training duration in minutes
	 * the array key represents the weeks to go, so week 0
	 * is the race-week and thus identified by key 0 while
	 * week 7 is the 7th week before the race, and thus
	 * identified by key 7
	 */
	public static $LSD_TIMES = array(
		Athlete::BEGINNER => array (0, 180, 180, 0, 165, 150, 0, 135, 120, 0, 105, 95),
		Athlete::ADVANCED => array (0, 180, 180, 0, 180, 180, 0, 165, 165, 0, 150, 150)		
	);
	
	public function getTypeLabel() {
		switch ($this->type) {
			case Workout::E1:
				return 'Recovery';
				break;
			case Workout::E2:
				return 'Extensive Endurance';
				break;
			case Workout::E3:
				return 'Intensive Endurance';
				break;
			case Workout::S1:
				return 'Strides';
				break;
			case Workout::S2:
				return 'Pickups';
				break;
			case Workout::F1:
				return 'Moderate Hills';
				break;
			case Workout::F2:
				return 'Long Hills';
				break;
			case Workout::F3:
				return 'Hill Reps';
				break;
			case Workout::M1:
				return 'Tempo';
				break;
			case Workout::M2:
				return 'Cruise Intervals';
				break;
			case Workout::M3:
				return 'Hill Cruise Intervals';
				break;
			case Workout::M4:
				return 'Criscross Threshold';
				break;
			case Workout::M5:
				return 'Threshold';
				break;
			default:
				return 'UNKNOWN';
				break;
		}
	}
	
	// TODO an athlete's historical workout data should aeffect the return val
	// TODO review these values - they seem arbitrary & bogus
	public function getAVGHR(Athlete $athlete) {
		// zones
		$z = $athlete->getZones($this->getSport());
		switch ($this->type) {
			case Workout::E1:
				return intval(($z[0] + $z[1]) / 2);
				break;
			case Workout::E2:
				return $z[1] + 3;
				break;
			case Workout::E3:
				return $z[3] - 5;
				break;
			case Workout::S1:
				return $z[2];
				break;
			case Workout::S2:
				return $z[2] + 3;
				break;
			case Workout::F1:
				return $z[3] - 4;
				break;
			case Workout::F2:
				return $z[3];
				break;
			case Workout::F3:
				return $z[3] + 5;
				break;
			case Workout::M1:
				return $z[3] - 3;
				break;
			case Workout::M2:
				return $z[3];
				break;
			case Workout::M3:
				return $z[3] - 2;
				break;
			default:
				return 'UNKNOWN';
				break;
		}
	}
}
?>