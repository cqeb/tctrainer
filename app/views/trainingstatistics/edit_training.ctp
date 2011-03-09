<?php

            $GMAPS_API = 'ABQIAAAAilf2rpNqnwxzswbTSxpTKhR0vcTud5tngwSMB1bBY6nA3aJGXhRefbgF7FG4R1KtdAaVJ3x60UlI4Q';
            $this->addScript('gmaps_google', $javascript->link('http://maps.google.com/maps?file=api&amp;v=2&amp;key='.$GMAPS_API));
            $this->addScript('gmaps_jquery', $javascript->link('jquery.gmap-1.1.0'));

?>

                   <h1><?php __('Track workouts'); ?></h1>

                   <?php echo $form->create('Trainingstatistic', array('action' => 'edit_training')); ?>
                  
                   <fieldset>
                   <legend><?php __('Add or edit your workout!'); ?></legend>

                   <?php if ($session->check('Message.flash')) { ?>
                   <div class="<?php echo $statusbox; ?>">
                   <?php $session->flash(); ?>
                   </div><br />
                   <?php } ?>


<?php

echo $form->input('user_id',array('type'=>'hidden'));

echo $form->input('date',
                  array(
                  'before' => '',
                  'after' => '',
                  'between' => '',
                  'class' => 'required',
                  'label' => __('Date', true),
                  'minYear' => date('Y',time())-1,
                  'maxYear' => date('Y',time())+1
));

__('RUN', true);
__('BIKE', true);
__('SWIM', true);

echo $form->input('sportstype',
                  array(
                  'legend' => false,
                  'label' => __('Sport', true),
                  'before' => '',
                  'after' => '',
                  'between' => '',
                  'class' => 'required',
                  'options' => array(
                                 'RUN' => __('Run', true),
                                 'BIKE' => __('Bike / Mountain-Bike', true),
                                 'SWIM' => __('Swim', true)
                                 //'BIKE' => __('Mountain-Bike', true),
                                 //'STRENGTH' => __('Strength', true),
                                 //'MISC' => __('Misc', true)
                                 )));

echo $form->input('distance',
                  array(
                  'before' => '',
                  'after' => '',
                  'between' => '',
                  'class' => 'required',
                  'maxLength' => 255,
                  'error' => array(
                      'numeric' => __('Enter a distance for your workout',true), 
                      'notempty' => __('Enter a distance for your workout',true)
                  ),
                  'label' => __('Distance (' . $unit['length'] . ')', true)
));

echo $form->input('duration',
                  array(
                  'before' => '',
                  'after' => '',
                  'between' => '',
                  'default' => '00:00:00',
                  'maxLength' => 255,
                  'class' => 'required',
                  'error' => array(
                      'notempty' => __('Enter a duration for your workout', true),
                      'greater' => __('Enter a duration for your workout', true)
                  ),
                  'label' => __('Duration (HH:MM:SS)', true)
));

$help_avg_pulse = '<a class="help" title="' . 
	__("This is a pulse-oriented training! Use your heart rate monitor to track your pulse. If you don't enter an average heart rate, we have to approximate.", true) .
	'" href="#">?</a>';
	
echo $form->input('avg_pulse',
                  array(
                  'before' => '',
                  'after' => $help_avg_pulse,
                  'between' => '',
                  'maxLength' => 255,
                  'class' => 'required',
                  'error' => array(
                      'numeric' => __('Enter an average heart rate for your workout',true),
                      'notempty' => __('Enter an average heart rate for your workout',true),
                      'greater' => __('Must be greater than',true) . ' 80',
                      'lower' => __('Must be lower than',true) . ' 240'
                  ),
                  'label' => __('Avg. heart rate', true)
));

echo '<br />';

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

<!--
<hr />

<h2><?php __('Optional data'); ?></h2>

<a href="#AF" onClick="javascript:show_layer();return false;"><?php __('Show advanced functions'); ?></a>

<div id="layer_hidden">
-->

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

?>


<?php

/*
echo $form->input('avg_pulse_zone1',
                  array(
                  'before' => '',
                  'after' => '',
                  'between' => '',
                  'maxLength' => 5,
                  'error' => array('wrap' => 'div', 'style' => 'color:red'),
                  'label' => __('Zone 1', true)
));

echo $form->input('avg_pulse_zone2',
                  array(
                  'before' => '',
                  'after' => '',
                  'between' => '',
                  'maxLength' => 5,
                  'error' => array('wrap' => 'div', 'style' => 'color:red'),
                  'label' => __('Zone 2', true)
));

echo $form->input('avg_pulse_zone3',
                  array(
                  'before' => '',
                  'after' => '',
                  'between' => '',
                  'maxLength' => 5,
                  'error' => array('wrap' => 'div', 'style' => 'color:red'),
                  'label' => __('Zone 3', true)
));

echo $form->input('avg_pulse_zone4',
                  array(
                  'before' => '',
                  'after' => '',
                  'between' => '',
                  'maxLength' => 5,
                  'error' => array('wrap' => 'div', 'style' => 'color:red'),
                  'label' => __('Zone 4', true)
));

echo $form->input('avg_pulse_zone5',
                  array(
                  'before' => '',
                  'after' => '',
                  'between' => '',
                  'maxLength' => 5,
                  'error' => array('wrap' => 'div', 'style' => 'color:red'),
                  'label' => __('Zone 5', true)
));

*/

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
<?php __('Visualize your workout on'); ?><br /><br />
<ul>
<li><a target="_blank" href="http://www.runmap.net">www.runmap.net</a></li>
<li><a target="_blank" href="http://www.bikemap.net">www.bikemap.net</a></li>
</ul>

<!--
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
-->

<?php

/*
// TODO (B)
echo $form->input('publish_community', array('label' => __('Publish to community',true), 'type' => 'checkbox'));
echo $form->input('publish_facebook', array('label' => __('Publish to facebook',true), 'type' => 'checkbox'));
echo $form->input('publish_twitter', array('label' => __('Publish to twitter',true), 'type' => 'checkbox'));
*/

}

?>
<!--</div>-->

<?php
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
<?php

      echo $form->end();

      $this->js_addon = <<<EOE
<script language="JavaScript">
function show_layer() {
    \$('#layer_hidden').show();
}
\$(document).ready(function() {
      
        // facebox box
        \$('a[rel*=facebox]').facebox();
        
        if ( \$("#TrainingstatisticLocation").val() ) 
        {
            \$("#gmap").css("height","250px");
            \$("#gmap").css("margin","20px");
            
            \$("#gmap").gMap({ markers: [
                            { address: \$("#TrainingstatisticLocation").val(),
                              html: "Your training" }],
                  address: \$("#TrainingstatisticLocation").val(),
                  zoom: 10 });
        }

EOE;
    
if ( !isset ( $data ) || count($data) < 2 )
      $this->js_addon .= "$('#layer_hidden').hide();";
        
      $this->js_addon .= <<<EOE
      
      \$('.help').tipTip();
      
});
</script>
EOE;

?>