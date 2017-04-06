<?php
$url = '/trainer';
?>
	<!--<link rel="stylesheet" type="text/css" href="<?php echo $url; ?>/css/edittraining.css?v=<?php echo VERSION; ?>" />-->

      <div class="panel panel-default" id="forms">
        <div class="panel-heading"><h1><?php __('Workout details'); ?></h1></div>
        
        <div class="panel-body">

		<?php echo $form->create('Trainingstatistic', array('action' => 'edit_training', 'class' => 'form-horizontal')); ?>

		<fieldset>

<div class="form-group">
<?php 

echo $form->input('date',
	array(
        'class' => 'required form-control',
		'label' => __('Workout', true) . '-' . __('Date', true),
        'minYear' => date('Y',time())-1,
        'maxYear' => date('Y',time())+1
));
?>

</div>

<div class="form-group">

<!--
<div class="sportworkoutlabels">
<label><?php __('Workout'); ?></label>
</div>
-->

	<div class="sportworkout">

<span style="display:none;">
<?php
echo $form->input('sportstype',
	array(
		'legend' => false,
        'label' => false, //__('Sport', true),
		'type' => 'radio',
        'class' => '',
		'default' => 'RUN',
        'options' => array(
			'RUN' => __('Run', true),
            'BIKE' => __('Bike', true),
            'SWIM' => __('Swim', true)
		),
		'div' => array(
			'id' => 'sportstype'
		)
));
?>
</span>

	<div class="btn-group sport-select">
		<button type="button" id="buttonRUN" data-sport="RUN" class="btn btn-primary"><?php __('Run'); ?></button>
		<button type="button" id="buttonBIKE" data-sport="BIKE" class="btn btn-primary"><?php __('Bike'); ?></button>
		<button type="button" id="buttonSWIM" data-sport="SWIM" class="btn btn-primary"><?php __('Swim'); ?></button>
	</div>

<br /><br />

<?php
echo $form->input('swimworkouttypes',
	array(
		'label' => false,
		'type' => 'select',
		'class' => 'form-control',
		'options' => $workouts['Swim'],
		'div' => 'swimworkouttypes',
		'title' => __('Pick a workout type to specify which kind of workout you completed (optional)', true)
));

echo $form->input('bikeworkouttypes',
	array(
		'label' => false,
		'type' => 'select',
		'class' => 'form-control',		
		'options' => $workouts['Bike'],
		'div' => 'bikeworkouttypes',
		'title' => __('Pick a workout type to specify which kind of workout you completed (optional)', true)
));

echo $form->input('runworkouttypes',
	array(
		'label' => false,
		'type' => 'select',
		'class' => 'form-control',		
		'options' => $workouts['Run'],
		'div' => 'runworkouttypes',
		'title' => __('Pick a workout type to specify which kind of workout you completed (optional)', true)
));

echo $form->input('workouttype',
	array(
		'div' => 'workouttype',
		'label' => false,
		'style' => 'display:none;'
));
?>
	</div>
</div>

<div class="form-group">

<?php
echo $form->input('name',
	array(
		'div' => array(
			'id' => 'CourseName'
		),
        'before' => '<div class="input-group"><span class="input-group-addon">' . __('Course name', true) . 
        	'</span>',
        'after' => '</div>',		
		'maxLength' => 255,
        'class' => 'required form-control',
        'error' => array(
        	'notempty' => __('Enter name for your workout route', true)
		),
	'label' => false,
	'title' => __('Enter a name for your course, so you can identify it later (optional)', true)
));

echo '<br />';

echo $form->input('duration',
	array(
        'before' => '<div class="input-group"><span class="input-group-addon"><img src="/trainer/img/icons/duration.gif">' . __('Duration', true) . 
        	'</span>',
        'after' => '</div>',
        'label' => false,
		'title' => __('Enter the duration of your workout, using hours, minutes and seconds like: 01:15:23', true),
        'div' => 'wrap duration',
		'default' => '00:00:00',
        'maxLength' => 255,
        'class' => 'required form-control',
        'error' => array(
        	'notempty' => __('Enter a duration for your workout', true),
            'greater' => __('Enter a duration for your workout', true)
)));

echo '<br />';

echo $form->input('avg_pulse',
	array(
        'before' => '<div class="input-group"><span class="input-group-addon"><img src="/trainer/img/icons/heartrate.gif">' . 'bpm' . 
        	'</span>',
        'after' => '</div>',
        'label' => false,
		'title' => __('The average heart rate measured during your workout', true),
		'div' => 'wrap avg_pulse',
		'maxLength' => 255,
		'class' => 'required form-control',
        'error' => array(
        	'numeric' => __('Enter an average heart rate for your workout',true),
            'notempty' => __('Enter an average heart rate for your workout',true),
            'greater' => __('Must be greater than',true) . ' 80',
            'lower' => __('Must be lower than',true) . ' 240'
)));

echo '<br />';

echo $form->input('distance',
	array(
        'before' => '<div class="input-group"><span class="input-group-addon"><img src="/trainer/img/icons/distance.gif">' . $unit['length'] . 
        	'</span>',
        'after' => '</div>',
        'label' => false,
		'title' => __("The distance you've covered during your workout", true),
        'div' => 'wrap distance',
		'class' => 'required form-control',
        'maxLength' => 255,
        'error' => array(
        	'numeric' => __('Enter a distance for your workout',true), 
            'notempty' => __('Enter a distance for your workout',true)
)));

echo '<br />';

?>

<div class="input-group>
	<span class="input-group-addon">kcal</span>
	<span class="input-group-addon"><span id="kcal" class="badge"><?php if ($data && array_key_exists('kcal', $data)) { echo $data['kcal']; } ?></span></span>
	<span class="input-group-addon"><?php echo $unit['length']; ?>/h</span>
	<span class="input-group-addon"><span id="avgspeed" class="badge"><?php if ($data && array_key_exists('avg_speed', $data)) { echo $data['avg_speed']; } ?></span></span>
	<span class="input-group-addon">TRIMPs</span>
	<span class="input-group-addon"><span id="trimp" class="badge"><?php if ($data && array_key_exists('trimp', $data)) { echo $data['trimp']; } ?></span></span>
</div><br />

<a name="AF"></a>

<?php

$min_weight = $unitcalc->check_weight('40', 'single');
$min_weight = $min_weight['amount'] . ' ' . $unit['weight'];
$max_weight = $unitcalc->check_weight('150', 'single');
$max_weight = $max_weight['amount'] . ' ' . $unit['weight'];

echo $form->input('weight',
     array(
    'before' => '<div class="input-group"><span class="input-group-addon">' . __('Weight', true) . ' (' . $unit['weight'] . ')' . 
    	'</span>',
    'after' => '</div>',
    'label' => false,     	
     'div' => 'wrap weight',
	 'class' => 'required form-control',     
     'maxLength' => 5,
     'error' => array( 
             'numeric' => __('Enter your current weight',true),
             'greater' => __('Must be at least',true) . ' ' . $min_weight,
             'lower' => __('Must be lower than',true) . ' ' . $max_weight,
             'notempty' => __('Enter your current weight',true)
     )
));

echo '<br />';

?>
<div id="comment">
<label for="TrainingstatisticComment"><?php __('Comment'); ?></label>
<?php
echo $form->textarea('comment', array('rows' => '5', 'cols' => '35', 'class' => 'form-control'));
?>
</div><br />

<div class="clear"></div>

<?php
echo $form->input('workout_link',
	array(
		'before' => '<div class="input-group"><span class="input-group-addon">' . __('Link workout', true) . 
		' <button>&#8680;</button></span>',
		'after' => '<!--<span class="input-group-addon button-right"></span>--></div><br />',
		'label' => false, 		
		'maxLength' => 255,
		'class' => 'form-control',
		'title' => __('Add a link for your workout. You might want to check out www.runmap.net or www.bikemap.net for mapping your workouts!', true),
		'div' => array(
			'id' => 'workoutlink'
		)
	)
);
?>
<br />
<?php
echo $form->submit(__('Save',true),array('class' => 'btn btn-primary'));
?>
			</fieldset>

  </div>
</div>

<script type="text/javascript">
jQuery(document).ready(function() {

	// hide all select first
	jQuery('.swimworkouttypes, .bikeworkouttypes, .runworkouttypes').hide();
	jQuery('#buttonRUN').addClass('btn-success');
	
	// sportstype
	jQuery('.sport-select button')
		.click(function (e) {
			/**console.log(this);**/
			/**console.log(e);**/

			var el = jQuery(this),
			sport = el.data('sport');

			jQuery('#buttonRUN').removeClass('btn-success');
			jQuery('#buttonBIKE').removeClass('btn-success');
			jQuery('#buttonSWIM').removeClass('btn-success');

			jQuery('#button' + sport).addClass('btn-success');

			jQuery('#TrainingstatisticSportstypeRUN').prop('checked', false);
			jQuery('#TrainingstatisticSportstypeBIKE').prop('checked', false);
			jQuery('#TrainingstatisticSportstypeSWIM').prop('checked', false);

			jQuery('#TrainingstatisticSportstype' + sport).prop('checked', true);

			// hide all select first
			jQuery('.swimworkouttypes, .bikeworkouttypes, .runworkouttypes').hide();
			
			// .. then reveal the correct one
			if (sport === 'SWIM') {
				jQuery('.swimworkouttypes').show();
			} else if (sport === 'BIKE') {
				jQuery('.bikeworkouttypes').show();
			} else if (sport === 'RUN') {
				jQuery('.runworkouttypes').show();
			}
		});

	/**
	 * synchronize workouttype select fields
	 */
	function syncWorkouttypes(v) {
		// synchronize other workout types
		jQuery('.swimworkouttypes select option[value='
				+ v 
				+ '], '
				+ '.bikeworkouttypes select option[value='
				+ v
				+ '], '
				+ '.runworkouttypes select option[value='
				+ v
				+ ']').attr('selected', 'selected');
	}
	
	// workouttypes
	jQuery('.swimworkouttypes select, .bikeworkouttypes select, .runworkouttypes select')
		.change(function () {
			var v = jQuery(this).val();
			// sync workouttypes
			syncWorkouttypes(v);
			
			// store value
			jQuery('#TrainingstatisticWorkouttype').val(v);
		})
		.tipTip({ defaultPosition: 'top' });

	// init the workouttypes dropdown fields
	syncWorkouttypes(jQuery('#TrainingstatisticWorkouttype').val());

	// show workouttype that should be displayed by actual workout selection
	var sport = jQuery('#sportstype input[type=radio]:checked').val()
	if (sport == 'SWIM') {
		jQuery('.swimworkouttypes').show();
	} else if (sport == 'BIKE') {
		jQuery('.bikeworkouttypes').show();
	} else if (sport == 'RUN') {
		jQuery('.runworkouttypes').show();
	}

	var duration = jQuery('#TrainingstatisticDuration');
	var distance = jQuery('#TrainingstatisticDistance');
	var heartrate = jQuery('#TrainingstatisticAvgPulse');

	// format time field on change
	duration.change(function () {
		TimeParser.parse(duration.val());
		duration.val(
			TimeParser.format(null,true)
		);
	});

	// handle name field
	var name = jQuery('#TrainingstatisticName');
	name
		.autocomplete({
			source : <?php echo $courseNamesAutocomplete; ?>,
			delay : 100
		})
		.focus(function () {
			jQuery('#CourseName label').fadeOut('fast');
		})
		.blur(function () {
			var val = jQuery.trim(name.val());
			if (val == '') {
				// clean whitespaces first
				name.val(val);
				jQuery('#CourseName label').fadeIn('normal');
			}
		})
		.tipTip();
	if (name.val() == '') {
		jQuery('#CourseName label').show();
	}

	// handle comment field
	/**
	jQuery('#TrainingstatisticComment')
		.focus(function () {
			jQuery('#comment label').fadeOut('fast');
		})
		.blur(function () {
			var val = jQuery.trim(jQuery('#TrainingstatisticComment').val());
			if (val === '') {
				// clean whitespaces first
				jQuery('#TrainingstatisticComment').val(val);
				jQuery('#comment label').fadeIn('normal');
			}
	});
	if (jQuery('#TrainingstatisticComment').val() == '') {
		jQuery('#comment label').show();
	}
	**/

	// update training stats
	// average speed
	jQuery('#TrainingstatisticDuration, #TrainingstatisticDistance')
		.change(function () {
			TimeParser.parse(
				duration.val()
			);

			jQuery('#avgspeed').text(
				WorkoutStats.calcSpeed(
					distance.val(),
					TimeParser.mins / 60
				)
			);
	});
	
	// trimps and kcals
	jQuery('#TrainingstatisticDuration, #TrainingstatisticAvgPulse')
		.change(function () {
		TimeParser.parse(duration.val());

		var sport = jQuery('div.radio input:checked').val();
		var zones;

		// trimps
		// choose zones array first
		if (sport == 'BIKE') {
			zones = [<?php echo implode(',', $bikezones); ?>];
		} else {
			zones = [<?php echo implode(',', $runzones); ?>];
		}

		// calculate & update trimps
		jQuery('#trimp').text(
			WorkoutStats.calcTrimp(
				heartrate.val(),
				TimeParser.mins,
				zones
			)
		);
		
		// kcals
		jQuery('#kcal').text(WorkoutStats.calcKcal(
			'<?php echo $user['gender']; ?>', 
			<?php 
// do a little fallback here if the user has entered no weigth
if ($user['weight']) {
	echo $user['weight'];
} else {
	// age 30-40
	// roughly taken http://gesundheit-zahlen-daten-fakten.blogspot.com/2010/11/korpergewicht-und-lebensalter-kennen.html
	// as a point of orientation and scaled values down for athletes
	if ($user['gender'] === 'm') {
		echo 80;
	} else {
		echo 63;
	}
}
			?>, 
			<?php echo (date("Y") - substr($user['birthday'],0,4)); ?>,
			TimeParser.mins * 60,
			parseInt(heartrate.val())
		));
	});

	// workout link
	var link = jQuery('#TrainingstatisticWorkoutLink');
	link.focus(function () {
			jQuery('#workoutlink label').fadeOut('fast');
		})
		.blur(function () {
			var val = jQuery.trim(link.val());
			if (val == '') {
				// clean whitespaces first
				link.val(val);
				jQuery('#workoutlink label').fadeIn('normal');
			}
		})
		.tipTip();
	if (link.val() == '') {
		jQuery('#workoutlink label').show();
	}
	

	// open link in new window
	jQuery('#workoutlink button').click(function () {
		window.open(link.val());
		return false;
	});

	// trigger change to initialize calculation of values
	jQuery('#TrainingstatisticDuration').change();
	
	// add tooltips
	jQuery('.help, #TrainingstatisticDuration, #TrainingstatisticAvgPulse, #TrainingstatisticDistance').tipTip({ defaultPosition: 'top' });
});
</script>

<?php

      $this->js_addon = <<<EOE

EOE;

?>