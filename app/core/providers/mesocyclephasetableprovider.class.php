<?php
/**
 * prepares the phase table as used by the mesocycle provider
 * this is a static class, that is never meant to be instanced
 * 
 */
class MesoCyclePhaseTableProvider {
	/**
	 * this table resembles the build of an absolute beginner
	 * key 0 is race week
	 */
	protected static $BEGINNER_TABLE = array(
		0 => array("RACE" => 1),
		1 => array("BASE" => 1, "RACE" => 1),
		2 => array("BASE" => 2, "RACE" => 1),
		3 => array("BASE" => 3, "RACE" => 1),
		4 => array("BASE" => 4, "RACE" => 1),
		5 => array("BASE" => 5, "RACE" => 1),
		6 => array("BASE" => 6, "RACE" => 1),
		7 => array("BASE" => 7, "RACE" => 1),
		8 => array("BASE" => 8, "RACE" => 1),
		9 => array("BASE" => 9, "RACE" => 1),
		10 => array("BASE" => 10, "RACE" => 1),
		11 => array("BASE" => 11, "RACE" => 1),
		12 => array("BASE" => 12, "RACE" => 1)
	);
	
	/**
	 * this is the table for an advanced athlete
	 * key 0 is race week
	 */
	protected static $ADVANCED_TABLE = array(
		0 => array("RACE" => 1),
		1 => array("BASE" => 1, "RACE" => 1),
		2 => array("BASE" => 1, "PEAK" => 1, "RACE" => 1),
		3 => array("BASE" => 2, "PEAK" => 1, "RACE" => 1),
		4 => array("BASE" => 3, "PEAK" => 1, "RACE" => 1),
		5 => array("BASE" => 4, "PEAK" => 1, "RACE" => 1),
		6 => array("BASE" => 5, "PEAK" => 1, "RACE" => 1),
		7 => array("BASE" => 6, "PEAK" => 1, "RACE" => 1),
		8 => array("BASE" => 7, "PEAK" => 1, "RACE" => 1),
		9 => array("BASE" => 8, "PEAK" => 1, "RACE" => 1),
		10 => array("BASE" => 8, "BUILD" => 1, "PEAK" => 1, "RACE" => 1),
		11 => array("BASE" => 8, "BUILD" => 2, "PEAK" => 1, "RACE" => 1),
		12 => array("BASE" => 8, "BUILD" => 3, "PEAK" => 1, "RACE" => 1),
		13 => array("BASE" => 8, "BUILD" => 4, "PEAK" => 1, "RACE" => 1),
		14 => array("BASE" => 8, "BUILD" => 5, "PEAK" => 1, "RACE" => 1),
		15 => array("BASE" => 8, "BUILD" => 6, "PEAK" => 1, "RACE" => 1),
		16 => array("BASE" => 8, "BUILD" => 6, "PEAK" => 2, "RACE" => 1),
		17 => array("BASE" => 9, "BUILD" => 6, "PEAK" => 2, "RACE" => 1),
		18 => array("BASE" => 10, "BUILD" => 6, "PEAK" => 2, "RACE" => 1),
		19 => array("BASE" => 11, "BUILD" => 6, "PEAK" => 2, "RACE" => 1),
		20 => array("BASE" => 12, "BUILD" => 6, "PEAK" => 2, "RACE" => 1),
		21 => array("BASE" => 12, "BUILD" => 7, "PEAK" => 2, "RACE" => 1),
		22 => array("BASE" => 12, "BUILD" => 8, "PEAK" => 2, "RACE" => 1)
	);

	/**
	 * this table is for an advanced athlete who already finished his first A race in
	 * this season
	 * key 0 is race week
	 */
	protected static $ADVANCED_POST_A_TABLE = array(
		0 => array("RACE" => 1),
		1 => array("RACE" => 2),
		2 => array("RACE" => 3),
		3 => array("BUILD" => 1, "PEAK" => 2, "RACE" => 1),
		4 => array("BUILD" => 2, "PEAK" => 2, "RACE" => 1),
		5 => array("BUILD" => 3, "PEAK" => 2, "RACE" => 1),
		6 => array("BUILD" => 4, "PEAK" => 2, "RACE" => 1),
		7 => array("BUILD" => 5, "PEAK" => 2, "RACE" => 1),
		8 => array("BUILD" => 6, "PEAK" => 2, "RACE" => 1),
		9 => array("BUILD" => 7, "PEAK" => 2, "RACE" => 1),
		10 => array("BUILD" => 8, "PEAK" => 2, "RACE" => 1),
		11 => array("BASE" => 1, "BUILD" => 8, "PEAK" => 2, "RACE" => 1),
		12 => array("BASE" => 2, "BUILD" => 8, "PEAK" => 2, "RACE" => 1),
		13 => array("BASE" => 3, "BUILD" => 8, "PEAK" => 2, "RACE" => 1),
		14 => array("BASE" => 4, "BUILD" => 8, "PEAK" => 2, "RACE" => 1),
		15 => array("BASE" => 5, "BUILD" => 8, "PEAK" => 2, "RACE" => 1),
		16 => array("BASE" => 6, "BUILD" => 8, "PEAK" => 2, "RACE" => 1),
		17 => array("BASE" => 7, "BUILD" => 8, "PEAK" => 2, "RACE" => 1),
		18 => array("BASE" => 8, "BUILD" => 8, "PEAK" => 2, "RACE" => 1),
		19 => array("BASE" => 9, "BUILD" => 8, "PEAK" => 2, "RACE" => 1),
		20 => array("BASE" => 10, "BUILD" => 8, "PEAK" => 2, "RACE" => 1),
		21 => array("BASE" => 11, "BUILD" => 8, "PEAK" => 2, "RACE" => 1),
		22 => array("BASE" => 12, "BUILD" => 8, "PEAK" => 2, "RACE" => 1)
	);
	
	/**
	 * these are the time factors used to calculate weekly training times from the
	 * basic training time the athlete has specified
	 */
	public static $TRAINING_TIME_FACTORS = array(
		"PREP" 				=> array(0.8),
		"BASE1" 			=> array(1, 1.2, 1.4),
		"BASE1_RECOVERY" 	=> array(0.75),
		"BASE2" 			=> array(1.05, 1.25, 1.40),
		"BASE2_RECOVERY" 	=> array(0.7),
		"BASE3" 			=> array(1.15, 1.35, 1.50),
		"BASE3_RECOVERY" 	=> array(0.75),
		"BUILD1" 			=> array(1.3, 1.3, 1.3),
		"BUILD1_RECOVERY"	=> array(0.7),
		"BUILD2"			=> array(1.25, 1.25, 1.25),
		"BUILD2_RECOVERY"	=> array(0.7),
		"PEAK"				=> array(1.1),
		"PEAK_RECOVERY"		=> array(0.85),
		"RACE"				=> array(0.75)
	);
	
	/**
	 * generates am array of mesocycle phases for the athlete
	 * @param Athlete $athlete
	 * @param int $weeks
	 * @param boolean $postA if set to true this means that another A race has been planned before in this season
	 * @return array of mesocycle phases, like array(0 => "RACE", 1 => "PEAK", 2 => "BUILD3", ...)
	 */
	public static function getPhaseTable(Athlete $athlete, $weeks, $postA) {
		// as the table counter starts with 0 we have to reduce the weeks index by one
		if ($postA) {
			$baseTable = MesoCyclePhaseTableProvider::$ADVANCED_POST_A_TABLE;
		} else {
			if ($athlete->getLevel() == Athlete::BEGINNER) {
				$baseTable = MesoCyclePhaseTableProvider::$BEGINNER_TABLE;
			} else {
				$baseTable = MesoCyclePhaseTableProvider::$ADVANCED_TABLE;
			}
		}

		$table = array();
		
		// now check if there are more weeks requested than specified in the table
		if ($weeks > count($baseTable)) {
			$weeksOver = $weeks - count($baseTable);
			MesoCyclePhaseTableProvider::generateFillWeeks($table, $weeksOver);
			// now reduce the number of weeks to the num of weeks we actually need to generate
			$weeks = $weeks - $weeksOver;
		}
		
		// now add specified phases
		while (list($phase, $numWeeks) = each($baseTable[$weeks - 1])) {
			if ($phase == "BASE") {
				MesoCyclePhaseTableProvider::generateBase($table, $numWeeks);
			} else if ($phase == "BUILD") {
				MesoCyclePhaseTableProvider::generateBuild($table, $numWeeks);
			} else {
				MesoCyclePhaseTableProvider::generatePhase($phase, $table, $numWeeks);
			}
		}		
		
		// the table phases are now assigned correctly
		// now add training times to the table
		MesoCyclePhaseTableProvider::addTrainingTimes($table, 
			$athlete->getTrainingTime(), $athlete->getRecoveryCycle());
		
		return $table;
	}

	/**
	 * this will recalculate the training time track, which is needed when
	 * the user changes his average workout hours to fit his weekly
	 * training hours.
	 * the newly calculated time table ist stored back automagically to the
	 * database
	 * @param Athlete $athlete the athlete
	 * @param DB $DB Database object
	 */
	public function recalcTimes($DB, $athlete) {
		$table = self::load($DB, $athlete);
		if (!$table) {
			// there was no table to be loaded so just quit here
			return;
		}
		
		// now add training times
		self::addTrainingTimes($table, 
			$athlete->getTrainingTime(), 
			$athlete->getRecoveryCycle());

		// speichern
		self::update($DB, $athlete, $table);
	}
	
	/**
	 * saves the values of a phase table with an updated 
	 * time trackback to the database
	 * WARNING! this is just meant to be used within
	 * the context of load() and recalcTimes()
	 * @param DB $DB Database object
	 * @param Athlete $athlete th athlete
	 */
	protected function update($DB, $athlete, $table) {
		reset($table);
		while(list($k,$v)=each($table)) {
			$DB->query("UPDATE mesocyclephases 
				SET time = " . $v["time"] . ",
				usertime = 0
				WHERE athlete_id = " . $athlete->getId() . "
				AND date = '" . $k . "'");
		}
	}
	
	/**
	 * load a mesocycletable from the database for an athlete
	 * @param DB $DB Database object
	 * @param Athlete $athlete th athlete
	 */
	protected function load($DB, $athlete) {
		$start = DateTimeHelper::getWeekStartDay(new DateTime());
		$res = $DB->query("SELECT date, phase FROM mesocyclephases
			WHERE athlete_id = " . $athlete->getId() . " 
			AND date >= '" . $start->format("Y-m-d"). "'");
		
		if (count($res) == 0) {
			return false;
		}
		
		// now some transformation is needed
		$table = array();
		while (list($k,$week) = each($res)) {
			$table[$week["date"]]["phase"] = $week["phase"];
		}
		return $table;		
	}
	
	/**
	 * adds training times to the table
	 * @param array $table containing training phases
	 * @param int $baseTime basic time reserverd for training
	 * @return unknown_type
	 */
	protected function addTrainingTimes(&$table, $baseTime, $recoveryCycle) {
		reset($table);
		$oldPhase = false;
		// count the weeks for recovery determination
		$recoveryCounter = 1;

		// step through each of the weeks and add the time
		while (list($week, $data) = each($table)) {
			$phase = $table[$week]["phase"];
			
			// determine if it is a recovery week
			$recoveryWeek = MesoCyclePhaseTableProvider::
				isRecoveryWeek($recoveryCycle, $phase, $recoveryCounter);
			$table[$week]["recovery"] = $recoveryWeek;
				
			if ($phase != $oldPhase) {
				$weeks = MesoCyclePhaseTableProvider::resetPhaseCounter();
			} else {
				if (($phase == "BASE1" || $phase == "BASE2" || $phase == "BASE3" || 
					$phase == "BUILD1" || $phase == "BUILD2") &&
					!$recoveryWeek) {
					// only base and build phases need to be counted
					$weeks[$phase]++;
				}
			}
			$oldPhase = $phase;
			
			// determine lookup keys
			$phaseKey = $phase;
			$factorKey = $weeks[$phase]; 
			if ($recoveryWeek) {
				$phaseKey .= "_RECOVERY";
				$factorKey = 0;
			}

			// now resolve the factor
			if (array_key_exists($factorKey, MesoCyclePhaseTableProvider::$TRAINING_TIME_FACTORS[$phaseKey])) {
				$factor = MesoCyclePhaseTableProvider::
					$TRAINING_TIME_FACTORS[$phaseKey][$factorKey];
			} else {
				$factor = MesoCyclePhaseTableProvider::
					$TRAINING_TIME_FACTORS[$phaseKey][count(MesoCyclePhaseTableProvider::$TRAINING_TIME_FACTORS[$phaseKey]) - 1];
			}	
			// finally calculate the time for the given week
			$table[$week]["time"] = intval(round($factor * $baseTime, -1));
		}
	}
	
	/**
	 * determine if a week is a recovery week or not
	 * raise the counter of non-recovery weeks if applicable
	 * @param int $recoveryCycle the recovery cycle
	 * @param string $phase the phase
	 * @param int $ocunter the non-recovery week counter
	 * @return boolean true if it is a recovery week
	 */
	protected function isRecoveryWeek($recoveryCycle, $phase, &$recoveryCounter) {
		// prep and race weeks never can have recovery weeks
		if ($phase == "PREP" || $phase == "RACE") {
			return false;
		}
		
		// if the counter matches the recovery cycle it's a recovery week
		// reset recovery counter
		if ($recoveryCounter == $recoveryCycle) {
			$recoveryCounter = 1;
			return true;
		}
		
		// it's another non-recovery week - add it to the counter
		$recoveryCounter++;
		return false;
	}
	
	protected function resetPhaseCounter() {
		return array(
			"PREP" => 0,
			"BASE1" => 0,
			"BASE2" => 0,
			"BASE3" => 0,
			"BUILD1" => 0,
			"BUILD2" => 0,
			"PEAK" => 0,
			"RACE" => 0
		);
	}
	
	/**
	 * generates an amount of filler weeks to be inserted before the actual training plan starts
	 * @param array $table wich contains the phases
	 * @param int $numWeeks number of weeks to be generated for this phase
	 */
	protected static function generateFillWeeks(Array &$table, $numWeeks) {
		$weeksLeft = $numWeeks;
		while ($weeksLeft > 0) {
			// add a preparation phase
			if ($weeksLeft >= 4) {
				$c = 4;
			} else {
				$c = $weeksLeft;
			}
			for ($i = 1; $i <= $c; $i++) {
				$table[] = array("phase" => "PREP");
				$weeksLeft--;
			}
			
			if ($weeksLeft == 0) {
				return;
			}
			
			// add base phases
			if ($weeksLeft >= 12) {
				$c = 12;
			} else {
				$c = $weeksLeft;
			}
			MesoCyclePhaseTableProvider::generateBase($table, $c);
			$weeksLeft -= $c;
		}		
	}
	
	/**
	 * generates any phase of the table as provided by $phase
	 * @param string $phase the name of the phase
	 * @param array $table wich contains the phases
	 * @param int $numWeeks number of weeks to be generated for this phase
	 */
	protected static function generatePhase($phase, Array &$table, $numWeeks) {
		for ($i = 1; $i <= $numWeeks; $i++) {
			$table[] = array("phase" => $phase);
		}
	}
	
	/**
	 * generates the build part of the table
	 * @param array $table wich contains the phases
	 * @param int $numWeeks number of weeks to be generated for this phase
	 */
	protected static function generateBuild(Array &$table, $numWeeks) {
		if ($numWeeks <= 3) {
			for ($i = 1; $i <= $numWeeks; $i++) {
				$table[] = array("phase" => "BUILD1");
			}
		} else {
			$periodLength = round($numWeeks / 2);
			for ($i = 1; $i <= $numWeeks; $i++) {
				if ($i <= $periodLength) {
					$table[] = array("phase" => "BUILD1");
				} else {
					$table[] = array("phase" => "BUILD2");
				}
			}
		}
	}
	
	/**
	 * generates the base part of the table
	 * @param array $table wich contains the phases
	 * @param int $numWeeks number of weeks to be generated for this phase
	 */
	protected static function generateBase(Array &$table, $numWeeks) {
		if ($numWeeks == 1) {
			$table[] = array("phase" => "BASE1");
		} else if ($numWeeks == 2) {
			$table[] = array("phase" => "BASE1");
			$table[] = array("phase" => "BASE1");
		} else if ($numWeeks == 3) {
			$table[] = array("phase" => "BASE1");
			$table[] = array("phase" => "BASE1");
			$table[] = array("phase" => "BASE1");
		} else if ($numWeeks < 6) {
			$periodLength = round($numWeeks / 2);
			for ($i = 1; $i <= $numWeeks; $i++) {
				if ($i <= $periodLength) {
					$table[] = array("phase" => "BASE1");
				} else {
					$table[] = array("phase" => "BASE2");
				}
			}
		} else if ($numWeeks >= 6) {
			$period1 = round($numWeeks / 3);
			$period2 = $period1 * 2;
			for ($i = 1; $i <= $numWeeks; $i++) {
				if ($i <= $period1) {
					$table[] = array("phase" => "BASE1");
				} else if ($i > $period1 && $i <= $period2 ) {
					$table[] = array("phase" => "BASE2");
				} else if ($i > $period2) {
					$table[] = array("phase" => "BASE3");
				}
			} 
		}
	}
}
?>