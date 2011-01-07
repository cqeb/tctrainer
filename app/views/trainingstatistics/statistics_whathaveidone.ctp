<?php

if ( $export == true )
{

		$yesno[1] = __('Yes', true);
		$yesno[0] = __('No', true);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>TriCoreTraining.com Trainingstatistics</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />        

    <style type="text/css">
    	.tableTd {
    	   	border-width: 0.5pt;
    		border: solid;
    	}
    	.tableTdContent{
    		border-width: 0.5pt;
    		border: solid;
    	}
    	#titles{
    		font-weight: bolder;
    	}
    </style>
</head>
<body>
<table>
<!--
<tr>
		<td colspan="12"><b><?php __('Export of statistics'); ?><b></td>
</tr>
<tr>
		<td><b><?php __('Date'); ?>:</b></td>
		<td colspan="11"><?php echo date("F j, Y, g:i a"); ?></td>
</tr>
<tr>
		<td colspan="12"></td>
</tr>
-->
<tr id="titles">
		<td class="tableTd"><?php __('Date'); ?></td>
    	<td class="tableTd"><?php __('Sport'); ?></td>
    	<td class="tableTd"><?php __('Distance'); ?></td>
		<td class="tableTd"><?php __('Duration'); ?></td>
		<td class="tableTd"><?php __('AVG heart rate'); ?></td>
<?php if ( $userobject['advanced_features'] ) { ?>
		<td class="tableTd"><?php __('Competition'); ?></td>
<?php } ?>
		<td class="tableTd"><?php __('Testworkout'); ?></td>
		<td class="tableTd"><?php __('Name of (Test-)Workout'); ?></td>
    	<td class="tableTd"><?php __('Comment'); ?></td>
		<td class="tableTd"><?php __('Weight'); ?></td>
<?php if ( $userobject['advanced_features'] ) { ?>
		<td class="tableTd"><?php __('Location'); ?></td>
    	<td class="tableTd"><?php __('Link to workout'); ?></td>
<?php } ?>
		<td class="tableTd"><?php __('TRIMP'); ?></td>
    	<td class="tableTd"><?php __('AVG Speed'); ?></td>
    	<td class="tableTd"><?php __('Burnt'); ?></td>
</tr>
<?php

    for ( $i = 0; $i < count( $trainings ); $i++ )
    {
        $dt = $trainings[$i]['Trainingstatistics'];

  			echo '<tr>';
  			echo '   <td class="tableTdContent">'.$unitcalc->check_date($dt['date'], 'show', 'single').'</td>';
        echo '   <td class="tableTdContent">'.$dt['name'].'</td>';
  			echo '   <td class="tableTdContent">'.$dt['sportstype'].'</td>';
  			echo '   <td class="tableTdContent">'.$unitcalc->seconds_to_time($dt['duration']).'</td>';
        echo '   <td class="tableTdContent">'.$unitcalc->check_distance($dt['distance'], 'show', 'single').'</td>';
  			echo '   <td class="tableTdContent">'.$dt['avg_pulse'].'</td>';
  			echo '   <td class="tableTdContent">'.$yesno[$dt['testworkout']].'</td>';
  			echo '   <td class="tableTdContent">'.$yesno[$dt['competition']].'</td>';
        echo '   <td class="tableTdContent">'.str_replace("\n", "", str_replace("\r", "", $dt['comment'])).'</td>';
  			echo '   <td class="tableTdContent">'.$dt['location'].'</td>';
  			echo '   <td class="tableTdContent">'.$unitcalc->check_weight($dt['weight'], 'show', 'single').'</td>';
        echo '   <td class="tableTdContent">'.$dt['workout_link'].'</td>';
  			echo '   <td class="tableTdContent">'.$dt['trimp'].'</td>';
        echo '   <td class="tableTdContent">'.$dt['avg_speed'].'</td>';
        echo '   <td class="tableTdContent">'.$dt['kcal'].'</td>';
  			echo '</tr>';
    }
?>
</table>
</body>
</html>

<?php
} else
{
?>

                   <h1><?php __('Statistics'); echo " " . $post_sportstype; ?></h1>

                   <?php echo $form->create('Trainingstatistic', array('action' => 'statistics_whathaveidone')); ?>
                   <fieldset>
                   <legend><?php __('What have I achieved?'); ?></legend>

                   <?php if ($session->check('Message.flash')) { ?>
                   <div class="<?php echo $statusbox; ?>">
                   <?php $session->flash(); ?>
                   </div><br />
                   <?php } ?>

                   <a href="/blog/<?php if ( $locale == 'eng' || $locale == '' ) { ?>en<?php } else { ?>de<?php } ?>/tag/statistics/"><?php __('Explanation on these graphs and statistics?'); ?></a>
                   <br /><br />

                   <div>
<?php

echo $form->input('sportstype',
                  array(
                  'legend' => false,
                  'label' => __('Type of Training', true),
                  'before' => '',
                  'after' => '',
                  'between' => '',
                  'options' => array(
                                 '' => __('All', true),
                                 'RUN' => __('Run', true),
                                 'BIKE' => __('Bike', true),
                                 //'MTB' => __('Mountain-Bike', true),
                                 'SWIM' => __('Swim', true)
                                 //'STRENGTH' => __('Strength', true),
                                 //'MISC' => __('Misc', true)
                                 )));

echo $form->input('fromdate',
                    array(
                    'type' => 'date',
                    'before' => '',
                    'after' => '',
                    'between' => '',
                    'label' => __('From', true),
                    'minYear' => date('Y',time())-5,
                    'maxYear' => date('Y',time())
                    //'error' => array('wrap' => 'div', 'style' => 'color:red')
));

echo $form->input('todate',
                    array(
                    'type' => 'date',
                    'before' => '',
                    'after' => '',
                    'between' => '',
                    'label' => __('To', true),
                    'minYear' => date('Y',time())-5,
                    'maxYear' => date('Y',time())
                    //'error' => array('wrap' => 'div', 'style' => 'color:red')
));
                  
/** not finished **/
echo $form->hidden('id');
echo $form->hidden('user_id');

echo $form->submit(__('Display',true), array('name' => 'display', 'div' => false));

echo '&nbsp;&nbsp;';

echo $form->submit(__('Export',true), array('name' => 'excel', 'div' => false));
?>
                   </div>
                   </fieldset>
<?php

      echo $form->end();

?>

<br />

<h2><?php __('Season Statistics'); ?></h2>

<table width="100%">
<tr>
    <th><?php __('Sport'); ?></th>
    <th><?php __('Sum'); ?></th>
    <th><?php __('Duration'); ?></th>
    <th><?php __('TRIMP'); ?></th>
</tr>
<?php

for ( $j = 0; $j < count( $sumdata['collected_sportstypes'] ); $j++ )
{
          $sportstype = $sumdata['collected_sportstypes'][$j];

?>
<tr>
    <td><?php $sport = $sumdata['collected_sportstypes'][$j]; __($sport); ?></td>
    
    <td style="text-align:right;">
    <?php $distance = $unitcalc->check_distance($sumdata['distance'][$sportstype]); echo $distance['amount'] . ' ' . $distance['unit']; ?>
    </td>
    
    <td style="text-align:right;">
    <?php echo $unitcalc->seconds_to_time($sumdata['duration'][$sportstype]); ?> h
    </td>
    
    <td style="text-align:right;">
    <?php echo round($sumdata['trimp'][$sportstype]); ?> <?php __('Points'); ?>
    </td>
</tr>

<?php
}
?>

</table>
<!--</div>-->

<h2><?php __('Distance Statistics'); ?></h2>

<?php

if ( count( $trainings ) > 0 ) 
{
    
  $jsonurl = Configure::read('App.hostUrl') . Configure::read('App.serverUrl') . '/trainingstatistics/statistics_whathaveidone_json/';
  echo $ofc->createflash('my_chart1','680','400',$jsonurl.'type:distance/start:' . $start . '/end:' . $end . '/sportstype:' . $post_sportstype);

} else
{
  __('No Chart data.');
}

?>

<div id="my_chart1"></div>

<?php if ( $userobject['advanced_features'] ) { ?>
<a href="<?php echo $jsonurl.'type:distance/start:' . $start . '/end:' . $end . '/sportstype:' . $post_sportstype; ?>" target="_blank"><?php echo $jsonurl; ?></a>
<?php } ?>

<br /><br />

<h2><?php __('Duration Statistics'); ?></h2>

<?php

if ( count( $trainings ) > 0 ) 
{
    
$jsonurl = Configure::read('App.hostUrl') . Configure::read('App.serverUrl') . '/trainingstatistics/statistics_whathaveidone_json/';
echo $ofc->createflash('my_chart2','680','400',$jsonurl.'type:duration/start:' . $start . '/end:' . $end . '/sportstype:' . $post_sportstype);

} else
{
  __('No Chart data.');
}

?>

<div id="my_chart2"></div>

<?php if ( $userobject['advanced_features'] ) { ?>
<a href="<?php echo $jsonurl.'type:duration/start:' . $start . '/end:' . $end . '/sportstype:' . $post_sportstype; ?>" target="_blank"><?php echo $jsonurl; ?></a>
<?php } ?>

<?php
/**
<br /><br />

<h2><?php __('TRIMP Statistics'); ?></h2>

<?php

$jsonurl = Configure::read('App.serverUrl') . '/trainingstatistics/statistics_whathaveidone_json/';

echo $ofc->createflash('my_chart3','680','400',$jsonurl.'type:trimp/start:' . $start . '/end:' . $end);

?>

<div id="my_chart3"></div>
?>
<br /><br />

<h2><?php __('Chart Weight'); ?></h2>

<?php

if ( count( $trainings ) > 0 ) 
{
    
$jsonurl = Configure::read('App.hostUrl') . Configure::read('App.serverUrl') . '/trainingstatistics/statistics_whathaveidone_json/';
echo $ofc->createflash('my_chart4','680','400',$jsonurl.'type:weight/start:' . $start . '/end:' . $end . '/sportstype:' . $post_sportstype);

} else
{
  __('No Chart data.');
}

?>

<div id="my_chart4"></div>

<?php
**/

      $this->js_addon = <<<EOE
EOE;

}

?>