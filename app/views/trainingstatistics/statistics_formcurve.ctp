
                   <h1><?php __('Statistics'); ?></h1>

                   <?php echo $form->create('Trainingstatistic', array('action' => 'statistics_formcurve')); ?>
                   <fieldset>
                   <legend><?php __('How fast am I?'); ?></legend>

                   <?php if ($session->check('Message.flash')) { ?>
                   <div class="<?php echo $statusbox; ?>">
                   <?php $session->flash(); ?>
                   </div>
                   <br />
                   <?php } ?>
                   
                   <a href="/blog/<?php if ( $locale == 'eng' || $locale == '' ) { ?>en<?php } else { ?>de<?php } ?>/?s=faq"><?php __('Explanation on these graphs and statistics?'); ?></a>
                   <br /><br />

                   <div>
<?php

/**
echo $form->input('sportstype',
                  array(
                  'legend' => false,
                  'label' => __('Type of Training', true),
                  'before' => '',
                  'after' => '',
                  'between' => '',
                  'options' => array(
                                 'RUN' => __('Run', true),
                                 'BIKE' => __('Bike', true),
                                 'MTB' => __('Mountain-Bike', true),
                                 'SWIM' => __('Swim', true),
                                 'STRENGTH' => __('Strength', true),
                                 'MISC' => __('Misc', true)
                                 )));

**/

for ( $i = 0; $i < count( $testworkoutsfilter ); $i++ )
{
    $dt = $testworkoutsfilter[$i]['Trainingstatistics'];
    $key = $dt['name'] . '|||' . $dt['distance'];
    $distance = $unitcalc->check_distance( $dt['distance'] );
    $ccount = $testworkoutsfilter[$i][0]['ccount'];
    $searchname[$key] = $dt['sportstype'] . ' - ' . $dt['name'] . ' - ' . $distance['amount'] . ' ' . $length_unit . ' (' . $ccount . ')';
}

if ( count( $testworkoutsfilter ) == 0 ) $searchname['none'] = __('No workouts',true);

echo $form->input('search',
                  array(
                  'legend' => false,
                  'label' => __('Choose workout', true),
                  'before' => '',
                  'after' => '',
                  'between' => '',
                  'options' => $searchname
                  ));

echo $form->input('fromdate',
                  array(
                  'type' => 'date',
                  'before' => '',
                  'after' => '',
                  'between' => '',
                  'label' => __('From', true),
                  'minYear' => date('Y',time())-5,
                  'maxYear' => date('Y',time())
                  //'error' => array('wrap' => 'div', 'style' => 'color:red')
));

echo $form->input('todate',
                  array(
                  'type' => 'date',
                  'before' => '',
                  'after' => '',
                  'between' => '',
                  'label' => __('To', true),
                  'minYear' => date('Y',time())-5,
                  'maxYear' => date('Y',time())+1
                  //'error' => array('wrap' => 'div', 'style' => 'color:red')
));

/** not finished **/
echo $form->hidden('id');
echo $form->hidden('user_id');

echo $form->submit(__('Display',true), array('name' => 'display'));
//echo $form->submit('Detailled export (Excel)', array('name' => 'excel'));

?>
                   </div>
                   </fieldset>
<?php

      echo $form->end();

?>

<br />

<h2><?php __('Formcurve'); ?></h2>

<?php

if ( $searchfilter && count($testworkoutsfilter) > 0 )
{
  $jsonurl = Configure::read('App.hostUrl') . Configure::read('App.serverUrl') . '/trainingstatistics/statistics_formcurve_json/';

  echo $ofc->createflash('my_chart1','680','400',$jsonurl.'searchfilter:' . $searchfilter . '/type:' . $sportstype . '/start:' . $start . '/end:' . $end);

?>

<div id="my_chart1"></div>

<?php if ( $userobject['advanced_features'] ) { ?>
<a href="<?php echo $jsonurl.'searchfilter:' . $searchfilter . '/type:' . $sportstype . '/start:' . $start . '/end:' . $end; ?>" target="_blank"><?php echo $jsonurl; ?></a>
<?php } ?>

<?php

} else
{
  __('Sorry, no graph available - choose a testworkout please.');

}

      $this->js_addon = <<<EOE
EOE;

?>