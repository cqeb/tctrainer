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
	 * 
	 * start 11 weeks before the race
	 * six long rides before the race
	 * 3,5h ist the first long ride
	 * last long ride 3 weeks before the race, bout 6hrs long
	 */
	public static $LSD_TIMES = array(
		Athlete::BEGINNER => array (0, 180, 360, 0, 330, 300, 0, 270, 240, 0, 210, 180),
		Athlete::ADVANCED => array (0, 180, 390, 0, 360, 330, 0, 300, 270, 0, 240, 210)		
	);
	
	public function getTypeLabel() {
		return "Bike Workout";
	}
	
	public function getDescription() {
		return false;
	}
	
	// TODO an athlete's historical workout data should aeffect the return val
	// TODO review these values - they seem arbitrary & bogus
	public function getAVGHR(Athlete $athlete) {
		return 140;
	}
}
?>