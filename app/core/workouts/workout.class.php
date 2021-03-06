<?php 
/**
 * just a stupid container for a workout
 */
abstract class Workout {
	/**
	 * workout types (short codes) are defined here
	 */
	// TODO verify this list - when just considering run workouts having S1-S5 looks odd.
	// endurance
	const E1 = "E1";
	const E2 = "E2";
	const E3 = "E3";
	
	// speed skills
	const S1 = "S1";
	const S2 = "S2";
	const S3 = "S3";
	const S4 = "S4";
	const S5 = "S5";
	
	// force
	const F1 = "F1";
	const F2 = "F2";
	const F3 = "F3";
	
	// muscular endurance
	const M1 = "M1";
	const M2 = "M2";
	const M3 = "M3";
	const M4 = "M4";
	const M5 = "M5";
	
	// test
	const TEST_SHORT = "T1";
	const TEST_LONG = "T2";
	
	// competition
	const COMPETITION = "C1";
	
	/**
	 * the workout's duration measured in minutes
	 */
	protected $duration;
	
	/**
	 * the workout type code like E1 or S3
	 */
	protected $type;
	
	/**
	 * lsd flag
	 */
	protected $lsd;
	
	/**
	 * training impulse value
	 */
	protected $trimp;
	
	/**
	 * athlete reference
	 */
	protected $athlete;
	
	/**
	 * reference to a training id
	 * will be set if a user has already completed this workout
	 * @see ProviderComponent::linkWorkouts
	 */
	protected $trainingId;
	
	/**
	 * generate a new workout
	 * @param Athlete $athlete athlete
	 * @param $type of the workout
	 * @param $duration of the workout, like E1, M1...
	 * @param $lsd flags this workout as an lsd workout
	 */
	public function __construct(Athlete $athlete, $type, $duration, $lsd=false) {
		$this->athlete = $athlete;
		$this->type = $type;
		$this->duration = $duration;
		$this->lsd = $lsd;
		$this->trimp = $athlete->calcTRIMP($this->getSport(), $duration, $this->getAVGHR($athlete));
	}
	
	public function getDuration() {
		return $this->duration;
	}
	
	public function setDuration($duration) {
		$this->duration = $duration;
		// recalc trimp on this occasion
		$this->trimp = $this->athlete->calcTRIMP(
			$this->getSport(),
			$duration,
			$this->getAVGHR($this->athlete)
		);
	}
	
	public function getType() {
		return $this->type;
	}

	public function setType($type) {
		$this->type = $type;
	}
	
	public function isLsd() {
		return $this->lsd;
	}
	
	/**
	 * determine if this is a test workout
	 * @return true if it's a test workout
	 */
	public function isTest() {
		if ($this->getCategory() === 'T') {
			return true;
		} else {
			return false;
		}
	}
	
	public function getTRIMP() {
		return $this->trimp;
	}
	
	public function getTrainingId() {
		return $this->trainingId;
	}
	
	public function setTrainingId($id) {
		return $this->trainingId = $id;
	}
	
	/**
	 * get a descriptive category label for this workout:
	 * Endurance, Speed skills, Force or Muscular Endurance
	 */
	public function getCategory() {
		switch($this->getShortCategory()) {
			case 'E':
				return __('Endurance', true);
				break;
			case 'S':
				// Speed Skills
				return __('Speed', true);
				break;
			case 'F':
				return __('Force', true);
				break;
			case 'M': 
				// Muscular Endurance
				return __('Tempo Hardness', true);
				break;
			case 'T':
				return __('Test', true);
				break;
			default:
				return 'Unknown';
				break;
		}
	}
	
	/**
	 * retrieves the short version of a category, which may be E, S, F, T or M
	 */
	public function getShortCategory() {
		return substr($this->type, 0, 1);
	}
	
	/**
	 * generate a short description suitable for a title tag
	 * to generate tipTip tooltip from
	 */
	public function getCategoryDescription() {
		switch($this->getShortCategory()) {
			case 'E':
				return __('Endurance allows you to maintain performance whilst resisting fatigue.', true);
				break;
			case 'S':
				// Speed Skills
				return __('Speed trainings will teach your body to move more quickly, while maintaining efficenciy.', true);
				break;
			case 'F':
				return __('Force trainings teach you to apply maximum effort repeatedly.', true);
				break;
			case 'M': 
				// Muscular Endurance
				return __('Tempo Hardness allows your body to withstand high exertion for longer intervals without dropping performance.', true);
				break;
			case 'T':
				return __('Test workouts will be used to determine your lactate threshold levels. This is very important, as your heart rate zones are derived from those values!', true);
				break;
			default:
				return 'Unknown';
				break;
		}
	}
	
	/**
	 * renders the workout's internationalized description
	 * @return string descriptive text
	 */
	public abstract function getDescription();
	
	/**
	 * return a human read- & understandable text label for this workout
	 * @param string $type OPTIONAL string which identifies the workout type such as "E1"..
	 * @return type label string or false if unknown
	 */
	public abstract function getTypeLabel($type=false);
	
	/**
	 * retrieve the average workout heart rate for a given workout
	 * @param Athlete $athlete athlete reference
	 * @return int average heart rate for this training
	 */
	public abstract function getAVGHR(Athlete $athlete);
	
	/**
	 * return sport type for the workout
	 */
	public abstract function getSport();
}
?>