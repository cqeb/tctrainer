<?php
class WorkoutTypeSequence extends Sequence {
	/**
	 * define table name for sequence storage here
	 * @var String
	 * 
	 * OVERRIDE when implementing
	 */
	protected $TABLE = null;	
	
	protected $sequence = array(
		"E", // Endurance
		"S", // Speed Skills
		"F", // Force
		"S",
		"E",
		"M", // Muscular Endurance
		"S",
		"E",
		"F",
		"E",
		"S",
		"M"
	);

	/**
	 * arrange workouts grouped by phases
	 * in an multidimensional array
	 * WORKOUT_TYPES[PHASE][TYPE] like
	 * WORKOUT_TYPES["BASE1"]["E2"]
	 * 
	 * OVERRIDE when implementing
	 */
	protected static $WORKOUT_TYPES = null;

	/**
	 * the current phase
	 */
	protected $phase;

	/**
	 * workout subsequence positions
	 */
	protected $subPositions = array(
		"E" => -1,
		"F" => -1,
		"M" => -1,
		"S" => -1
	);

	/**
	 * the athlete the sequence was generated for
	 * @var Athlete
	 */
	protected $athlete;
	
	/**
	 * the week the sequence was generated for
	 * @var DateTime
	 */
	protected $week;
	
	/**
	 * instatiate workouttypesequence for a given phase
	 * @param string $phase
	 */
	public function __construct($DB, $phase, Athlete $athlete, DateTime $week) {
		$this->DB = $DB;
		// continue subpositions
		$this->phase = $phase;
		$this->athlete = $athlete;
		$this->week = $week;
		$this->resume($athlete, $week);
	}

	protected $DB;
	
	/**
	 * resume the sequence from the last saved state
	 * @param Athlete $athlete the sequence is generated for
	 * @param DateTime $week the sequence is generated for
	 */
	protected function resume(Athlete $athlete, DateTime $week) {
		$searchWeek = clone $week;
		$wStr = $searchWeek->sub(new DateInterval("P7D"))->format("Y-m-d");
		
		$res = $this->DB->query("SELECT * FROM {$this->TABLE} WHERE athlete_id = " .
			$athlete->getId() . " AND week = '" . $wStr . "'");
			
		// if there was something persited lately, we'll use the data
		if ($res) {
			$this->position = intval($res[0]["position"]);
			$this->subPositions["E"] = intval($res[0]["e"]);
			$this->subPositions["F"] = intval($res[0]["f"]);
			$this->subPositions["M"] = intval($res[0]["m"]);
			$this->subPositions["S"] = intval($res[0]["s"]);
		}
	}
	
	/**
	 * persist the sequences to the database
	 */
	public function save() {
		$week = $this->week->format("Y-m-d");
		
		// delete old entry first
		$this->DB->query("DELETE FROM {$this->TABLE} WHERE athlete_id = " .
			$this->athlete->getId() . " AND week = '" . $week . "'");
		
		//now insert new one
		$sql = "INSERT INTO {$this->TABLE} " .
			"(athlete_id, week, position, e, f, m, s) VALUES " .
			"(" . $this->athlete->getId() . ", '" . $week . "', " .
			$this->position . ", " . $this->subPositions["E"] .
			", " . $this->subPositions["F"] .
			", " . $this->subPositions["M"] .
			", " . $this->subPositions["S"] . ")";
		$this->DB->query($sql);	
	}
	
	/**
	 * in this special case the sequence will be rewinded if we're out of data
	 */
	public function next() {
		// advance the main sequence for one step
		$this->nextMain();

		$type = $this->sequence[$this->position];
		// advance the sub sequence for one step and return the value it determines
		return $this->nextSub($type);
	}

	/**
	 * advances the main sequence one step
	 */
	protected function nextMain() {
		++$this->position;
		if ($this->position >= count($this->sequence)) {
			$this->rewind();
		}
	}

	/**
	 * advance the sub position one step
	 * @param string $type
	 */
	protected function nextSub($type) {
		// check if there are workouts in this phase for the provided type
		while (($numWorkoutsAvailable = count(TriRunWorkoutTypeSequence::
			$WORKOUT_TYPES[$this->phase][$type])) == 0) {
			$this->nextMain();
			if ($this->position == -1) {
				$this->position = 0;
			}
			$type = $this->sequence[$this->position];
		}
		
		// now that we've got workouts available continue the subsequence
		$this->subPositions[$type]++;
		
		// check if we're outta bounds and reset the subposition if so
		if ($this->subPositions[$type] >= $numWorkoutsAvailable) {
			$this->subPositions[$type] = 0;
		}

		if (!TriRunWorkoutTypeSequence::$WORKOUT_TYPES[$this->phase][$type][$this->subPositions[$type]]) {
			throw new Exception("Unknown sequence position for phase {$this->phase}, type {$type}, " .
				"subposition " . $this->subPositions[$type]);
		}
		return $type . TriRunWorkoutTypeSequence::
			$WORKOUT_TYPES[$this->phase][$type][$this->subPositions[$type]];
	}
}
?>