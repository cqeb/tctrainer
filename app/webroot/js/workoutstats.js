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
				( -20.4022 + 0.4472 * avgHR + 0.1263 * weight + 0.074 * age )
				/
				4.1845 * duration / 60
			);
		}
		
		// as negative values may occur on extremely low pulse values, 
		// we'll cap them with 0
		if (ret < 0) {
			ret = 0;
		}
		return ret;
	},
	
	/**
	 * will calculate the average speed with
	 * one floating point precision
	 * @param distance
	 * @param time (should be hours)
	 */
	calcSpeed : function (distance, time) {
		// convert , to .
		distance = parseFloat(distance.replace(',', '.'));
		var spd = distance / time;
		return Math.round(spd * 10) / 10;
	},
	
	/**
	 * calculate trimp points for a workout
	 * will be calculated by a rest service
	 */
	calcTrimps : function (avgHr, sport, time) {
		var trimps = 0;
		jQuery.ajax({
			url: "/trainer/trainingplans/calc_trimp",
			async: false,
			context: document.body,
			data : {
				hr : avgHr,
				sport : sport,
				time : time
			},
			success: function(data){
				trimps = data;
			}
		});
		return trimps;
	}
};