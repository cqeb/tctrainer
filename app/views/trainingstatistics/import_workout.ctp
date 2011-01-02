
                   <h1><?php __('Import workouts'); ?></h1>

                   <?php echo $this->element('js_error'); ?>

                   <?php echo $form->create('Trainingstatistic', array('action' => 'import_workout', 'type' => 'file')); ?>
                   <fieldset>
                   <legend><?php
if ( isset( $newimportfile ) )
    __('Check import data und confirm import!');
else
    __('Upload and import your workouts easily!'); 
?></legend>

                   <?php if ($session->check('Message.flash')) { ?>
                   <div class="<?php echo $statusbox; ?>">
                   <?php $session->flash(); ?>
                   </div><br />
                   <?php } ?>
                   
<?php

if ( !isset( $newimportfile ) ) 
{
  
    __('Upload a CSV-file - you can save an Excel-file in this format.');
    
    echo "<br />";
    
    echo $form->file('import_csv_upload');
    
    echo "<br /><br />";
    
    echo $form->submit(__('Import',true));

} else
{
  
    echo $form->submit(__('Confirm import', true), array( 'class' => '' ) ); 
    echo $html->link(__('Cancel',true), array('controller' => 'trainingstatistics', 'action' => 'list_trainings'),null);
    
    if ( isset( $form->hidden('hiddenimportfile') ) ) echo $form->hidden('hiddenimportfile');

}

?>
                 <br />

<?php

if ( isset( $outputfile ) ) {
  
?>
<table border="0">
<tr>
<th><?php __('Date'); ?></th>
<!--<th><?php __('Time'); ?></th>-->
<th><?php __('Name'); ?></th>
<th><?php __('Sport'); ?></th>
<th><?php __('Distance'); ?></th>
<th><?php __('Duration'); ?></th>
<!--
<th>Workout</th>
<th>Competition</th>
<th>Comment</th>
<th>Location</th>
<th>Weight</th>
<th>URL</th>
-->
<th><?php __('Status'); ?></th>
</tr>
<?php echo $outputfile; ?>
</table>
<?php

    echo $form->submit(__('Confirm import', true)); 

}

?>

                 </fieldset>

<?php
      
      echo $form->end();

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