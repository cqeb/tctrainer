<?php 
/**
 * bike workout
 * @author clemens
 *
 */
class BikeWorkout extends Workout {
	/**
	 * this identifies the workout as a run workout in the database
	 * @var string
	 */
	public static $SPORT = "BIKE";
	
	/**
	 * array of lsd-training duration in minutes
	 * the array key represents the weeks to go, so week 0
	 * is the race-week and thus identified by key 0 while
	 * week 7 is the 7th week before the race, and thus
	 * identified by key 7
	 */
	/*public static $LSD_TIMES = array(
		Athlete::BEGINNER => array (0, 180, 180, 0, 165, 150, 0, 135, 120, 0, 105, 95),
		Athlete::ADVANCED => array (0, 180, 180, 0, 180, 180, 0, 165, 165, 0, 150, 150)		
	);*/
	
	public function getTypeLabel() {
		return "Bike Workout";
	}
	
	// TODO an athlete's historical workout data should aeffect the return val
	// TODO review these values - they seem arbitrary & bogus
	public function getAVGHR(Athlete $athlete) {
		return 140;
	}
}
?>