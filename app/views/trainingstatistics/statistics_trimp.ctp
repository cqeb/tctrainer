
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
                                 //'MTB' => __('Mountain-Bike', true),
                                 'SWIM' => __('Swim', true)
                                 //'STRENGTH' => __('Strength', true),
                                 //'MISC' => __('Misc', true)
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

?>
                   </div>
                   </fieldset>
<?php

      echo $form->end();

?>

<br /><br />

<h2><?php __('Grade of fatigue (Acute Training Load)'); ?></h2>

<?php

$jsonurl = Configure::read('App.hostUrl') . Configure::read('App.serverUrl') . '/trainingstatistics/statistics_trimp_json/';

echo $ofc->createflash('my_chart1','680','400',$jsonurl . 'stype:' . $sportstype . '/start:' . $start . '/end:' . $end . '/gtype:acute');

?>

<div id="my_chart1"></div>

<br /><br />

<h2><?php __('Grade of fitness (Chronic Training Load)  '); ?></h2>

<?php

$jsonurl = Configure::read('App.hostUrl') . Configure::read('App.serverUrl') . '/trainingstatistics/statistics_trimp_json/';

echo $ofc->createflash('my_chart2','680','400',$jsonurl . 'stype:' . $sportstype . '/start:' . $start . '/end:' . $end . '/gtype:chronic');

?>

<div id="my_chart2"></div>


<?php

      $this->js_addon = <<<EOE
EOE;

?>