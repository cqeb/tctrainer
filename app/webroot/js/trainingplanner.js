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
	// array of sports
	sports : null,
	
	// old value for weekly minutes
	oldWeek : -1,

	/**
	 * initialize the training planner
	 * @param url ajax request url base for retrieving plans
	 * @param weeklymins minutes for training for this week
	 * @param usersport the user's sport
	 */
	init : function (url, weeklymins, usersport) {
		var that = this;
		this.url = url;
		this.sports = usersport.split(',');
		
		this.initDescriptionToggler();
		
		this.initDistributor();
		
		$('#avg').val(TimeParser.format(weeklymins));
		
		// init the slider
		this.slider = $("#slider");
		if (this.sports.length == 2) {
			this.slider.slider({
				range: false,
				min: 0,
				max: 100,
				value: 0,
				slide: function(event, ui) {
					that.balanceUpdated();
				},
				stop: function () {
					that.saveWorkoutSettings();
				}
			});
		} else if (this.sports.length == 3) {
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
		}
		
		/*
		 * prepare input fields
		 */ 
		// average weekly training hours
		$('#avg').change(function() {
			var v = TimeParser.parse(jQuery(this).val());
			// update settings
			jQuery.post(that.url + "/trainingplans/set_avg", 
				{ time : v },
				function () {
					// seems to be successful so reload.
					document.location.reload();
				}
			);
		});
		
		// this weeks training hrs
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
	 * initializes the toggle description button state
	 */
	initDescriptionToggler : function () {
		jQuery('#toggleDesc').click(function () {
			// toggle description visibility
			var descs = jQuery('td.description div');
			descs.slideToggle();
			
			// toggle button text
			var button = jQuery(this);
			var descr = button.html();
			button.html(button.attr('data-toggletext'));
			button.attr('data-toggletext', descr);
		});
	},
	
	/**
	 * initializes the sport time distributor
	 */
	initDistributor : function () {
		if (this.sports.length == 1) {
			return;
		}
		
		var d = jQuery(".distribution .box");
		var last = '';
		for (var i=0; i<this.sports.length; i++) {
			if (i == (this.sports.length - 1)) {
				last = 'last';
			}
			d.append('<div class="sporttime br ' + last + '">' +
			'<h3>' + this.sports[i] + ' <small id="p' + (i+1) + '">0%</small></h3>' +
			'<div id="time' + (i+1) + '"></div>' +
			'</div>');
		}
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
		// remember description display status
		if (this.initialized) {
			var descriptionsVisible = jQuery('td.description div').is(':visible');
		} else {
			// TODO restore settings from cookie here!
			var descriptionsVisible = true;
		}
		
		$('#plan').fadeTo("slow", 0.4);
		$('#loader').fadeIn();

		// add time to prevent caching
		var url = this.url + "/trainingplans/get?o=" + this.offset + "&t=" + (new Date().getTime()); 

		// request the plan
		$.get(url, function (data) {
			$('#plan').html(data);

			// adapt visibility of descriptions
			if (!descriptionsVisible) {
				jQuery('td.description div').hide();
			}
			
			// update weekly training hours
			if (workoutSettings.usertime > 0) {
				$('#week').val(TimeParser.format(workoutSettings.usertime));
			} else {
				$('#week').val(TimeParser.format(workoutSettings.time));
			}

			if (that.sports.length == 2) {
				// update the slider
				that.slider.slider("option", "value", workoutSettings.ratio[0]);
			} else if (that.sports.length == 3) {
				// update ratio setting
				var ratio = [workoutSettings.ratio[0], workoutSettings.ratio[0] + workoutSettings.ratio[1]];
				// update the slider
				that.slider.slider("option", "values", ratio);
			}
			
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
		if (this.sports.length == 1) {
			return;
		}
		var tri = (this.sports.length == 3);
		
		var val1 = this.slider.slider("values", 0);
		if (tri) {
			var val2 = this.slider.slider("values", 1);
		}

		TimeParser.parse($('#week').val());
		var minsPercent = TimeParser.mins / 100;

		// split mins according to the slider
		var mins1 = parseInt(val1 * minsPercent);
		if (tri) {
			var mins2 = parseInt((val2 - val1) * minsPercent);
		} else {
			var mins2 = parseInt((100 - val1) * minsPercent);
		}

		// now render times to the html elements
		$('#time1').text(TimeParser.format(mins1)); 
		$('#time2').text(TimeParser.format(mins2)); 

		// update percentage values
		$('#p1').text(val1 + "%");
		if (tri) {
			$('#p2').text((val2 - val1) + "%");
		} else {
			$('#p2').text((100 - val1) + "%");
		}

		if (tri) {
			var mins3 = parseInt((100 - val2) * minsPercent);
			$('#time3').text(TimeParser.format(mins3)); 
			$('#p3').text((100 - val2) + "%");
		}
	},
	
	resetWeeklyHours : function () {
		$('#week').val(TimeParser.format(workoutSettings.time));
		this.weekUpdated(true);
	}
};