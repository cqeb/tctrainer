<?php
/**
 * this represents a race like an ironman, olympic tri or a marathon
 * @author clemens
 */
class Race {
	/**
	 * date of the race as DateTime object
	 */
	protected $date;
	
	/**
	 * type of the race
	 */
	protected $type;
	
	/**
	 * bool wether the race is important
	 */
	protected $important;
	
	/**
	 * the race's name
	 */
	protected $name;
	
	/**
	 * database id of the race
	 */
	protected $id;
	
	/**
	 * long distance flag
	 */
	protected $ld = false;
	
	/**
	 * create a new race
	 * @param $id the database id of the race
	 * @param $type of the race as specified by constant
	 * @param $date of the race as datetime object
	 * @param $important bool if the race is important or not
	 * @param $name of the race
	 * @return unknown_type
	 */
	public function __construct($id, $type, DateTime $date, $important, $name) {
		$this->type = $type;
		$this->date = $date;
		$this->important = (bool) $important;
		$this->name = $name;
		if (self::getDistanceClass($type) == "LONG") {
			$this->ld = true;
		}
	}
	
	public function getId() {
		return $this->id;
	}
	
	/**
	 * how many weeks do we have till raceday?
	 * @return int number of weeks
	 */
	public function getWeeksTillRaceday(DateTime $now) {
		return (DateTimeHelper::diffWeeks($now, $this->date) - 1);
	}
	
	public function getDate() {
		return $this->date;
	}
	
	public function setDate(DateTime $date) {
		$this->date = $date;
	}
	
	public function getType() {
		return $this->type;
	}
	
	public function setType($type) {
		$this->type = $type;
	}
	
	public function isImportant() {
		return $this->important;
	}
	
	public function setImportant($val) {
		$this->important = (bool) $val;
	}
	
	public function isLD() {
		return $this->ld;
	}
	
	/**
	 * determine a distance classification for a race type, such as 
	 * 	SPRINT, SHORT, MIDDLE, LONG
	 * @param String $type
	 * @return distance classification String
	 */
	public static function getDistanceClass($type) {
		switch($type) {
			case 'TRIATHLON IRONMAN':
			case 'BIKE ULTRA':
			case 'BIKE LONG':
			case 'RUN ULTRA':
			case 'RUN MARATHON':
				return "LONG";
				break;
			case 'TRIATHLON HALFIRONMAN':
            case 'DUATHLON MIDDLE':
 			case 'BIKE MIDDLE':
			case 'RUN HALFMARATHON':
				return "MIDDLE";
				break;
			case 'TRIATHLON OLYMPIC':
            case 'DUATHLON SHORT':
            case 'RUN 10K':
				return "SHORT";
				break;
            case 'TRIATHLON SPRINT':
			case 'RUN 5K':
            case 'BIKE SHORT':
				return "SPRINT";
				break;
			default:
				throw new Exception("Unknown competition type {$type}");
				break;
		}
	}
}
?>