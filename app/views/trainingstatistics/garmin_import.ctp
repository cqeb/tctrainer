      <div class="panel panel-default" id="forms">
        <div class="panel-heading"><h1><?php __('Import workouts'); ?></h1></div>
        
        <div class="panel-body">

         <?php echo $this->element('js_error'); ?>

         <?php echo $form->create('Trainingstatistic', array('action' => 'garmin_import_final','class' => 'form-horizontal')); ?>
         <fieldset>
         <legend><?php __('Add your Garmin workouts from connect.garmin.com to your TriCoreTraining logbook'); ?></legend>

         <?php if ($session->read('flash')) { ?>
         <div class="<?php echo $statusbox; ?>"></div><br />
         <?php } ?>

         <table class="table table-striped table-bordered table-condensed" border="1">
          <tr>
            <th><?php __('X'); ?></th>
            <th><?php __('Date'); ?></th>
            <!--<th><?php __('Name'); ?></th>-->
            <th><?php __('Sport'); ?></th>
            <th><?php __('Distance'); ?></th>
            <th><?php __('Duration'); ?></th>
            <th class='colhide'><?php __('AVG Speed'); ?></th>
            <th class='colhide'><?php __('Heartrate'); ?></th>
            <th class='colhide'><?php __('Trimp'); ?></th>
            <th class='colhide'><?php __('Kcal'); ?></th>
            <!--<th><?php __('Location'); ?></th>-->
            <!--th class='colhide'><?php __('Weight'); ?></th-->
            <!--<th><?php __('Comment'); ?></th>-->
            <!--<th><?php __('Competition'); ?></th>-->
            <!--<th><?php __('Workoutlink'); ?></th>-->
            <!--<th><?php __('Imported on'); ?></th>-->
          </tr>
<?php 

$unit = $this->Unitcalc->get_unit_metric();
$i = 0;
foreach ( $activities_view as $key => $workout )
{
    echo "<tr>";
    echo "  <td>";
    echo $this->Form->checkbox('workout'.$i, array(
        'style' => 'margin-left:0px;position:relative;',
        'value' => base64_encode(implode($workout, '###')),
        'hiddenField' => 'N',
    ));
    //echo "<input style='margin-left: 0px' type='checkbox' name='workout2import' value='" .  . "' />";"
    echo "</td>";
    echo "  <td>" . $this->Unitcalc->check_date($workout['date'],'show','') . "</td>";
    //echo "  <td>" . $workout['name'] . "</td>";
    echo "  <td>" . $workout['sport'] . "</td>";
    $dist = $this->Unitcalc->check_distance($workout['distance'],'show');
    echo "  <td align='right'>" . $dist['amount'] . " " . $dist['unit'] . "</td>";
    echo "  <td>" . $this->Unitcalc->seconds_to_time( $workout['duration'] ) . "</td>";
    $dur = $this->Unitcalc->check_distance( $workout['avg_speed'], 'show' );
    echo "  <td class='colhide' align='right'>" . $dur['amount'] . " " . $dur['unit'] . "/h</td>";
    echo "  <td class='colhide'>" . $workout['heartrate'] . "</td>";
    echo "  <td class='colhide'>" . $workout['trimp'] . "</td>";
    echo "  <td class='colhide'>" . $workout['kcal'] . "</td>";
    //echo "  <td>" . $workout['location'] . "</td>";
    //echo "  <td class='colhide'>" . $this->Unitcalc->check_weight($workout['weight'],'show','single') . " " . $unit['weight'] . "</td>";
    //echo "  <td>" . $workout['comment'] . "</td>";
    //echo "  <td>" . $workout['competition'] . "</td>";
    //echo "  <td>" . $workout['workoutlink'] . "</td>";
    //echo "  <td>" . $workout['importeddate'] . "</td>";
    echo "</tr>";
    //print_r($workout);
    
    echo "</tr>";
    $i++;
}
//print_r($activities_view); 

?>
        </table>

       </fieldset>
       
       <?php echo $form->submit(__('Import',true),array('class' => 'btn btn-primary')); ?>

       <?php echo $form->end(); ?>

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

?>