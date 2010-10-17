/**
 * manages retrieval and update of plans
 */
TrainingPlanner = {
	offset : 0,
	initialized : false,
	url : '',
	slider : null,
	// shortcut to previous button
	p : null,
	// shortcut to next button
	n : null,
	
	// old value for weekly minutes
	oldWeek : -1,

	/**
	 * initialize the pager
	 */
	init : function (url, weeklymins) {
		var that = this;
		this.url = url;
		
		$('#avg').val(TimeParser.format(weeklymins));
		
		// init the slider
		this.slider = $("#slider");
		this.slider.slider({
			range: true,
			min: 0,
			max: 100,
			values: [0,0],
			slide: function(event, ui) {
				that.balanceUpdated();
			},
			stop: function () {
				that.saveWorkoutSettings();
			}
		});
		
		// prepare input fields
		// $('#avg').blur(avgUpdated).keyup(function (e) {
		//	if (e.keyCode == 13) {
		//		avgUpdated();
		//	}
		//});
		$('#week').blur(function () {
			that.weekUpdated(true);
		}).keyup(function (e) {
			if (e.keyCode == 13) {
				that.weekUpdated(true);
			}
		}).focus(function () {
			TrainingPlanner.oldWeek = TimeParser.parse(this.value);
			this.select();
		});
		
		// prev & next buttons
		this.p = $('#prev');
		this.n = $('#next');
		this.p.click(function () {
			that.prev();
			that.lock();
		});
		this.n.click(function () {
			that.next();
			that.lock();
		});

		// get the first plan
		this.getPlan();
		
		// init is done
		this.initialized = true;
	},
	
	/**
	 * get next training plan
	 */
	next : function () {
		this.offset++;
		this.getPlan();
	},
	
	/**
	 * get previous training plan
	 */
	prev : function () {
		this.offset--;
		this.getPlan();
	},
	
	/**
	 * lock buttons after a request has been made
	 */
	lock : function () {
		this.p.attr('disabled', 'disabled');
		this.n.attr('disabled', 'disabled');
	},

	/**
	 * unlock after a successful request
	 */
	unlock : function () {
		// leave the next button disabled on offset of 2
		//if (this.offset < 2) {
			this.n.removeAttr("disabled");
		//}
		this.p.removeAttr("disabled");
	},

	/**
	 * retrieve a plan
	 */
	getPlan : function () {
		var that = this;
		$('#plan').fadeTo("slow", 0.4);
		$('#loader').fadeIn();

		// add time to prevent caching
		var url = this.url + "/trainingplans/get?o=" + this.offset + "&t=" + (new Date().getTime()); 

		// request the plan
		$.get(url, function (data) {
			$('#plan').html(data);

			// update weekly training hours
			if (workoutSettings.usertime > 0) {
				$('#week').val(TimeParser.format(workoutSettings.usertime));
			} else {
				$('#week').val(TimeParser.format(workoutSettings.time));
			}

			// update ratio setting
			var ratio = [workoutSettings.ratio[0], workoutSettings.ratio[0] + workoutSettings.ratio[1]];
			// update the slider
			that.slider.slider("option", "values", ratio);

			$('#plan').fadeTo("normal", 1);
			$('#loader').fadeOut();

			that.weekUpdated(false);
			
			// unlock the training pager
			that.unlock();
		});
	},

	/**
	 * persist user settings to database (training time & ratio)
	 */
	saveWorkoutSettings : function () {
		var that = this;
		
		if (!this.initialized) {
			return;
		}

		$('#plan').fadeTo("slow", 0.4);
		$('#loader').fadeIn();
		
		TimeParser.parse($('#avg').val());
		var avg = TimeParser.mins;
		TimeParser.parse($('#week').val());
		var week = TimeParser.mins;
		var slider = $("#slider");
		var val1 = slider.slider("values", 0);
		var val2 = slider.slider("values", 1);
		
		$.post(this.url + '/trainingplans/save_workout_settings', {
			time : avg,
			usertime : week,
			ratio : val1 + "," + (val2-val1) + "," + (100-val2),
			date : workoutSettings.date
		}, function (data) {
			if (data == "ok") {
				that.getPlan();
			} else {
				// TODO error handling
			}
		});
	},
	
	avgUpdated : function () {
		var avg = $('#avg');
		TimeParser.parse(avg.val());
		avg.val(TimeParser.format());
	},

	/**
	 * triggers if the weekly training value has been updated
	 * @param save set to true if changes should be persisted
	 */
	weekUpdated : function (save) {
		var week = $('#week');
		TimeParser.parse(week.val());
		week.val(TimeParser.format());
		// show reset button if applicable
		if (workoutSettings.time != TimeParser.mins) {
			$('.avgweekly .reset').fadeIn();
		} else {
			$('.avgweekly .reset').fadeOut();
		}
		// only update plan if values were updated
		if (TimeParser.mins == this.oldWeek) {
			return;
		}
		this.balanceUpdated();
		if (save) {
			this.saveWorkoutSettings();
		}
	},

	balanceUpdated : function () {
		var val1 = this.slider.slider("values", 0);
		var val2 = this.slider.slider("values", 1);

		TimeParser.parse($('#week').val());
		var minsPercent = TimeParser.mins / 100;

		// split mins according to the slider
		var mins1 = parseInt(val1 * minsPercent);
		var mins2 = parseInt((val2 - val1) * minsPercent);
		var mins3 = parseInt((100 - val2) * minsPercent);

		// now render times to the html elements
		$('#time1').text(TimeParser.format(mins1)); 
		$('#time2').text(TimeParser.format(mins2)); 
		$('#time3').text(TimeParser.format(mins3)); 

		// update percentage values
		$('#p1').text(val1 + "%");
		$('#p2').text((val2 - val1) + "%");
		$('#p3').text((100 - val2) + "%");
	},
	
	resetWeeklyHours : function () {
		$('#week').val(TimeParser.format(workoutSettings.time));
		this.weekUpdated(true);
	}
};