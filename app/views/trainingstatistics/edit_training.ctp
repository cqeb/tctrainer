<h1><?php __('Workout details'); ?></h1>
<script type="text/javascript" src="/trainer/js/workoutstats.js"></script>
<script type="text/javascript" src="/trainer/js/timeparser.js"></script>
<link rel="stylesheet" type="text/css" href="/trainer/css/edittraining.css" />
<?php echo $form->create('Trainingstatistic', array('action' => 'edit_training')); ?>

<fieldset>
<?php if ($session->check('Message.flash')) { ?>
<div class="<?php echo $statusbox; ?>">
<?php $session->flash(); ?>
</div>
<?php 
} 
echo $form->input('date',
	array(
        'class' => 'required',
		'label' => false,
        'minYear' => date('Y',time())-1,
        'maxYear' => date('Y',time())+1
));
?>
<div class="sportworkoutlabels">
<label>Sport</label>
<label>Workout</label>
</div>
<div class="sportworkout">
<?php
echo $form->input('sportstype',
	array(
		'legend' => false,
        'label' => __('Sport', true),
		'type' => 'radio',
        'class' => 'required',
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

echo $form->input('swimworkouttypes',
	array(
		'label' => false,
		'type' => 'select',
		'options' => $workouts['Swim'],
		'div' => 'swimworkouttypes',
		'title' => __('Pick a workout type to specify which kind of workout you completed (optional)', true)
));

echo $form->input('bikeworkouttypes',
	array(
		'label' => false,
		'type' => 'select',
		'options' => $workouts['Bike'],
		'div' => 'bikeworkouttypes',
		'title' => __('Pick a workout type to specify which kind of workout you completed (optional)', true)
));

echo $form->input('runworkouttypes',
	array(
		'label' => false,
		'type' => 'select',
		'options' => $workouts['Run'],
		'div' => 'runworkouttypes',
		'title' => __('Pick a workout type to specify which kind of workout you completed (optional)', true)
));

echo $form->input('workouttype',
	array(
		'div' => 'workouttype',
		'label' => false
));
?>
</div>
<div class="clear"></div>

<div>
<?php
echo $form->input('name',
	array(
		'div' => array(
			'id' => 'CourseName'
		),
		'maxLength' => 255,
        'class' => 'required',
        'error' => array(
        	'notempty' => __('Enter name for your workout route', true)
		),
	'label' => __('Course name', true),
	'title' => __('Enter a name for your course, so you can identify it later (optional)', true)
));


echo $form->input('duration',
	array(
        'label' => '<img src="/trainer/img/icons/duration.gif">' . __('Duration', true),
		'title' => __('Enter the duration of your workout, using hours, minutes and seconds like: 01:15:23', true),
        'div' => 'wrap duration',
		'default' => '00:00:00',
        'maxLength' => 255,
        'class' => 'required',
        'error' => array(
        	'notempty' => __('Enter a duration for your workout', true),
            'greater' => __('Enter a duration for your workout', true)
)));

echo $form->input('avg_pulse',
	array(
        'label' => '<img src="/trainer/img/icons/heartrate.gif">' . 'bpm',
		'title' => __('The average heart rate measured during your workout', true),
		'div' => 'wrap avg_pulse',
		'maxLength' => 255,
		'class' => 'required',
        'error' => array(
        	'numeric' => __('Enter an average heart rate for your workout',true),
            'notempty' => __('Enter an average heart rate for your workout',true),
            'greater' => __('Must be greater than',true) . ' 80',
            'lower' => __('Must be lower than',true) . ' 240'
)));

echo $form->input('distance',
	array(
        'label' => '<img src="/trainer/img/icons/distance.gif">' . $unit['length'],
		'title' => __("The distance you've covered during your workout", true),
        'div' => 'wrap distance',
		'class' => 'required',
        'maxLength' => 255,
        'error' => array(
        	'numeric' => __('Enter a distance for your workout',true), 
            'notempty' => __('Enter a distance for your workout',true)
)));

?>
<div class="clear" />
</div>

<table id="stats">
	<tr>
		<td id="kcal"><?php echo $data['kcal']; ?></td>
		<td id="avgspeed"><?php echo $data['avg_speed']; ?></td>
		<td id="trimp"><?php echo $data['trimp']; ?></td>
	</tr>
	<tr>
		<th class="border-right">kcal</th>
		<th class="border-right"><?php echo $unit['length']; ?>/h</th>
		<th>TRIMPs</th>
	</tr>
</table>
<a name="AF"></a>
<?php

$min_weight = $unitcalc->check_weight('40', 'single');
$min_weight = $min_weight['amount'] . ' ' . $unit['weight'];
$max_weight = $unitcalc->check_weight('150', 'single');
$max_weight = $max_weight['amount'] . ' ' . $unit['weight'];

echo $form->input('weight',
     array(
     'div' => 'wrap weight',
     'maxLength' => 5,
     'error' => array( 
             'numeric' => __('Enter your current weight',true),
             'greater' => __('Must be at least',true) . ' ' . $min_weight,
             'lower' => __('Must be lower than',true) . ' ' . $max_weight,
             'notempty' => __('Enter your current weight',true)
     ),
     'label' => __('Weight', true) . ' (' . $unit['weight'] . ')'
));
?>
<div id="comment">
<label for="TrainingstatisticComment"><?php __('Comment'); ?></label>
<?php
echo $form->textarea('comment');
?>
</div>
<div class="clear"></div>
<?php
echo $form->input('workout_link',
     array(
     'before' => '',
     'after' => '',
     'between' => '',
     'maxLength' => 255,
     'default' => 'http://',
     'label' => __('Link workout', true)
));
?>
<ul>
<li><a target="_blank" href="http://www.runmap.net"><?php __('Visualize your run workouts on runmap.net!'); ?></a></li>
<li><a target="_blank" href="http://www.bikemap.net"><?php __('Visualize your bike workouts on bikemap.net!'); ?></a></li>
</ul>

<?php
echo $form->submit(__('Save',true));
?>
</fieldset>
<script type="text/javascript">
jQuery(document).ready(function() {
	// sportstype
	jQuery('div.radio')
		.buttonset()
		.change(function (e) {
			var sport = jQuery(e.target).val();

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

	// wokrouttypes
	jQuery('.swimworkouttypes select, .bikeworkouttypes select, .runworkouttypes select')
		.change(function () {
			var v = jQuery(this).val();
			// store value
			jQuery('#TrainingstatisticWorkouttype').val(v);
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
		})
		.tipTip({ defaultPosition: 'top' });

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
			<?php echo $user['weight']; ?>, 
			<?php echo (date("Y") - substr($user['birthday'],0,4)); ?>,
			TimeParser.mins * 60,
			parseInt(heartrate.val())
		));
	});
	
	// add tooltips
	jQuery('.help, #TrainingstatisticDuration, #TrainingstatisticAvgPulse, #TrainingstatisticDistance').tipTip({ defaultPosition: 'top' });
});
</script>