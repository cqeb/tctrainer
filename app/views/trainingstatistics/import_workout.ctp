      <div class="panel panel-default" id="forms">
        <div class="panel-heading"><h1><?php __('Import workouts'); ?></h1></div>
        
        <div class="panel-body">

         <?php echo $this->element('js_error'); ?>

         <?php echo $form->create('Trainingstatistic', array('action' => 'import_workout', 'type' => 'file', 'class' => 'form-horizontal')); ?>
         <fieldset>
         <legend><?php
                   
if ( isset( $newimportfile ) )
    __('Check import data und confirm import!');
else
    __('Upload and import your workouts easily!');
	 
?></legend>

         <?php $statusbox = 'alert'; if ($session->read('flash')) { ?>
         <div class="<?php echo $statusbox; ?>">
         <?php echo $session->read('flash'); $session->delete('flash'); ?>
         </div><br />
         <?php } ?>
                   
<?php

if ( !isset( $newimportfile ) ) 
{
  
    __('Upload a file with a .csv extension please'); echo ".<br />";
    __('You can save this format by using your Microsoft Excel application'); echo ".<br />";
    __('We do not support .xls(x), we only support .csv extentions.');

    echo '<br /><br />';
    echo '<a href="/trainer/example/example_workouts_import.csv" target="_blank">&raquo; ';
    __('Download example file'); echo ' - CSV'; echo '<br />';
    echo '</a>';
    echo '<a href="/trainer/example/example_workouts_import.xls" target="_blank">&raquo; ';
    __('Download example file'); echo ' - XLS (Excel)'; echo '<br />';
    echo '</a>';
        
    echo '<br /><br /><br />';
    echo $form->file('import_csv_upload');
    echo "<br /><br />";
    
    echo $form->submit(__('Import workouts',true),array('class' => 'btn btn-primary'));

} else
{
    echo '<div class="alert">'; 
    echo $form->submit(__('Confirm import', true), array('div' => false,'class' => 'btn btn-primary') );
	  echo '&nbsp;&nbsp;'; 
    echo $html->link(__('Cancel',true), array('controller' => 'trainingstatistics', 'action' => 'list_trainings'),null);
    echo '</div>';
    echo $form->hidden('hiddenimportfile');

}

?>
                 <br />

<?php

if ( isset( $outputfile ) ) {
  
?>

<table class="table table-striped table-bordered table-condensed" border="0">
<tr>
<th><?php __('Date'); ?></th>
<th><?php __('Name'); ?></th>
<th><?php __('Sport'); ?></th>
<th><?php __('Distance'); ?></th>
<th><?php __('Duration'); ?></th>
<th><?php __('Status'); ?></th>
</tr>
<?php echo $outputfile; ?>
</table>
<?php
    echo '<div class="alert">';
    echo $form->submit(__('Confirm import', true),array('class' => 'btn btn-primary'));
	/*
	echo '&nbsp;&nbsp;'; 
    echo $html->link(__('Cancel',true), array('controller' => 'trainingstatistics', 'action' => 'list_trainings'),null);
    */
    echo '</div>'; 

}

?>

                 </fieldset>

<?php
      
      echo $form->end();
?>
        </div>
      </div>

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