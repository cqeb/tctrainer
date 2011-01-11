
                   <h1><?php __('Statistics'); ?></h1>

                   <?php echo $form->create('Trainingstatistic', array('action' => 'statistics_trimp')); ?>
                   <fieldset>
                   <legend><?php __('How fit am I?'); ?></legend>

                   <?php if ($session->check('Message.flash')) { ?>
                   <div class="<?php echo $statusbox; ?>">
                   <?php $session->flash(); ?>
                   </div>
                   <br />
                   <?php } ?>

                   <?php __('These graphs show you your short term (ATL) and long term training load (CTL). How exhausted you are (training load of the last 7 days) and fit you are (training load of last 45 days).'); ?> 
                   <a target="statistics" href="/blog/<?php if ( $locale == 'eng' || $locale == '' ) { ?>en<?php } else { ?>de<?php } ?>/what-do-i-learn-from-the-statistics/"><?php __('Explanation on these statistics in our blog?'); ?></a>
                   <br /><br />

                   <div>
<?php

echo $form->input('sportstype',
                  array(
                  'legend' => false,
                  'label' => __('Sport', true),
                  'before' => '',
                  'after' => '',
                  'between' => '',
                  'options' => array(
                                 '' => __('All', true),
                                 'RUN' => __('Run', true),
                                 'BIKE' => __('Bike', true),
                                 'SWIM' => __('Swim', true)
                                 )));

echo $form->input('fromdate',
                  array(
                  'type' => 'date',
                  'before' => '',
                  'after' => '',
                  'between' => '',
                  'label' => __('From', true),
                  'minYear' => date('Y',time())-5,
                  'maxYear' => date('Y',time())
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
));

/** not finished **/

echo $form->hidden('id');
echo $form->hidden('user_id');

echo $form->submit(__('Display',true), array('name' => 'display'));

?>
                   </div>
                   </fieldset>
<?php

      echo $form->end();

?>

<h2><?php __('Grade of fatigue (Acute Training Load)'); ?></h2>

<?php

$jsonurl = Configure::read('App.hostUrl') . Configure::read('App.serverUrl') . '/trainingstatistics/statistics_trimp_json/';

echo $ofc->createflash('my_chart1','680','400',$jsonurl . 'stype:' . $sportstype . '/start:' . $start . '/end:' . $end . '/gtype:acute');

?>

<div id="my_chart1"></div>

<?php if ( $_SERVER['HTTP_HOST'] == 'localhost' ) { ?>
<br /><br />
Debugging: (only localhost)<br />
<a href="<?php echo $jsonurl . 'stype:' . $sportstype . '/start:' . $start . '/end:' . $end . '/gtype:acute'; ?>" target="_blank"><?php echo $jsonurl; ?></a>
<?php } ?>

<br /><br />

<h2><?php __('Grade of fitness (Chronic Training Load)'); ?></h2>

<?php

$jsonurl = Configure::read('App.hostUrl') . Configure::read('App.serverUrl') . '/trainingstatistics/statistics_trimp_json/';

echo $ofc->createflash('my_chart2','680','400',$jsonurl . 'stype:' . $sportstype . '/start:' . $start . '/end:' . $end . '/gtype:chronic');

?>

<div id="my_chart2"></div>

<?php if ( $_SERVER['HTTP_HOST'] == 'localhost' ) { ?>
<br /><br />
Debugging: (only localhost)<br />
<a href="<?php echo $jsonurl . 'stype:' . $sportstype . '/start:' . $start . '/end:' . $end . '/gtype:acute'; ?>" target="_blank"><?php echo $jsonurl; ?></a>
<?php } ?>

<?php

      $this->js_addon = '';

?>