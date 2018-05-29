<style type="text/css">
    .traffic-light { float:left; margin-right: 30px; background-color: #333; }
    .traffic-light .color { width: 60px; height: 60px; margin: 12px; -moz-border-radius: 30px; -webkit-border-radius: 30px; background-color: grey; cursor: pointer; }
    .traffic-light .color.red.on { background-color: red; }
    .traffic-light .color.yellow.on { background-color: yellow; }
    .traffic-light .color.green.on { background-color: green; }
    #traffic-light-1 { left: 50px; }
    #traffic-light-2 { left: 200px; }
    #traffic-light-3 { left: 350px; }
    #traffic-light-speed { width: 31px; }
</style>

      <div class="panel panel-default" id="forms">
        <div class="panel-heading"><h1><?php __('Statistics'); ?></h1></div>
        
        <div class="panel-body">

           <?php echo $form->create('Trainingstatistic', array('action' => 'statistics_competition','class' => 'form-horizontal')); ?>
           <fieldset>
           <legend><?php __('What have I done?'); ?></legend>

           <?php if ($session->read('flash')) { ?>
           <div class="<?php echo $statusbox; ?>">
           <?php echo $session->read('flash'); $session->delete('flash'); ?>
           </div><br />
           <?php } ?>

           <?php __('This statistic shows you whether you can finish your next competition. The signal light leads you the way.'); ?> 
           <a target="statistics" href="/blog/<?php if ( $language == 'eng' || $language == '' ) { ?>en<?php } else { ?>de<?php } ?>/do-i-have-trained-enough-for-my-competition/"><?php __('Explanation on these statistics in our blog?'); ?></a>
           <br /><br />

<div class="form-group">
<?php

echo $form->input('sportstype',
                  array(
                  'legend' => false,
                  'label' => __('Type of Training', true),
                  'before' => '',
                  'after' => '',
                  'between' => '',
                  'class' => 'form-control',
                  'options' => array(
                                 '' => __('All', true),
                                 'RUN' => __('Run', true),
                                 'BIKE' => __('Bike', true),
                                 //'MTB' => __('Mountain-Bike', true),
                                 'SWIM' => __('Swim', true)
                                 //'STRENGTH' => __('Strength', true),
                                 //'MISC' => __('Misc', true)
                                 )));

echo $form->hidden('id');
echo $form->hidden('user_id');
?>

<br />

<?php

echo $form->submit(__('Display',true), array('name' => 'display','class' => 'btn btn-primary'));

?>
</div>

<br />
<!-- 
thanks to 
http://www.rodpetrovic.com/jquery/behavior/
-->
<?php

if ( !isset( $total_trimp_tp ) || $total_trimp_tp == 0 )
{
?>
    <?php __('No training information available. Start training and then come back!'); ?>
<?php
} else
{  
?>
<table width="100%">
<tr>
    <td>
    <div class="traffic-light">
         <div class="color red <?php if ( $color == 'red' ) echo 'on'; ?>"></div>
         <div class="color yellow <?php if ( $color == 'orange' ) echo 'on'; ?>"></div>
         <div class="color green <?php if ( $color == 'green' ) echo 'on'; ?>"></div>
    </div>
    </td>
    <td style="vertical-align: top;">
    <?php __('In this season you should have reached training impulse (TRIMP): '); ?> <b><?php echo $total_trimp_tp; ?></b><br /><br />
    <?php __('In this season you already reached this training impulse (TRIMP): '); ?> <b><?php echo $total_trimp; ?></b><br /><br />
    <?php __('Percentage: '); echo $trafficlight_percent . ' %'; ?><br /><br />
    <?php 
    echo "<span style=\"color:green;\">";
    __('Green');
    echo "</span> ";
    __('means'); 
    echo ", "; 
    __('you reach your goal.'); 
    echo '<br />';
    echo "<span style=\"color:orange;\">";
    __('Orange');
    echo "</span> ";
    __('means'); 
    echo ", ";
    __('you are currently under- or overperforming.');
    echo '<br />';
    echo "<span style=\"color:red;\">";
    __('Red');
    echo "</span> ";
    __('means'); 
    echo ", ";
    __("you didn't do enough or too much. You can't finish your competition.");
    ?>
    </td>
</tr>
<tr>
    <td colspan="2">&nbsp;</td>
</tr>
<tr>
    <td></td>
    <td>
<?php
      print_r($return2);
?>
    </td>
</tr>      
</table>

<br /><br />

<?php
}
?>

                 </fieldset>
<?php

      echo $form->end();

?>

        </div>
      </div>

<?php

      $this->js_addon = '';

?>