<?php 
/**
 * the schedule keeps track of the planned races
 * @author clemens
  */
class Schedule {
	/**
	 * stores all races
	 */
	protected $races = array();
	
	protected $DB;
	
	/**
	 * initialize the schedule for an athlete
	 * @param int athlete's id
	 */
	public function __construct($DB, $athleteId) {
		$this->DB = $DB;
		$races = $this->DB->query("SELECT id, name, sportstype, competitiondate, important
			FROM competitions 
			WHERE user_id = $athleteId AND competitiondate > NOW()
			ORDER BY competitiondate ASC");

		if ($races) {
			while (list($k,$race) = each($races)) {
				$this->addRace(new Race(
					$race["id"],
					$race["sportstype"],
					new DateTime($race["competitiondate"]),
					intval($race["important"]),
					$race["name"]
				));
			}
		}
	}
	
	/**
	 * adds a race to the schedule
	 * @param $race
	 */
	public function addRace(Race $race) {
		$this->races[] = $race;
	}
	
	/**
	 * retrieve array of all races scheduled by the athlete
	 * there will be no dummy events added automatically!
	 */
	public function getRaces() {
		return $this->races;
	}
	
	/**
	 * determines the next LD race
	 * @param DateTime search from this date on
	 * @return next ld race or false if there is none
	 */
	public function getNextLDRace(DateTime $offset) {
		if (count($this->races) == 0) {
			return false;
		}
		reset($this->races);
		
		// loop for next ld race
		while (list($k,$race) = each($this->races)) {
			if ($race->isLD() && 
				$offset < $race->getDate()) {
				return $race;
			}
		}
		
		return false;
	}
	
	/**
	 * determine the next A race
	 * @param DateTime search from this date on
	 * @return next A-graded race or false on error
	 */
	public function getNextARace(DateTime $offset) {
		$backupRace = false;
		if (count($this->races) > 0) {
			reset($this->races);
			// loop for next important race
			while (list($k,$race) = each($this->races)) {
				if ($race->isImportant() && 
					$offset < $race->getDate()) {
					return $race;
				} else if (!$race->isImportant() &&
					$offset < $race->getDate() &&
					!$backupRace) {
					// keep the first non-important race as a backup, if there is no A race available
					$backupRace = $race;		
				}
			}
		}
		
		if ($backupRace) {
			return $backupRace;
		}

		// create a dummy race if there are no races available
		$aRaceDate = clone $offset;
		$aRaceDate->add(new DateInterval("P13W"));
		return new Race(-1, "RUN HALFMARATHON", $aRaceDate, false, "Dummy");
	}
}
?>