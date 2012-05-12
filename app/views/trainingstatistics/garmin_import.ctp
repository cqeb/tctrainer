
                   <h1><?php __('Import workouts'); ?></h1>

                   <?php echo $this->element('js_error'); ?>

                   <?php echo $form->create('Trainingstatistic', array('action' => 'import_workout', 'type' => 'file')); ?>
                   <fieldset>
                   <legend><?php
	 
?></legend>

                   <?php if ($session->read('flash')) { ?>
                   <div class="<?php echo $statusbox; ?>"></div><br />
                   <?php } ?>
                   
                   <br />
                       <?php echo $logcontent; ?>

                   </fieldset>
<?php echo $form->end(); ?>

<?php                       
      $this->js_addon = <<<EOE
<script type="text/javascript">

/** initiate JQuery **/

\$(document).ready(function() {

        // facebox box
        //\$('a[rel*=facebox]').facebox();

});

</script>

EOE;

// not the most beautiful method to replace serverurls - but efficient :)
//$serverurl = Configure::read('App.serverUrl');
//$this->js_addon = str_replace( '###serverurl###', $serverurl, $this->js_addon );

?>