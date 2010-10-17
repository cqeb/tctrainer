<?php

            $GMAPS_API = 'ABQIAAAAilf2rpNqnwxzswbTSxpTKhR0vcTud5tngwSMB1bBY6nA3aJGXhRefbgF7FG4R1KtdAaVJ3x60UlI4Q';
            $this->addScript('gmaps_google', $javascript->link('http://maps.google.com/maps?file=api&amp;v=2&amp;key='.$GMAPS_API));
            $this->addScript('gmaps_jquery', $javascript->link('jquery.gmap-1.1.0'));

?>

                   <h1><?php __('Track trainings'); ?></h1>

                   <?php echo $form->create('Trainingstatistic', array('action' => 'edit_training')); ?>
                   <fieldset>
                   <legend><?php __('Add or edit your training!'); ?></legend>

                   <?php if ($session->check('Message.flash')) { ?>
                   <div class="<?php echo $statusbox; ?>">
                   <?php $session->flash(); ?>
                   </div><br />
                   <?php } ?>

                   <?php echo $html->link(__('Back to list of trainings',true), array('controller' => 'trainingstatistics', 'action' => 'list_trainings'),null) ?>

<?php

// TODO
// localize date component
// check for already saved trainings.

echo $form->input('user_id',array('type'=>'hidden'));

echo $form->input('date',
                  array(
                  'before' => '',
                  'after' => '',
                  'between' => '<br />',
                  'class' => 'required',
                  'label' => __('Date', true),
                  'minYear' => date('Y',time())-1,
                  'maxYear' => date('Y',time())+1
));

echo $form->input('name',
                  array(
                  'before' => '',
                  'after' => '',
                  'between' => '',
                  'maxLength' => 255,
                  'class' => 'required',
                  'error' => array(
                      'notempty' => __('Enter a name for the training', true)
                  ),
                  'label' => __('Name', true)
));


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
                                 'BIKE' => __('Bike', true),
                                 'SWIM' => __('Swim', true),
                                 'MTB' => __('Mountain-Bike', true),
                                 'STRENGTH' => __('Strength', true),
                                 'MISC' => __('Misc', true)
                                 )));

echo $form->input('distance',
                  array(
                  'before' => '',
                  'after' => '',
                  'between' => '',
                  'class' => 'required',
                  'maxLength' => 255,
                  'error' => array(
                      'numeric' => __('Enter a distance for your training',true), 
                      'notempty' => __('Enter a distance for your training',true)
                  ),
                  'label' => __('Distance (' . $unit['length'] . ')', true)
));

echo $form->input('duration',
                  array(
                  'before' => '',
                  'after' => '',
                  'between' => '',
                  'maxLength' => 255,
                  'class' => 'required',
                  'error' => array(
                      'notempty' => __('Enter a duration for your training',true)
                  ),
                  'label' => __('Duration (HH:MM:SS)', true)
));

echo $form->input('avg_pulse',
                  array(
                  'before' => '',
                  'after' => '',
                  'between' => '',
                  'maxLength' => 255,
                  'class' => 'required',
                  'error' => array(
                      'numeric' => __('Enter an average heart rate for your training',true),
                      'notempty' => __('Enter an average heart rate for your training',true),
                      'greater' => __('Must be greater than 80',true),
                      'lower' => __('Must be lower than 240',true)
                  ),
                  'label' => __('Avg. heart rate', true)
));

$avg_speed = $unitcalc->check_distance($data['avg_speed']);

if ( $avg_speed['amount'] ) { __('AVG Speed'); echo ' ' . $avg_speed['amount']; echo ' ' . $unit['length'] . '/h' . '<br /><br />'; }

if ( $data['trimp'] ) { __('TRIMP'); echo ' ' . $data['trimp'] . '<br /><br />'; }
 
if ( $data['kcal'] ) { __('Burnt'); echo ' ' . $data['kcal'] . ' ' . 'kcal' . '<br /><br />'; }

echo $form->input('testworkout', array(
                'label' => __('Testworkout',true), 
                'type' => 'checkbox')
                );

echo $form->input('competition', array(
                'label' => __('Competition',true), 
                'type' => 'checkbox')
                );

?>
<a href="#Save">Save only necessary data</a>

<hr />
<h2><?php __('Optional data'); ?></h2>

<?php

/**
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
**/

__('Comment');
echo '<br />';
echo $form->textarea('comment',
                  array(
                  'rows' => '5',
                  'cols' => '45'
           ));
// TODO Aloha Editor

echo $form->input('location',
                  array(
                  'before' => '',
                  'after' => '',
                  'between' => '',
                  'maxLength' => 100,
                  'label' => __('Location (City, Country)', true)
));

?>

<div id="gmap"></div>

<?php

$min_weight = $unitcalc->check_weight('40') . ' ' . $unit['weight'];
$max_weight = $unitcalc->check_weight('150') . ' ' . $unit['weight'];

echo $form->input('weight',
     array(
     'before' => '',
     'after' => '',
     'between' => '',
     'maxLength' => 5,
     'error' => array( 
             'numeric' => __('Enter your current weight.',true),
             'greater' => __('Must be at least',true) . ' ' . $min_weight,
             'lower' => __('Must be lower than',true) . ' ' . $max_weight,
             'notempty' => __('Enter your current weight',true)
     ),
     'label' => __('Weight', true) . ' (' . $unit['weight'] . ')'
));

/**
// TODO (B)
echo $form->input('weightfat',
                  array(
                  'before' => '',
                  'after' => '',
                  'between' => '',
                  'maxLength' => 5,
                  'error' => array('wrap' => 'div', 'style' => 'color:red'),
                  'label' => __('Body fat', true)
));
**/

?>

<table border="0" width="100%">
<tr>
    <th>
    <?php __('Temperature'); ?>
    </th>
    <th>
    <?php __('Weather'); ?>
    </th>
    <th>
    <?php __('Route'); ?>
    </th>
    <th>
    <?php __('Feeling'); ?>
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
  array('legend' => false,'default'=>'warm','separator'=>''));

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
      'feeling_well' => __('feeling well',true), 
      'feeling_bad' => __('feeling bad',true) 
    ),
    array('legend' => false,'default'=>'feeling_well','separator'=>'<br />'));

?>
    </td>
</tr>
</table>

<?php
/**
// TODO (B)
echo $form->input('publish_community', array('label' => __('Publish to community',true), 'type' => 'checkbox'));
echo $form->input('publish_facebook', array('label' => __('Publish to facebook',true), 'type' => 'checkbox'));
echo $form->input('publish_twitter', array('label' => __('Publish to twitter',true), 'type' => 'checkbox'));
**/

?>

<hr>

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
});
</script>
EOE;

?>