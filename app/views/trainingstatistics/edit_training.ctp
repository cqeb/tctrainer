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
		'after' => '<input id="datepicker" style=""/>',
        'minYear' => date('Y',time())-1,
        'maxYear' => date('Y',time())+1
));

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
)));

echo $form->input('workouttype',
	array(
		'label' => false,
		'type' => 'select',
		'options' => array(
			0 => __('Pick a workout', true),
			__('Swim', true) => array(
				'e1' => 'lala'
			)
		)
));
?>
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
<?php
if ( $userobject['advanced_features'] ) {
echo $form->input('competition', array(
                'label' => __('Competition',true), 
                'type' => 'checkbox')
                );
}
?>
<br />
<a name="AF"></a>
<?php

$min_weight = $unitcalc->check_weight('40', 'single');
$min_weight = $min_weight['amount'] . ' ' . $unit['weight'];
$max_weight = $unitcalc->check_weight('150', 'single');
$max_weight = $max_weight['amount'] . ' ' . $unit['weight'];
//$max_weight = $unitcalc->check_weight('150', 'single') . ' ' . $unit['weight'];

echo $form->input('weight',
     array(
     'before' => '',
     'after' => '',
     'between' => '',
     'maxLength' => 5,
     'error' => array( 
             'numeric' => __('Enter your current weight',true),
             'greater' => __('Must be at least',true) . ' ' . $min_weight,
             'lower' => __('Must be lower than',true) . ' ' . $max_weight,
             'notempty' => __('Enter your current weight',true)
     ),
     'label' => __('Weight', true) . ' (' . $unit['weight'] . ')'
));

__('Comment');
echo '<br />';
echo $form->textarea('comment',
                  array(
                  'rows' => '5',
                  'cols' => '45'
           ));
echo '<br /><br />';

if ( $userobject['advanced_features'] ) {

$location_label = __('Location', true) . '<br />(' . __('City', true) . ', ' . __('Country', true) . ')';

echo $form->input('location',
                  array(
                  'before' => '',
                  'after' => '',
                  'between' => '',
                  'maxLength' => 100,
                  'label' => $location_label
                  ));

?>

<div id="gmap"></div>

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

<table border="0" width="100%">
<tr>
    <th width="50%">
    <?php __('Temperature'); ?>
    </th>
    <th width="50%">
    <?php __('Weather'); ?>
    </th>
</tr>
<tr>
    <td>
<?php

echo $form->radio('conditions_temperature', 
  array(
    'warm' => __('warm',true), 
    'cold' => __('cold',true)
  ),
  array('legend' => false,'default'=>'warm','separator'=>'<br />'));

?>
    </td>
    <td>
<?php

echo $form->radio('conditions_weather', 
  array(
    'sunny' => __('sunny',true), 
    'windy' => __('windy',true), 
    'rain' => __('rain',true)
  ),
  array('legend' => false,'default'=>'sunny','separator'=>'<br />'));

?>
    </td>
</tr>
</table>

<table border="0" width="100%">
<tr>
    <th width="50%">
    <?php __('Route'); ?>
    </th>
    <th width="50%">
    <?php __('Feeling'); ?>
    </th>
</tr>
<tr>
    <td>
<?php

echo $form->radio('conditions_inclination', 
    array(
      'flat' => __('flat',true), 
      'hilly' => __('hilly',true), 
      'mountainous' => __('mountainous',true) 
    ),
    array('legend' => false,'default'=>'flat','separator'=>'<br />'));

?>
    </td>
    <td>
<?php

echo $form->radio('conditions_mood', 
    array(
      'feeling_well' => __('well',true), 
      'feeling_bad' => __('bad',true) 
    ),
    array('legend' => false,'default'=>'feeling_well','separator'=>'<br />'));

?>
    </td>
</tr>
</table>

<?php
}

/** not finished **/
echo $form->hidden('avg_speed');
echo $form->hidden('trimp');
echo $form->hidden('kcal');

echo $form->hidden('id');
echo $form->hidden('user_id');
echo $form->submit(__('Save',true));
?>
<a name="Save"></a>

</fieldset>

<script type="text/javascript">
jQuery(document).ready(function() {
	// prepare form
	jQuery('div.radio').buttonset();

	jQuery('#datepicker').datepicker({
		showOn: "button",
		buttonImage: "/trainer/img/calendar_icon.png",
		buttonImageOnly: true,
		buttonText: '<?php __("Date"); ?>'
	});

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
	
	// trimps
	jQuery('#TrainingstatisticDuration, #TrainingstatisticAvgPulse')
		.change(function () {
		TimeParser.parse(duration.val());
		jQuery('#trimp').text(
			WorkoutStats.calcTrimps(
				heartrate.val(),
				'RUN',
				TimeParser.mins
			)
		);
	});
	
	// add tooltips
	jQuery('.help, #TrainingstatisticDuration, #TrainingstatisticAvgPulse, #TrainingstatisticDistance').tipTip();
});
</script>