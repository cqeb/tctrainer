<?php
class TriSwimWorkoutTypeSequence extends WorkoutTypeSequence {
	protected $TABLE = 'triswimworkouttypesequence';	
	
	/**
	 * workouts grouped by phases
	 */
	protected $WORKOUT_TYPES = array(
		"TRANS" => array(
				"E" => array(1,2),
				"F" => array(),
				"S" => array(1,2,3),
				"M" => array()
	),
		"PREP" => array(
				"E" => array(1,2,3),
				"F" => array(),
				"S" => array(1,2,3),
				"M" => array()
	),
		"BASE1" => array(
				"E" => array(1,2,3),
				"F" => array(),
				"S" => array(1,2,3),
				"M" => array()
	),
		"BASE2" => array(
				"E" => array(1,2,3),
				"F" => array(1,2,3),
				"S" => array(1,2,3),
				"M" => array(1,2)
	),
		"BASE3" => array(
				"E" => array(1,2,3),
				"F" => array(1,2,3),
				"S" => array(1,2,3),
				"M" => array(1,2,3)
	),
		"BUILD1" => array(
				"E" => array(1,2),
				"F" => array(1,2,3),
				"S" => array(1,2,3),
				"M" => array(1,2,3)
	),
		"BUILD2" => array(
				"E" => array(1,2),
				"F" => array(1),
				"S" => array(1,2,3),
				"M" => array(1,2,3)
	),
		"PEAK" => array(
				"E" => array(1,2),
				"F" => array(),
				"S" => array(1,2,3),
				"M" => array(1,2,3)
	),
		"RACE" => array(
				"E" => array(1,2),
				"F" => array(),
				"S" => array(1,2,3),
				"M" => array()
	)

	);
}
?>