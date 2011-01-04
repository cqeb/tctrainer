<?php 
/**
 * swim workout
 * @author clemens
 *
 */
class SwimWorkout extends Workout {
	/**
	 * these LSD times are not taken from Joe Friel
	 * but rather resemble personal experience
	 */
	public static $LSD_TIMES = array(
		Athlete::BEGINNER => array (0, 90, 90, 0, 85, 80, 0, 75, 70, 0, 65, 60),
		Athlete::ADVANCED => array (0, 100, 120, 0, 110, 100, 0, 90, 90, 0, 80, 80)		
	);

	/**
	 * (non-PHPdoc)
	 * @see Workout::getSport()
	 */
	public function getSport() {
		return "SWIM";
	}
	
	/**
	 * (non-PHPdoc)
	 * @see Workout::getTypeLabel()
	 */
	public function getTypeLabel() {
	switch ($this->type) {
			case Workout::E1:
				return __('Recovery', true);
				break;
			case Workout::E2:
				return __('Extensive Endurance', true);
				break;
			case Workout::E3:
				return __('Intensive Endurance', true);
				break;
			case Workout::S1:
				return __('Swimming Technique Drills', true);
				break;
			case Workout::S2:
				return __('Buoyancy Drills', true);
				break;
			case Workout::S3:
				return __('Speed', true);
				break;
			case Workout::F1:
				return __('Open Water', true);
				break;
			case Workout::F2:
				return __('Paddles', true);
				break;
			case Workout::F3:
				return __('Strength Drills', true);
				break;
			case Workout::M1:
				return __('Long Intervals', true);
				break;
			case Workout::M2:
				return __('Short Intervals', true);
				break;
			case Workout::M3:
				return __('Threshold Swim', true);
				break;
			default:
				return 'UNKNOWN';
				break;
		}
	}
	
	/**
	 * (non-PHPdoc)
	 * @see Workout::getDescription()
	 */
	public function getDescription() {
	switch ($this->type) {
			case Workout::E1:
				return __('Do an easy recovery swim.', true);
				break;
			case Workout::E2:
				return __('Swim intervals of medium intensity, that take five to ten minutes, and recover for 30 to 60 seconds.', true);
				break;
			case Workout::E3:
				return __('An intensive, aerobic workout. Swim intervals of medium effort which take 5 minutes, and recover for 30 seconds.', true);
				break;
			case Workout::S1:
				return __('Use this workout to focus entirely on your technique flaws.', true);
				break;
			case Workout::S2:
				return __('Use this workout to focus on your buoyancy and body position.', true);
				break;
			case Workout::S3:
				return __('Do fast repeats for one swimming lane lengths at maximum effort, and recover for one minute between intervals. Focus on technique, even when fatigue sets in. Repeat to a maximum of 300 meters/yards.', true);
				break;
			case Workout::F1:
				return __('Swim in open water. Remember to bring a partner, as swimming in open water is more dangerous.', true);
				break;
			case Workout::F2:
				return __('Use this workout to bring your paddles for endurance sets.', true);
				break;
			case Workout::F3:
				return __('Use this workout to focus on strength drills.', true);
				break;
			case Workout::M1:
				return __('Swim intervals of 6 minutes or more at high intensity. Recover for up to two minutes. Try to swim your next race distance.', true);
				break;
			case Workout::M2:
				return __('Swim intervals to a maximum of 5 minutes at high intensity. Recover for less than a minute, and try to cover your next race distance.', true);
				break;
			case Workout::M3:
				return __('Swim at race speed and do not recover. Stop after a maximum of thirty minutes.', true);
				break;
			default:
				return 'UNKNOWN';
				break;
		}
	}
	
	/**
	 * (non-PHPdoc)
	 * @see Workout::getAVGHR()
	 */
	public function getAVGHR(Athlete $athlete) {
		return 126; // alright - it may not get any fancier than this here.
	}
}
?>