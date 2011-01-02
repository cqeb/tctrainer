<?php 
/**
 * swim workout
 * @author clemens
 *
 */
class SwimWorkout extends Workout {
	/**
	 * (non-PHPdoc)
	 * @see Workout::getSport()
	 */
	public function getSport() {
		return "SWIM";
	}
	
	/**
	 * (non-PHPdoc)
	 * @see Workout::getTypeLabel()
	 */
	public function getTypeLabel() {
		return "Swim Workout";
	}
	
	/**
	 * (non-PHPdoc)
	 * @see Workout::getDescription()
	 */
	public function getDescription() {
		return;
	}
	
	/**
	 * (non-PHPdoc)
	 * @see Workout::getAVGHR()
	 */
	public function getAVGHR(Athlete $athlete) {
		// TODO an athlete's historical workout data should aeffect the return val
		// TODO review these values - they seem arbitrary & bogus
		return 120;
	}
}
?>