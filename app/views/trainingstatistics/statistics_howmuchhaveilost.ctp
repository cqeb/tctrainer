
                   <?php echo $form->create('Trainingstatistic', array('action' => 'statistics_howmuchhaveilost')); ?>
                   <fieldset>
                   <legend><?php __('How much have I lost?'); ?></legend>

                   <?php if ($session->check('Message.flash')) { ?>
                   <div class="<?php echo $statusbox; ?>">
                   <?php $session->flash(); ?>
                   </div><br />
                   <?php } ?>

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

<h2><?php __('Chart Weight'); ?></h2>

<?php

if ( count( $trainings ) > 0 ) 
{
    
$jsonurl = Configure::read('App.hostUrl') . Configure::read('App.serverUrl') . '/trainingstatistics/statistics_howmuchhaveilost_json/';
echo $ofc->createflash('my_chart4','680','400',$jsonurl.'type:weight/start:' . $start . '/end:' . $end );

} else
{
  __('No Chart data.');
}

?>

<div id="my_chart4"></div>


<?php

      $this->js_addon = <<<EOE
EOE;

?>