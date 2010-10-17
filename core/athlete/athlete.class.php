<?php 
/**
 * this represents an athlete
 * @author clemens
 *
 */
class Athlete {
	/** test
	 * the athletes database id
	 * @var int
	 */
	protected $id;
	
	/**
	 * this is a beginner athlete
	 */
	const BEGINNER = 0;

	/**
	 * the athlete is advanced
	 */
	const ADVANCED = 1;
		
	/**
	 * the athletes level
	 * he may be a beginner or an advanced athlete
	 * @var integer
	 */
	protected $level;
	
	/**
	 * the athlete's race schedule
	 * @var Schedule
	 */
	protected $schedule;
	
	/**
	 * time the athlete has reserved for training, measured in minutes
	 * @var int
	 */
	protected $trainingTime;
	
	/**
	 * the recovery cycle
	 * recover every n weeks..
	 * @var int
	 */
	protected $recoveryCycle = 3; //weeks
	
	/**
	 * lactate threshold
	 * @var int
	 */
	protected $threshold;
	
	/**
	 * sport
	 * @var string
	 */
	protected $sport;
	
	/**
	 * initialize the athlethe from an existing cake user
	 * @param object database object
	 * @param array $user user data from session
	 */
	public function __construct($DB, $user) {
		// initialize the athlete
		$this->id = $user["id"];
		if ($user["rookie"] == 1) {
			$this->level = Athlete::BEGINNER;
		} else {
			$this->level = Athlete::ADVANCED;
		}
		$this->trainingTime = $user["weeklyhours"] * 60;
		$this->threshold = $user["lactatethreshold"];
		$this->sport = $user["typeofsport"];
		
		// initialize his schedule
		if ($DB) {
			$this->schedule = new Schedule($DB, $this->id);
		}
	}
	
	/**
	 * calculates the workout zones based on the user's lactate threshold
	 * NOTE: this will NOT return 5 zones, as the last zone reaches from
	 * zone 4 limit up to your maximum heart rate capacity
	 * zone 0 represents start value for zone 1
	 * @param string $sport OPTIONAL sport identifier like RUN or BIKE; defaults to RUN if empty or unknown
	 * @return array of upper workout zone limits keyed 1-4
     */
	public function getZones($sport) {
		switch ($sport) {
			case "BIKE":			
				return array(
					0 => intval($this->threshold * 0.65),
					1 => intval($this->threshold * 0.81),
					2 => intval($this->threshold * 0.89),
					3 => intval($this->threshold * 0.93),
					4 => $this->threshold - 1
				);
				break;
			// running will also be our default setting
			case "RUN":
			default:
				return array(
					0 => intval($this->threshold * 0.66),	
					1 => intval($this->threshold * 0.85),
					2 => intval($this->threshold * 0.89),
					3 => intval($this->threshold * 0.94),
					4 => $this->threshold - 1
				);
				break;
		}
	}
	
	/**
	 * calculate TRIMP points for a workout
	 * for formula basics see
	 * http://gpsrunning.nicolajsen.nl/?path=SportTracks/TRIMP
	 * http://www.pponline.co.uk/encyc/training-schedules.html
	 * 
	 * @param string $sport
	 * @param int $minutes training duration in minutes
	 * @param int $avgHr average heart rate for that training
	 * @return int TRIMP point value for that training 
	 */
	public function calcTRIMP($sport, $minutes, $avgHR) {
		$zones = $this->getZones($sport);
		if ($avgHR < $zones[1]) {
			$factor = 1;
		} else if ($avgHR < $zones[2]) {
			$factor = 1.1;
		} else if ($avgHR < $zones[3]) {
			$factor = 1.2;
		} else if ($avgHR < $zones[4]) {
			$factor = 2.2;
		} else {
			$factor = 4.5;
		}
		
		// divide by 100 to avoid getting very high numbers
		return intval(($avgHR * $minutes * $factor) / 100);
	}
	
	public function getThreshold() {
		return $this->treshold;
	}
	
	public function getLevel() {
		return $this->level;
	}
	
	public function getSchedule() {
		return $this->schedule;
	}
	
	public function getId() {
		return $this->id;
	}
	
	public function getTrainingTime() {
		return $this->trainingTime;
	}
	
	public function getRecoveryCycle() {
		return $this->recoveryCycle;
	}
	
	public function isBeginner() {
		return $this->level == self::BEGINNER;
	}

	public function isAdvanced() {
		return $this->level == self::ADVANCED;
	}
	
	public function getSport() {
		return $this->sport;
	}
}
?>