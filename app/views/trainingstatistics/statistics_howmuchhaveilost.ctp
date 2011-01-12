
                   <h1><?php __('Statistics'); ?></h1>

                   <?php echo $form->create('Trainingstatistic', array('action' => 'statistics_howmuchhaveilost')); ?>
                   <fieldset>
                   <legend><?php __('How much have I lost?'); ?></legend>

                   <?php if ($session->check('Message.flash')) { ?>
                   <div class="<?php echo $statusbox; ?>">
                   <?php $session->flash(); ?>
                   </div><br />
                   <?php } ?>
                   
                   <?php __('This statistics shows you your weight-history and the way to your weight targets.'); ?>
                   <a target="statistics" href="/blog/<?php if ( $locale == 'eng' || $locale == '' ) { ?>en<?php } else { ?>de<?php } ?>/what-do-i-learn-from-the-statistics/"><?php __('Explanation on these statistics in our blog?'); ?></a>
                   <br /><br />

                   <div>
<?php

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
                    'maxYear' => date('Y',time())
                    //'error' => array('wrap' => 'div', 'style' => 'color:red')
));
                  
/** not finished **/
echo $form->hidden('id');
echo $form->hidden('user_id');

echo $form->submit(__('Display',true), array('name' => 'display', 'class' => 'none'));
?>
                   </div>
                   </fieldset>
<?php
      echo $form->end();
?>

<br />

<h2><?php __('Weight Statistics'); ?></h2>

<?php

if ( count( $trainings ) > 1 ) 
{
    
$jsonurl = Configure::read('App.hostUrl') . Configure::read('App.serverUrl') . '/trainingstatistics/statistics_howmuchhaveilost_json/';
echo $ofc->createflash('my_chart4','680','400',$jsonurl.'type:weight/start:' . $start . '/end:' . $end );

} else
{
  $jsonurl = '#';
  __('No Chart data.');
}

?>

<div id="my_chart4"></div>

<?php if ( $_SERVER['HTTP_HOST'] == 'localhost' ) { ?>
<br /><br />
Debugging: (only localhost)<br />

<a target="_blank" href="<?php echo $jsonurl.'type:weight/start:' . $start . '/end:' . $end; ?>"><?php echo $jsonurl; ?></a>
<?php } ?>

<?php

      $this->js_addon = '';

?>