/**
 * this class will calculate workout stats for an athlete
 */
WorkoutStats = {
	/**
	 * approximate kcals as done in unitcalc
	 * @param sex the athletes sex (may be m or f)
	 * @param weight in kilograms
	 * @param age in years
	 * @param duration in SECONDS!
	 * @param hr average heart rate
	 */
	calcKcal : function (sex, weight, age, duration, hr) {
		var ret;
		if (sex == 'm') {
			ret = Math.round(
				( -55.0969 + 0.6309 * hr + 0.1988 * weight + 0.2017 * age ) 
				/ 
				4.1845 * duration / 60
			);
		} else {
			ret = Math.round(
				( -20.4022 + 0.4472 * hr + 0.1263 * weight + 0.074 * age )
				/
				4.1845 * duration / 60
			);
		}
		
		// as negative values may occur on extremely low pulse values, 
		// we'll cap them with 0
		if (ret < 0) {
			ret = 0;
		}
		
		if (isNaN(ret)) {
			return 0;
		}
		
		return ret;
	},
	
	/**
	 * will calculate the average speed with
	 * two floating point precision
	 * @param distance
	 * @param time (should be hours)
	 */
	calcSpeed : function (distance, time) {
		// convert , to .
		distance = parseFloat(distance.replace(',', '.'));
		var spd = distance / time;
		if (isNaN(spd)) {
			spd = 0;
		}
		return spd.toFixed(2);
	},
	
	/**
	 * calculate trimp points for a workout
	 * 
	 * @param int average heart rate for that workout
	 * @param int training time in minutes
	 * @param array training zones 1-5 as an array, starting with index 0
	 * @see Athlete::calcTrimp
	 */
	calcTrimp : function (avgHr, minutes, zones) {
		var factor = 0;
		avgHR = parseInt(avgHr);
		// if there is no proper hr given, we'll use zone 2.
		if (avgHr <= 0) {
			avgHr = zones[1];
		}
		
		if (avgHr < zones[1]) {
			factor = 1;
		} else if (avgHr < zones[2]) {
			factor = 1.1;
		} else if (avgHr < zones[3]) {
			factor = 1.2;
		} else if (avgHr < zones[4]) {
			factor = 2.2;
		} else {
			factor = 4.5;
		}
		
		return parseInt(minutes * factor);
	}
};