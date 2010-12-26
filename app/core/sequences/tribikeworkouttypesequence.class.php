<?php
class TriBikeWorkoutTypeSequence extends WorkoutTypeSequence {
	protected $TABLE = 'tribikeworkouttypesequence';	
	
	/**
	 * workouts grouped by phases
	 */
	protected static $WORKOUT_TYPES = array(
		"TRANS" => array(
				"E" => array(1,2),
				"F" => array(),
				"S" => array(),
				"M" => array()
	),
		"PREP" => array(
				"E" => array(1,2),
				"F" => array(),
				"S" => array(1),
				"M" => array()
	),
		"BASE1" => array(
				"E" => array(1,2,3),
				"F" => array(),
				"S" => array(1,2),
				"M" => array()
	),
		"BASE2" => array(
				"E" => array(1,2,3),
				"F" => array(1),
				"S" => array(1,2),
				"M" => array(1)
	),
		"BASE3" => array(
				"E" => array(1,2,3),
				"F" => array(1,2),
				"S" => array(1,2),
				"M" => array(1,2)
	),
		"BUILD1" => array(
				"E" => array(1,2),
				"F" => array(2,3),
				"S" => array(3),
				"M" => array(2,3,4)
	),
		"BUILD2" => array(
				"E" => array(1,2),
				"F" => array(3),
				"S" => array(3),
				"M" => array(2,3,4,5)
	),
		"PEAK" => array(
				"E" => array(1,2),
				"F" => array(3),
				"S" => array(3),
				"M" => array(2,3,4,5)
	),
		"RACE" => array(
				"E" => array(1,2),
				"F" => array(),
				"S" => array(3),
				"M" => array()
	)

	);
}
?>