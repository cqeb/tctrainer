<?php 
/**
 * swim workout
 * @author clemens
 *
 */
class SwimWorkout extends Workout {
	/**
	 * this identifies the workout as a run workout in the database
	 * @var string
	 */
	public static $SPORT = "SWIM";
	
	public function getTypeLabel() {
		return "Swim Workout";
	}
	
	// TODO an athlete's historical workout data should aeffect the return val
	// TODO review these values - they seem arbitrary & bogus
	public function getAVGHR(Athlete $athlete) {
		return 120;
	}
}
?>