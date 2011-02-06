<h1><?php __('Track workouts'); ?></h1>
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
        // 'label' => __('Date', true),
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
			0 => 'none',
			__('Swim', true) => array(
				'e1' => 'lala'
			)
		)
));
?>
<div class="outerwrap">
<div class="wrapspecial wrapduration">
<?php
echo $form->input('duration',
	array(
        'label' =>  __('Duration', true),
		'title' => __('Enter the duration of your workout, using hours, minutes and seconds like: 01:15:23', true),
        'default' => '00:00:00',
        'maxLength' => 255,
        'class' => 'required',
        'error' => array(
        	'notempty' => __('Enter a duration for your workout', true),
            'greater' => __('Enter a duration for your workout', true)
)));
?>
</div><div class="wrapspecial">
<?php
echo $form->input('avg_pulse',
	array(
        'label' => 'bpm',
		'title' => __('The average heart rate measured during your workout', true),
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
        'label' => $unit['length'],
		'title' => __("The distance you've covered during your workout", true),
        'class' => 'required',
        'maxLength' => 255,
        'error' => array(
        	'numeric' => __('Enter a distance for your workout',true), 
            'notempty' => __('Enter a distance for your workout',true)
)));
?>
</div></div>
<?php
if ( $userobject['advanced_features'] ) {
echo $form->input('competition', array(
                'label' => __('Competition',true), 
                'type' => 'checkbox')
                );
}
/*
echo $form->input('testworkout', array(
                'label' => __('Testworkout',true), 
                'type' => 'checkbox')
                );
*/

$help_name = '<a class="help" title="' . __('Enter a name for the workout (route) to display it in your form curve.', true) .
	'" href="#">?</a>';
	
echo $form->input('name',
                  array(
                  'before' => '',
                  'after' => $help_name,
                  'between' => '',
                  'maxLength' => 255,
                  'class' => 'required',
                  'error' => array(
                      'notempty' => __('Enter name for your workout route', true)
                  ),
                  'label' => __('Name for workout', true)
));

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

?>
<ul>
<?php

if ( isset( $data['avg_speed'] ) && $data['avg_speed'] > 0 ) $avg_speed = $unitcalc->check_distance($data['avg_speed']);

if ( isset( $avg_speed['amount'] ) && $data['avg_speed'] > 0 ) {
   echo '<br /><br />';
   echo '<li>';
   __('AVG Speed'); 
   echo ' ' . $avg_speed['amount'] . ' ' . $unit['length'] . '/h';
   echo '</li>'; 
}

if ( isset( $data['trimp'] ) && $data['trimp'] > 0 ) {
   echo '<li>';
   __('TRIMP'); 
   echo ' ' . $data['trimp'];
   echo '</li>'; 
}
 
if ( isset( $data['kcal'] ) && $data['kcal'] > 0 ) {
   echo '<li>';
   __('Burnt'); 
   echo ' ' . $data['kcal'] . ' ' . 'kcal';
   echo '</li>';
}

?>
</ul>

<?php
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

	// tooltips
	jQuery('.help, #TrainingstatisticDuration, #TrainingstatisticAvgPulse, #TrainingstatisticDistance').tipTip();
});
</script>