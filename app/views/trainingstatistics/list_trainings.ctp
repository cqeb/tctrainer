
                   <h1><?php __('Track workouts'); ?></h1>

                   <?php echo $this->element('js_error'); ?>

                   <fieldset> 
                   <legend><?php __('What you have already trained!'); ?></legend>

                   <?php if ($session->check('Message.flash')) { ?>
                   <div class="<?php echo $statusbox; ?>">
                   <?php $session->flash(); ?>
                   </div><br />
                   <?php } ?>

                   <?php echo $html->link(__("Add workout",true), array('action' => 'edit_training'),null) ?>
                   <br /><br />

<table>
<tr>
    <th><?php echo $paginator->sort(__('Date',true), 'date'); ?></th>
    <th><?php echo $paginator->sort(__('Sport',true), 'sportstype'); ?></th>
    <th><?php echo $paginator->sort(__('Distance',true), 'distance'); ?></th>
    <th><?php echo $paginator->sort(__('Duration',true), 'duration'); ?></th>
    <th></th>
</tr>

<?php foreach ($trainingstatistics as $trainingstatistic): ?>
<?php $training = $trainingstatistic['Trainingstatistic']; ?>
<tr>
    <td><?php echo $html->link($unitcalc->check_date($training['date']), array('action' => 'edit_training', 'id' => $trainingstatistic['Trainingstatistic']['id']),null); echo ', ' . date('D', strtotime($training['date']));  ?></td>
    <td><?php echo $training['sportstype']; ?></td>
    <td><?php $distance = $unitcalc->check_distance($training['distance']); echo $distance['amount'] . ' ' . $distance['unit']; ?></td>
    <td><?php $duration = $unitcalc->seconds_to_time($training['duration']); echo $duration; ?></td>
    <td>
    
    <?php echo $html->link(__('[X]',true), array('action' => 'delete', 'id' => $training['id']), null, __('Are you sure?',true) )?>

<?php 
$facebookurl = "http://www.facebook.com/sharer.php?t=" .
urlencode(__('My last training', true) . ' ') . $distance['amount'] . 
urlencode(' ' . $distance['unit'] . ' ' . __('in',true) . ' ') . $duration . 
urlencode(' ' . __('WOW',true)) . '&u=http://tricoretraining.com'; 
?>
<a target="_blank" href="<?php echo $facebookurl; ?>">[F]</a>
    
<?php 
$twitterurl = 
substr( 
urlencode(
__('My last training', true) . ' ' . $distance['amount'] . ' ' . $distance['unit'] . ' ' . 
__('in',true) . ' ' . $duration . ' ' . __('WOW',true) . ' http://tricoretraining.com'
  ), 0, 140 ); 
?>
    <a target="_blank" href="http://www.twitter.com/?status=<?php echo $twitterurl; ?>">[T]</a>
    </td>
</tr>
<?php endforeach; ?>
</table>

<?php echo $paginator->numbers(); ?>

                 </fieldset>
<?php

      echo $form->end();

?>


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