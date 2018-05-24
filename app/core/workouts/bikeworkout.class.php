<?php 
/**
 * bike workout
 * @author clemens
 *
 */
class BikeWorkout extends Workout {
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

	/**
	 * (non-PHPdoc)
	 * @see Workout::getSport()
	 */
	public function getSport() {
		return "BIKE";
	}
	
	/**
	 * (non-PHPdoc)
	 * @see Workout::getTypeLabel()
	 */
	public function getTypeLabel($type=false) {
		if (!$type) {
			$type = $this->type;
		} 
		switch ($type) {
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
				return __('Cadence Intervals', true);
				break;
			case Workout::S2:
				return __('Single Leg Intervals', true);
				break;
			case Workout::S3:
				return __('Sprints', true);
				break;
			case Workout::F1:
				return __('Moderate Hills', true);
				break;
			case Workout::F2:
				return __('Long Hills', true);
				break;
			case Workout::F3:
				return __('Hill Climbs', true);
				break;
			case Workout::M1:
				return __('Tempo Ride', true);
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
				return __('Threshold Ride', true);
				break;
			case Workout::TEST_SHORT:
				return __('Short Test', true);
				break;
			case Workout::TEST_LONG:
				return __('Long Test', true);
				break;
			case Workout::COMPETITION:
				return __('Competition', true);
				break;
			default:
				return false;
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
				return __('Do an easy ride in Zone 1.', true);
				break;
			case Workout::E2:
				return __('Do an endurance ride in Zone 2.', true);
				break;
			case Workout::E3:
				return __('An intensive, aerobic workout. Ride a course with small hills, which take you into Zone 3 frequently.', true);
				break;
			case Workout::S1:
				return __('Ride in Zone 2. Shift to a very light gear and increase your cadence to maximum (before you start bouncing) over 1 minute, and hold as long as possible. Recover for 1 minute, and repeat several times.', true);
				break;
			case Workout::S2:
				return __('Ride in Zone 2. Shift to a light gear, and start exercising with just one of your legs. The other foot remains on the pedal, but does not support. Change legs when fatigue settles in and repeat several times.', true);
				break;
			case Workout::S3:
				return __('Do an endurance ride in Zone 2, but insert several 10-second sprints with maximum effort.', true);
				break;
			case Workout::F1:
				return __('Pick a hilly course, and ride in Zone 1 to Zone 5. The hills should take about 5 minutes to ascend. Do not stand up while climbing.', true);
				break;
			case Workout::F2:
				return __('Pick a hilly course with several ascents that take more than 5 minutes to climb. Stay seated, and do not max out your pulse while climbing.', true);
				break;
			case Workout::F3:
				return __('Warm up thoroughly. Pick a steep hill, which takes about 1 minute to ascend. Climb fast, and ride down very easy while spinning lightly. Do not stand up while climbing. Repeat to a maximum of 8 times.', true);
				break;
			case Workout::M1:
				return __('Pick a flat course, and ride in Zone 3 with low cadence after warming up.', true);
				break;
			case Workout::M2:
				return __('Pick a flat course, and warm up. Accelerate to the top of Zone 4, and keep your speed for a maximum of 10 minutes (you may want to start with 5), while pedaling with low cadence. Recover for 2 minutes after each interval, and repeat 3-5 times.', true);
				break;
			case Workout::M3:
				return __('Warm up thoroughly. On a hilly track with small climbs accelerate to the top of Zone 4, and keep your speed for a maximum of 10 minutes (you may want to start with 5), while pedaling with low cadence. Recover for 2 minutes after each interval, and repeat 3-5 times. You can also pick a track with strong headwinds.', true);
				break;
			case Workout::M4:
				return __('Accelerate slowly after warming up. When Zone 4 is reached, take 2 minutes to accelerate into the lower third of Zone 5. Then gradually slow down for another 2 minutes to reach the bottom of Zone 4. Repeat this pattern to a maximum of 40 minutes. Cool down afterwards in Zone 2, and ride with a low cadence during the intervals.', true);
				break;
			case Workout::M5:
				return __('Pick a flat course. After warming up establish Zone 5, and stay there while maintaining low cadence. STOP immediately if you feel nauseous.', true);				
				break;
			case Workout::TEST_SHORT:
				return __('Pick a flat course, and ride like as if you would be racing. Go hard from the beginning, and press the "Lap"-Button on your sports watch to determine your average heart rate for the last 20 minutes. Use this value to update your bike lactate threshold in your training info settings.', true) .
					' <button class="trainingplan" onclick="document.location.href=\'/trainer/users/edit_traininginfo\'">' . __('Edit training info', true) . '</button>';
				break;
			case Workout::TEST_LONG:
				return __('Pick a flat course, and ride like as if you would be racing. Go hard from the beginning, and press the "Lap"-Button on your sports watch to determine your average heart rate for the last 50 minutes. Use this value to update your bike lactate threshold in your training info settings.', true) .
					' <button class="trainingplan" onclick="document.location.href=\'/trainer/users/edit_traininginfo\'">' . __('Edit training info', true) . '</button>';
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
				return $z[2] + 2;
				break;
			case Workout::S2:
				return $z[2] + 3;
				break;
			case Workout::S3:
				return $z[2] + 5;
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
			case Workout::TEST_LONG:
			case Workout::TEST_SHORT:
				return $z[4] + 1;
				break;
			default:
				return 'UNKNOWN';
				break;
		}
	}
}
?>