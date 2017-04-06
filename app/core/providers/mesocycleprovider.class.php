<?php
/**
 * provides mesocycle data (BASE1, BUILD1, etc.)
 * the current mesocycle is generated from a start date with a given target date
 * (this is the next A-Type race). further the info if there has been an A-graded
 * race is taken into account, and, if our athlete is advanced or beginner
 */
class MesoCycleProvider {
	/**
	 * references the athlete
	 * @var Athlete
	 */
	protected $athlete;
	
	/**
	 * this is where the phases are stored
	 * @var array
	 */
	protected $phaseTable;
	
	/**
	 * contains the first key from the phase table
	 * @var string
	 */
	protected $firstKey;
	
	protected $DB;
	
	/**
	 * create a new mesocycleprovider
	 * @param DataBase $DB
	 * @param Athlete $athlete
	 * @param DateTime $week offset week from which to start
	 */
	public function __construct($DB, Athlete $athlete, DateTime $week) {

		$this->DB = $DB;
		$this->athlete = $athlete;
		
		// initialize the provider from the database
		/*
		$res = $this->DB->query("SELECT date, phase, time, usertime, ratio, recovery 
			FROM mesocyclephases 
			WHERE athlete_id = " . $this->athlete->getId() . "
			AND date >= '" . $week->format("Y-m-d") . "' 
			ORDER BY date ASC");
		*/

		// KMS changed this - check if mesocyle for current week exists!! - in former clause it was enough to have any result in the future
		$res = $this->DB->query("SELECT date, phase, time, usertime, ratio, recovery 
			FROM mesocyclephases 
			WHERE athlete_id = " . $this->athlete->getId() . "
			AND date = '" . $week->format("Y-m-d") . "' 
			ORDER BY date ASC");

		if ($res) {

		} else {
			// if there is no existing mesocycle create one
			$this->generate($week);
			$this->store();
		}

		/*
		$res2 = $this->DB->query("SELECT date, phase, time, usertime, ratio, recovery 
			FROM mesocyclephases 
			WHERE athlete_id = " . $this->athlete->getId() . "
			AND date >= '" . $week->format("Y-m-d") . "' 
			ORDER BY date ASC");
		*/

	// remove date filter
		$res2 = $this->DB->query("SELECT date, phase, time, usertime, ratio, recovery 
			FROM mesocyclephases 
			WHERE athlete_id = " . $this->athlete->getId() . " 
			ORDER BY date ASC");

		if ($res2) {
			while(list($k, $data) = each($res2)) {
				// normalize ratio
				$ratio = $data["ratio"];
				if ($ratio == '') {
					$ratio = $this->getDefaultRatio();
				}
				
				$this->phaseTable[$data["date"]] = array(
					"phase" => $data["phase"],
					"time" => intval($data["time"]),
					"usertime" => intval($data["usertime"]),
					"ratio" => $ratio,
					"recovery" => ($data["recovery"] == "1")
				);

				if (!$this->firstKey) {
					$this->firstKey = $data["date"];
				}
			}
		} else {
			// if there is no existing mesocycle create one
			$this->generate($week);
			$this->store();
		}

	}
	
	/**
	 * will return the default ratio string for the current athlete
	 * @return String default ratio like 20,40,40 for triathlon
	 */
	private function getDefaultRatio() {
		$sportId = substr($this->athlete->getSport(), 0, 3);
		if ($sportId == 'TRI') {
			return RATIO_TRIATHLON;
		} elseif ($sportId == 'DUA') {
			return RATIO_DUATHLON;
		} else {
			return '100';
		}
	}
	
	/**
	 * generate a new mesocycle based on the athlete's races starting from the provided date
	 * @param DateTime $startDate date to generate mesocycle from
	 * @param int $trainingTime basic time frame reserved for training
	 * @return array phase table
	 */
	public function generate(DateTime $startDate) {
		$mon = DateTimeHelper::getWeekStartDay($startDate);
		$aRace = $this->athlete->getSchedule()->getNextARace($startDate);
		
		if (!$aRace) {
			throw new Exception("Unable to generate Mesocycles without an A-Race");
		}
	
		$phaseTable = MesoCyclePhaseTableProvider::getPhaseTable(
			$this->athlete, 
			DateTimeHelper::diffWeeks(
				$mon, 
				$aRace->getDate()
			),
			$startDate
		);
		
		// now replace the phase table keys by the appropriate week start days
		reset($phaseTable);

		$newPhaseTable = array();

		$week = new DateInterval("P7D");
		//unset($this->firstKey);
		while (list($k,$phase) = each($phaseTable)) {
			$newPhaseTable[$mon->format("Y-m-d")] = $phase;
			$newPhaseTable[$mon->format("Y-m-d")]['ratio'] = $this->getDefaultRatio();
			if (!$this->firstKey) {
				$this->firstKey = $mon->format("Y-m-d");
			}
			$mon->add($week);
		}
		
		// TODO now is the time to check if there is another A race past to this one
		$this->phaseTable = $newPhaseTable;

		return $this->phaseTable;
	}
	
	/**
	 * retrieve the weekly training time for a given date
	 * @param DateTime $date to retrieve the time for
	 * @param String $sport (optional) the time should be retrieved for. if no sport is given,
	 * the general training time is returned. possible values are "SWIM", "BIKE" and "RUN"
	 * @return int training time in minutes
	 */
	public function getTrainingTime(DateTime $date, $sport=NULL) {

		$dStr = $date->format("Y-m-d");

		if (array_key_exists($dStr, $this->phaseTable)) {

			if (isset( $this->phaseTable[$dStr]["usertime"] ) && $this->phaseTable[$dStr]["usertime"]  > 0 ) {
				// return user specific settings
				$time = $this->phaseTable[$dStr]["usertime"];
			} else {
				// or basic setting
				$time = $this->phaseTable[$dStr]["time"];
			}

			if ($sport) {
				$ratio = $this->calcRatio($sport, $dStr);
				// round to nearest 5
				return round(intval($ratio * $time) / 5) * 5;
			} else {
				return $time;
			}
		} else {
			throw new Exception("Tried to receive time for an unkown date {$dStr} in phaseTable - your date has to be a Monday");
		}
	}
	
	/**
	 * determine ratio for a specific sport for an athlete
	 * @param String $sport type of sport like RUN, BIKE
	 * @param String $date iso date string
	 */
	private function calcRatio($sport, $date) {
		$ratios = explode(',', $this->phaseTable[$date]['ratio']);
		switch($this->athlete->getSport()) {
			case 'TRIATHLON IRONMAN':
			case 'TRIATHLON HALFIRONMAN':
			case 'TRIATHLON OLYMPIC':
			case 'TRIATHLON SPRINT':
				switch ($sport) {
					case 'SWIM':
						return ($ratios[0] / 100);
						break;
					case 'BIKE':
						return ($ratios[1] / 100);
						break;
					case 'RUN':
						return ((100 - $ratios[0] - $ratios[1]) / 100);
						break;
				}
				break;
            case 'DUATHLON MIDDLE':
            case 'DUATHLON SHORT':
				switch ($sport) {
					case 'BIKE':
						return ($ratios[0] / 100);
						break;
					case 'RUN':
						return ((100 - $ratios[0]) / 100);
						break;
				}
            	break;
            default:
            	return 1;
            	break;
		}
	}
	
	/**
	 * stores the generated mesocyclephases from phaseTable to the database
	 */
	public function store() {
		if (!$this->phaseTable) {
			throw new Exception("No data to be stored to mesocyclephases. Maybe you did not generate yet?");
		}
		
		reset($this->phaseTable);
		$insertSQL = "INSERT INTO mesocyclephases (date, phase, time, recovery, athlete_id) VALUES\n";
		$firstDate = false;
		while (list($date, $d) = each($this->phaseTable)) {
			
			$insertSQLArr[] = "('" . $date . "', '" . $d["phase"] . "', " . 
			$d["time"] . ", " . intval($d["recovery"]) . ", " .	
			$this->athlete->getId() . " )";
			if (!$firstDate) {
				$firstDate = $date;
			}
		}
		
		$insertSQL .= implode(",\n", $insertSQLArr);
		
		// delete old entries first
		$this->DB->query("DELETE FROM mesocyclephases WHERE date >= '$firstDate' AND
			athlete_id = " . $this->athlete->getId());
		
		// now insert new values
		$this->DB->query($insertSQL);
	}
	
	/**
	 * retrieve phase for the given date from the table
	 * @param DateTime date the phase shall be retrieved for - HAS TO BE a Monday!
	 * @return array phase array
	 */
	public function getPhase(DateTime $date) {
		$dstr = $date->format("Y-m-d");
		if ($dstr < $this->firstKey) {
			throw new Exception("No data for retrieving current phase.");
		}

		if (array_key_exists($dstr, $this->phaseTable)) {
			return $this->phaseTable[$dstr];
		} else {
			throw new Exception("Requested phase for unknown date {$dstr} from phaseTable. 
				Always sanitize your date to be a Monday when using getPhase()");
		}
	}
	
	/**
	 * retrieve the generated phase table
	 */
	public function getPhaseTable() {
		return $this->phaseTable;
	}
}
?>