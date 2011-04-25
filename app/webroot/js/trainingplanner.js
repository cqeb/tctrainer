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
	// true, if the user is training for triathlon
	tri : false,
	// default workout time ratios
	ratioTriathlon : [20,60],
	ratioDuathlon : [40],


	/**
	 * initialize the training planner
	 * @param url ajax request url base for retrieving plans
	 * @param weeklymins minutes for training for this week
	 * @param usersport the user's sport
	 */
	init : function (url, weeklymins, usersport, advancedFeatures) {
		var that = this;
		this.url = url;
		this.sports = usersport.split(',');
		if (this.sports.length == 3) {
			this.tri = true;
		}
		
		this.advancedFeatures = advancedFeatures;
		
		this.initDescriptionToggler();
		
		this.initDistributor();
		
		$('#avg').val(TimeParser.format(weeklymins) + "h");
		
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
		var d = jQuery(".distribution .box");
		if (this.sports.length == 1) {
			d.hide();
			return;
		}
		
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
		// no more previews than three months
		if (this.offset == 3 && !this.advancedFeatures) {
			this.n.fadeOut();
		}
	},
	
	/**
	 * get previous training plan
	 */
	prev : function () {
		this.offset--;
		this.getPlan();
		if (this.offset < 3) {
			this.n.fadeIn();
		}
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
			$('#plan').html(that.addZoneInfo(data));
			// now re-attach the zoneguide
			ZoneGuide.attach();
			
			// adapt visibility of descriptions
			if (!descriptionsVisible) {
				jQuery('td.description div').hide();
			}
			
			// update weekly training hours
			if (workoutSettings.usertime > 0) {
				$('#week').val(TimeParser.format(workoutSettings.usertime) + 'h');
			} else {
				$('#week').val(TimeParser.format(workoutSettings.time) + 'h');
			}

			// update ratios
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
			
			// check workout balance for changes
			that.checkBalance();
			
			// finally apply tipTips
			jQuery('#plan .category, img.lsd, .workouts .type button').tipTip();
			
			// follow linked workout
			jQuery('.workouts .type button')
				.click(function () { 
					that.linkWorkout(jQuery(this));
				});
		});
	},

	/**
	 * will either attempt to create a new training in the log
	 * or show a training that was already entered
	 */
	linkWorkout : function(b) {
		var params;
		params = '?sportstype=' + b.attr('data-sportstype')	+
			'&workouttype=' + b.attr('data-workouttype') + 
			'&duration=' + b.attr('data-duration') +
			'&avghr=' + b.attr('data-avghr');

		// redirect
		document.location = '/trainer/trainingstatistics/edit_training' + params;
	},
	
	/**
	 * will add zone markup to highlight individual
	 * training zones
	 */
	addZoneInfo : function(html) {
		return html.replace(/(Zone \d)/g, '<span class="zone">$1</span>');
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
		var val1 = 0;
		var val2 = 0;
		var ratio = null;
		if (this.sports.length == 3) {
			val1 = slider.slider("values", 0);
			val2 = slider.slider("values", 1);
			ratio = val1 + "," + (val2-val1) + "," + (100-val2);
		} else if (this.sports.length == 2) {
			val1 = slider.slider("value");
			ratio = val1 + "," + (100-val1);
		}
		
		$.post(this.url + '/trainingplans/save_workout_settings', {
			time : avg,
			usertime : week,
			ratio : ratio,
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
		avg.val(TimeParser.format() + 'h');
	},

	/**
	 * triggers if the weekly training value has been updated
	 * @param save set to true if changes should be persisted
	 */
	weekUpdated : function (save) {
		var week = $('#week');
		TimeParser.parse(week.val());
		week.val(TimeParser.format() + 'h');
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
		var val1 = this.slider.slider("values", 0);
		if (this.tri) {
			var val2 = this.slider.slider("values", 1);
		}

		TimeParser.parse($('#week').val());
		var minsPercent = TimeParser.mins / 100;

		// split mins according to the slider
		var mins1 = parseInt(val1 * minsPercent);
		if (this.tri) {
			var mins2 = parseInt((val2 - val1) * minsPercent);
		} else {
			var mins2 = parseInt((100 - val1) * minsPercent);
		}

		// now render times to the html elements
		$('#time1').text(TimeParser.format(mins1) + 'h'); 
		$('#time2').text(TimeParser.format(mins2) + 'h'); 

		// update percentage values
		$('#p1').text(val1 + "%");
		if (this.tri) {
			$('#p2').text((val2 - val1) + "%");
		} else {
			$('#p2').text((100 - val1) + "%");
		}

		if (this.tri) {
			var mins3 = parseInt((100 - val2) * minsPercent);
			$('#time3').text(TimeParser.format(mins3) + 'h'); 
			$('#p3').text((100 - val2) + "%");
		}
		
		this.checkBalance();
	},
	
	resetWeeklyHours : function () {
		$('#week').val(TimeParser.format(workoutSettings.time) + 'h');
		this.weekUpdated(true);
	},
	
	/**
	 * check if the workout balance is set to default values
	 * if not, the reset switch will be enabled
	 */
	checkBalance : function () {
		if (this.sports.length == 1) {
			return; // just one sport - do nothing.
		}
		var val0 = this.slider.slider("values", 0);
		if (this.tri) {
			var val1 = this.slider.slider("values", 1);
			if (val0 != this.ratioTriathlon[0] || val1 != this.ratioTriathlon[1]) {
				jQuery('.distribution .reset').fadeIn();
			} else {
				jQuery('.distribution .reset').fadeOut();
			}
		} else if (this.sports.length == 2) {
			if (val0 != this.ratioDuathlon[0]) {
				jQuery('.distribution .reset').fadeIn();
			} else {
				jQuery('.distribution .reset').fadeOut();
			}
		}
	},
	
	/**
	 * will reset the workout balance to default settings
	 */
	resetWorkoutBalance : function () {
		if (this.sports.length == 1) {
			return; // just one sport - do nothing.
		}
		if (this.tri) {
			this.slider.slider("option", "values", this.ratioTriathlon);
		} else {
			this.slider.slider("option", "value", this.ratioDuathlon[0]);
		}
		this.balanceUpdated();
		this.saveWorkoutSettings();
	}
};