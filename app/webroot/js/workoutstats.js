/**
 * this class will calculate workout stats for an athlete
 */
WorkoutStats = {
	/**
	 * approximate kcals as done in unitcalc
	 */
	calcKcal : function (sex, weight, age, duration, hr) {
		if (sex == 'm') {
			return Math.round(
				( -55.0969 + 0.6309 * hr + 0.1988 * weight + 0.2017 * age ) 
				/ 
				( 4.1845 * duration / 60 )
			);
		} else {
			return Math.round(
				( -20.4022 + 0.4472 * avgHR + 0.1263 * weight + 0.074 * age )
				/
				( 4.1845 * duration / 60 )
			);
		}            
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