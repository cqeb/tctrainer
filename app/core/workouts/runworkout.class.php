<?php 
/**
 * run workout
 * @author clemens
 *
 */
class RunWorkout extends Workout {	
	/**
	 * array of lsd-training duration in minutes
	 * the array key represents the weeks to go, so week 0
	 * is the race-week and thus identified by key 0 while
	 * week 7 is the 7th week before the race, and thus
	 * identified by key 7
	 */
	public static $LSD_TIMES = array(
		Athlete::BEGINNER => array (0, 180, 180, 0, 165, 150, 0, 135, 120, 0, 105, 95),
		Athlete::ADVANCED => array (0, 180, 180, 0, 180, 180, 0, 165, 165, 0, 150, 150)		
	);
	
	/**
	 * (non-PHPdoc)
	 * @see Workout::getSport()
	 */
	public function getSport() {
		return "RUN";
	}
	
	/**
	 * (non-PHPdoc)
	 * @see Workout::getTypeLabel()
	 */
	public function getTypeLabel() {
		switch ($this->type) {
			case Workout::E1:
				return __('Recovery', true);
				break;
			case Workout::E2:
				return __('Extensive Endurance', true);
				break;
			case Workout::E3:
				return __('Intensive Endurance', true);
				break;
			case Workout::S1:
				return __('Sprints', true);
				break;
			case Workout::S2:
				return __('Speedups', true);
				break;
			case Workout::F1:
				return __('Small Hills', true);
				break;
			case Workout::F2:
				return __('Long Hills', true);
				break;
			case Workout::F3:
				return __('Hill Climbs', true);
				break;
			case Workout::M1:
				return __('Tempo Run', true);
				break;
			case Workout::M2:
				return __('Intervals', true);
				break;
			case Workout::M3:
				return __('Hill Intervals', true);
				break;
			case Workout::M4:
				return __('Threshold Intevals', true);
				break;
			case Workout::M5:
				return __('Threshold Run', true);
				break;
			case Workout::TEST_SHORT:
				return __('Short Test', true);
				break;
			case Workout::TEST_LONG:
				return __('Long Test', true);
				break;
			default:
				return 'UNKNOWN';
				break;
		}
	}
	
	/**
	 * (non-PHPdoc)
	 * @see Workout::getDescription()
	 */
	public function getDescription() {
		switch ($this->type) {
			case Workout::E1:
				return __('Pick a flat course and run easy in Zone 1.', true);
				break;
			case Workout::E2:
				return __('Do an endurance run in Zone 2.', true);
				break;
			case Workout::E3:
				return __('An intensive, aerobic workout. Run a course with small hills, which take you into Zone 3 frequently.', true);
				break;
			case Workout::S1:
				return __('Do an endurance run in Zone 2. Sprint for 20 seconds after warming up. Repeat four to eight times during the run.', true);
				break;
			case Workout::S2:
				return __('Do an endurance run in Zone 2. After warming up accelerate smoothly until you reach a pace you could sustain for five kilometers. Repeat up to six times.', true);
				break;
			case Workout::F1:
				return __('Pick a hilly course, and run in Zones 1-5. Do not ascend longer than five minutes.', true);
				break;
			case Workout::F2:
				return __('Pick a hilly course with several ascents that take more than 5 minutes to climb. Your pulse may climb to Zone 5, but refrain from maxing out.', true);
				break;
			case Workout::F3:
				return __('Warm up thoroughly. Pick a steep hill, which takes about one minute to ascend. Run fast uphills, and jog down very easy (take up to 4mins to recover). Repeat to a maximum of eight times.', true);
				break;
			case Workout::M1:
				return __('Pick a flat course, and run in Zone 3 after warming up.', true);
				break;
			case Workout::M2:
				return __('Pick a flat course, and warm up. Accelerate to the top of Zone 4, and keep your pace for a maximum of ten minutes (you may want to start with five). Recover for two minutes after each interval, and repeat three to five times.', true);
				break;
			case Workout::M3:
				return __('Warm up thoroughly. On a hilly track with small climbs accelerate to the top of Zone 4, and keep your pace for a maximum of ten minutes (you may want to start with five). Recover for two minutes after each interval, and repeat three to five times. You can also pick a track with strong headwinds.', true);
				break;
			case Workout::M4:
				return __('Accelerate slowly after warming up. When Zone 4 is reached, take two minutes to accelerate into the lower third of Zone 5. Then gradually slow down for another two minutes to reach the bottom of Zone 4. Repeat this pattern to a maximum of 30 minutes. Cool down afterwards in Zone 2.', true);
				break;
			case Workout::M5:
				return __('Pick a flat course. After warming up establish Zone 5, and keep running without recovery. STOP immediately if you feel nauseous.', true);				
				break;
			case Workout::TEST_SHORT:
				return __('Pick a flat course, and run like as if you would be racing. Go hard from the beginning, and press the "Lap"-Button on your sports watch to determine your average heart rate for the last 20 minutes.', true);
				break;
			case Workout::TEST_LONG:
				return __('Pick a flat course, and run like as if you would be racing. Go hard from the beginning, and press the "Lap"-Button on your sports watch to determine your average heart rate for the last 50 minutes.', true);
				break;
			default:
				return 'UNKNOWN';
				break;
		}
		
	}
	
	/**
	 * (non-PHPdoc)
	 * @see Workout::getAVGHR()
	 */
	public function getAVGHR(Athlete $athlete) {
		// TODO an athlete's historical workout data should aeffect the return val
		// TODO review these values - they seem arbitrary & bogus
		// zones
		$z = $athlete->getZones($this->getSport());
		switch ($this->type) {
			case Workout::E1:
				return intval(($z[0] + $z[1]) / 2);
				break;
			case Workout::E2:
				return $z[1] + 3;
				break;
			case Workout::E3:
				return $z[3] - 5;
				break;
			case Workout::S1:
				return $z[2];
				break;
			case Workout::S2:
				return $z[2] + 3;
				break;
			case Workout::F1:
				return $z[3] - 4;
				break;
			case Workout::F2:
				return $z[3];
				break;
			case Workout::F3:
				return $z[3] + 5;
				break;
			case Workout::M1:
				return $z[3] - 3;
				break;
			case Workout::M2:
				return $z[3];
				break;
			case Workout::M3:
				return $z[3] - 2;
				break;
			default:
				return 'UNKNOWN';
				break;
		}
	}
}
?>