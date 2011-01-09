<?php
__('RUN workout', true);
__('BIKE workout', true);
__('SWIM workout', true);
?>
                   <h1><?php __('Track workouts'); ?></h1>

                   <?php echo $this->element('js_error'); ?>

                   <fieldset> 
                   <legend><?php __('What you have already trained!'); ?></legend>

                   <?php if ($session->check('Message.flash')) { ?>
                   <div class="<?php echo $statusbox; ?>">
                   <?php $session->flash(); ?>
                   </div><br />
                   <?php } ?>

                   <a href="/trainer/trainingstatistics/edit_training"><button value="<?php __('Add workout'); ?>"><?php __('Add workout'); ?></button></a>
                   
                   <?php if ( $userobject['advanced_features'] ) { ?>
                   <a href="/trainer/trainingstatistics/import_workout"><button value="<?php __('Import workouts'); ?>"><?php __('Import workouts'); ?></button></a>
                   <?php } ?>

                   <!--
                   <?php echo $html->link(__("Add workout",true), array('action' => 'edit_training'),null) ?>
                   | 
                   <?php echo $html->link(__("Import workout",true), array('action' => 'import_workout'),null) ?>
                   -->
                   <br /><br />

<table>
<tr>
    <th><?php echo $paginator->sort(__('Date',true), 'date'); ?></th>
    <th><?php echo $paginator->sort(__('Sport',true), 'sportstype'); ?></th>
    <th><?php echo $paginator->sort(__('Distance',true), 'distance'); ?></th>
    <th><?php echo $paginator->sort(__('Duration',true), 'duration'); ?></th>
    <th><?php __('Action'); ?></th>
</tr>

<?php 

if ( !isset( $trainingstatistics ) || count( $trainingstatistics ) < 1 )
{
  
    echo '<td colspan="5">' . __('No workouts available.', true) . '</td>';  
}
 
?>

<?php foreach ($trainingstatistics as $trainingstatistic): ?>
<?php $training = $trainingstatistic['Trainingstatistic']; ?>

<tr>
    <td><?php echo $html->link($unitcalc->check_date($training['date']), array('action' => 'edit_training', 'id' => $trainingstatistic['Trainingstatistic']['id']),null); echo ', '; $tday = date('D', strtotime($training['date']));  __($tday); ?></td>
    <td><?php $stype = $training['sportstype']; __($stype); ?></td>
    <td><?php $distance = $unitcalc->check_distance($training['distance']); echo $distance['amount'] . ' ' . $distance['unit']; ?></td>
    <td><?php $duration = $unitcalc->seconds_to_time($training['duration']); echo $duration; ?></td>
    <td style="text-align:right;">
<?php 

$facebookurl = "http://www.facebook.com/sharer.php?u=http://tricoretraining.com"; 
$facebookurl .= '/trainer/starts/index/distance:'.$distance['amount'].'/distance_unit:'. $distance['unit'] .'/duration:' . $duration . '/stype:' . $stype;

$twitterurl = 
urldecode(
substr( 
__('WOW', true) . ' - ' . $distance['amount'] . ' ' . $distance['unit'] . ' ' . __($stype . ' workout', true) . ' ' . 
__('in',true) . ' ' . $duration . ' ' . __('hour(s)',true) . ' ' . '- http://tricoretraining.com - ' . __('great online coach', true) 
, 0, 140 
)
); 

?>
    
<nowrap>
<?php if ( isset( $training['workout_link'] ) && trim($training['workout_link']) != '' && $training['workout_link'] != 'http://' ) { ?>
<a href="<?php echo $training['workout_link']; ?>" target="_blank"><img alt="<?php __('Link to workout'); ?>" width="18" src="/trainer/img/icon_external.gif" /></a>
<?php } ?>

<a target="_blank" href="<?php echo $facebookurl; ?>"><img alt="<?php __('Post to Facebook'); ?>" width="18" src="/trainer/img/icon_facebook.png" /></a>
<a target="_blank" href="http://twitter.com/?status=<?php echo $twitterurl; ?>"><img alt="<?php __('Post to Twitter'); ?>" width="18" src="/trainer/img/icon_twitter.png" /></a>

<a onClick="return confirm('<?php __('Are you sure?'); ?>');" href="/trainer/trainingstatistics/delete/<?php echo $trainingstatistic['Trainingstatistic']['id']; ?>"><img alt="<?php __('Delete workout'); ?>" width="18" src="/trainer/img/icon_delete.png" /></a>
</nowrap>

    </td>
</tr>
<?php endforeach; ?>
</table>

<?php echo $paginator->numbers(); ?>

                 </fieldset>
<?php

      echo $form->end();

?>
<!--
<?php 
__('Mon');
__('Tue');
__('Wed');
__('Thu');
__('Fri');
__('Sat');
__('Sun');
?>
-->

<?php

      $this->js_addon = <<<EOE
<script type="text/javascript">

\$(document).ready(function() {

        // facebox box
        \$('a[rel*=facebox]').facebox();

});

</script>
EOE;

?>
