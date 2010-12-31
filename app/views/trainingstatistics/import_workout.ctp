
                   <h1><?php __('Import workouts'); ?></h1>

                   <?php echo $this->element('js_error'); ?>

                   <?php echo $form->create('User', array('action' => 'import_workout', 'type' => 'file')); ?>
                   <fieldset>
                   <legend><?php __('Upload and import your workouts easily!'); ?></legend>

                   <?php if ($session->check('Message.flash')) { ?>
                   <div class="<?php echo $statusbox; ?>">
                   <?php $session->flash(); ?>
                   </div><br />
                   <?php } ?>
                   
<?php

__('Upload a CSV-file - you can save an Excel-file in this format.');

echo "<br />";

echo $form->file('import_csv_upload');

echo "<br /><br />";

?>

<br /><br />

<?php

echo $form->submit(__('Import',true));

?>
                 <br />

                 </fieldset>

<?php
      echo $form->end();
?>

<?php

      $this->js_addon = <<<EOE
<script type="text/javascript">

/** initiate JQuery **/

\$(document).ready(function() {

        // facebox box
        \$('a[rel*=facebox]').facebox();

});

</script>

EOE;

// not the most beautiful method to replace serverurls - but efficient :)
//$serverurl = Configure::read('App.serverUrl');
//$this->js_addon = str_replace( '###serverurl###', $serverurl, $this->js_addon );

?>