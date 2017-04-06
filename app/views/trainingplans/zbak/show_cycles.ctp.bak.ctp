      <div class="panel panel-default" id="forms">
        <div class="panel-heading"><h1><?php __('Trainingcycles'); ?></h1></div>
        
        <div class="panel-body">

                   <fieldset>
                   <legend>DEMO <?php __('This is science!'); ?></legend>

                   <div class="<?php echo $statusbox; ?>">
                   <?php echo $session->read('flash'); $session->delete('flash'); ?>
                   </div>

<?php

$jsonurl = Configure::read('App.serverUrl') . '/trainingsplans/show_cycles_json/';

echo $ofc->createflash('my_chart','680','500', $jsonurl);

?>


<div id="my_chart"></div>


                 </fieldset>
        </div>
      </div>

<?php
$this->js_addon = '';
?>
