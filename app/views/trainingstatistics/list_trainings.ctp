<?php
__('RUN workout', true);
__('BIKE workout', true);
__('SWIM workout', true);
?>
                   <h1><?php __('Track workouts'); ?></h1>

                   <?php echo $this->element('js_error'); ?>

                   <fieldset> 
                   <legend><?php __('What you have already trained!'); ?></legend>

                   <?php if ($session->read('flash')) { ?>
                   <div class="<?php echo $statusbox; ?>">
                   <?php echo $session->read('flash'); $session->delete('flash'); ?>
                   </div><br />
                   <?php } ?>

                   <a href="/trainer/trainingstatistics/edit_training"><button onClick="javascript:top.location.href='/trainer/trainingstatistics/edit_training'" value="<?php __('Add workout'); ?>"><?php __('Add workout'); ?></button></a>
                   
                   <a href="/trainer/trainingstatistics/import_workout"><button onClick="javascript:top.location.href='/trainer/trainingstatistics/import_workout'" value="<?php __('Import workouts'); ?>"><?php __('Import workouts'); ?></button></a>

<?php
if ( $_SERVER['HTTP_HOST'] == 'localhost' )
{
?>
                   <a href="/trainer/garmin/" target="_new"><button onClick="javascript:_new.location.href='/trainer/garmin/'" value="<?php __('Import workouts'); ?> (Garmin)"><?php __('Import workouts'); ?> (Garmin)</button></a>
<?php
}
?>

                   <br /><br />

<table>
<tr>
    <th><?php echo $paginator->sort(__('Date',true), 'date'); ?></th>
    <th><?php echo $paginator->sort(__('Sport',true), 'sportstype'); ?></th>
    <th><?php echo $paginator->sort(__('Distance',true), 'distance'); ?></th>
    <th><?php echo $paginator->sort(__('Duration',true), 'duration'); ?></th>
    <th class="listaction"><?php __('Action'); ?></th>
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
    <td><a <?php if ( isset( $training['name'] ) && $training['name'] != '' ) echo 'class="help2" title="' . $training['name'] . '"'; ?>" href="/trainer/trainingstatistics/edit_training/<?php echo $trainingstatistic['Trainingstatistic']['id']; ?>"><?php echo $unitcalc->check_date($training['date']); ?></a><?php echo ', '; $tday = date('D', strtotime($training['date']));  __($tday); ?></td>
    <td><?php $stype = $training['sportstype']; __($stype); ?></td>
    <td><?php $distance = $unitcalc->check_distance($training['distance'], 'show'); echo $distance['amount'] . ' ' . $distance['unit']; ?></td>
    <td><?php $duration = $unitcalc->seconds_to_time($training['duration']); echo $duration; ?></td>
    <td class="listaction">
<?php 

$facebookurl = '/trainer/trainingstatistics/url_redirect/type:facebook/distance:'.
	$distance['amount'] . '/distance_unit:' . $distance['unit'] .
	'/duration:' . $duration . '/sport:' . $stype;

$twitterurl = '/trainer/trainingstatistics/url_redirect/type:twitter/distance:'.
	$distance['amount'] . '/distance_unit:' . $distance['unit'] .
	'/duration:' . $duration . '/sport:' . $stype;
 
?>
    
<nowrap>
<a onClick="return confirm('<?php __('Are you sure?'); ?>');" href="/trainer/trainingstatistics/delete/<?php echo $trainingstatistic['Trainingstatistic']['id']; ?>"><img alt="<?php __('Delete workout'); ?>" width="18" src="/trainer/img/icon_delete.png" /></a>
<a class="help2" title="<?php __('Tell your friends on Facebook about your great workout!'); ?>" target="_blank" href="<?php echo $facebookurl; ?>"><img alt="<?php __('Post to Facebook'); ?>" width="18" src="/trainer/img/icon_facebook.png" /></a>
<a class="help2" title="<?php __('Tell your Twitter follower about your great workout!'); ?>" target="_blank" href="<?php echo $twitterurl; ?>"><img alt="<?php __('Post to Twitter'); ?>" width="18" src="/trainer/img/icon_twitter.png" /></a>

<?php if ( isset( $training['workout_link'] ) && trim($training['workout_link']) != '' && $training['workout_link'] != 'http://' ) { ?>
<a href="<?php echo $training['workout_link']; ?>" target="_blank"><img alt="<?php __('Link to workout'); ?>" width="18" src="/trainer/img/icon_external.gif" /></a>
<?php } ?>

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
        //\$('a[rel*=facebox]').facebox();

        \$('.help2').tipTip();
        
});

</script>
EOE;

?>
