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
	 * bike lactate threshold
	 * @var int
	 */
	protected $bikethreshold;
	
	/**
	 * sport
	 * @var string
	 */
	protected $sport;
	
	/**
	 * a user is considered to be valid if he has paid and accepted the
	 * terms of service 
	 * @var boolean
	 */
	protected $valid;
	
	/**
	 * marks an user with elevated privileges
	 * @var boolean
	 */
	protected $advancedFeatures = false;
	
	/**
	 * database reference
	 */
	protected $DB;
	
	/**
	 * initialize the athlethe from an existing cake user
	 * @param object database object
	 * @param array $user user data from session
	 */
	public function __construct($DB, $user) {
		if ($user["id"] == null) {
			return false;
		}
		
		$this->DB = $DB;
		
		// initialize the athlete
		$this->id = $user["id"];
		if ($user["rookie"] == 1) {
			$this->level = Athlete::BEGINNER;
		} else {
			$this->level = Athlete::ADVANCED;
		}
		$this->trainingTime = $user["weeklyhours"] * 60;
		$this->threshold = $user["lactatethreshold"];
		$this->bikethreshold = $user["bikelactatethreshold"];
		$this->sport = $user["typeofsport"];
		if (array_key_exists('paid_to', $user)) {
			$this->valid = (($user['paid_to'] > date('Y-m-d') && $user['tos'] === '1'));
		} else {
			$this->valid = false;
		}
		
		if (array_key_exists('advanced_features', $user)) {
			$this->advancedFeatures = ($user["advanced_features"] == "1");
		}

		// initialize his schedule
		if ($DB) {
			$this->schedule = new Schedule($DB, $this->id);
		} else {
			throw new Exception("no DB object handed over on initialization of athlete");
		}
	}
	
	/**
	 * will set the athlete's training time to a maximum of 1800mins
	 * which equals 30hrs
	 * @param DataBase $DB
	 * @param int $time in minutes
	 */
	public function setTrainingTime($time) {
		$time = intval($time);
		if ($time > 1800) {
			return false; // no can do.
		}
		if ($time < 60) {
			$time = 60;
		}
		$this->trainingTime = $time;
		MesoCyclePhaseTableProvider::recalcTimes($this->DB, $this);
		
		$hrs = round($time / 60, 2);
		// save training time to db
		$this->DB->query("UPDATE users SET weeklyhours = $hrs
			WHERE id = " . $this->id);
		return true;
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
    // if you change sth., please change it in unitcalc - component too
		switch ($sport) {
			case "BIKE":			
				return array(
					0 => intval($this->bikethreshold * 0.65),
					1 => intval($this->bikethreshold * 0.81),
					2 => intval($this->bikethreshold * 0.89),
					3 => intval($this->bikethreshold * 0.93),
					4 => $this->bikethreshold - 1
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
	 * 
	 * @param string $sport
	 * @param int $minutes training duration in minutes
	 * @param int $avgHr average heart rate for that training
	 * @return int TRIMP point value for that training 
	 */
	public function calcTRIMP($sport, $minutes, $avgHR) {
		// if you change sth., please change it in unitcalc - component too
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
		
		/*
		 * switched to Zone-based TRIMP formula according to 
		 * http://stuartmultisport.com/TrImp.aspx
	 	 * http://gpsrunning.nicolajsen.nl/?path=SportTracks/TRIMP
	 	 * http://www.pponline.co.uk/encyc/training-schedules.html
	 	 * http://www.answers.com/topic/trimp-method
	 	 */
		return intval($minutes * $factor);
	}
	
	public function isValid() {
		return $this->valid;
	}
	
	public function isAdvancedFeatures() {
		return $this->advancedFeatures;
	}
	
	public function getThreshold() {
		return $this->threshold;
	}

	public function getBikeThreshold() {
		return $this->bikethreshold;
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