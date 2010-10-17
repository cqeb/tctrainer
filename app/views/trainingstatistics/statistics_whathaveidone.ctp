<?php

if ( $export == true )
{

?>

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

<table>
<tr>
		<td colspan="12"><b><?php __('Export of statistics'); ?><b></td>
</tr>
<tr>
		<td><b><?php __('Date:'); ?></b></td>
		<td colspan="11"><?php echo date("F j, Y, g:i a"); ?></td>
</tr>
<tr>
		<td colspan="12"></td>
</tr>
<tr id="titles">
		<td class="tableTd"><?php __('Date'); ?></td>
		<td class="tableTd"><?php __('Sport'); ?></td>
		<td class="tableTd"><?php __('Name of Training'); ?></td>
		<td class="tableTd"><?php __('Distance'); ?></td>
		<td class="tableTd"><?php __('Duration'); ?></td>
		<td class="tableTd"><?php __('AVG Speed'); ?></td>
		<td class="tableTd"><?php __('AVG Heart Rate'); ?></td>
<!--
		<td class="tableTd"><?php __('Zone 1 Pulse'); ?></td>
		<td class="tableTd"><?php __('Zone 2 Pulse'); ?></td>
		<td class="tableTd"><?php __('Zone 3 Pulse'); ?></td>
		<td class="tableTd"><?php __('Zone 4 Pulse'); ?></td>
		<td class="tableTd"><?php __('Zone 5 Pulse'); ?></td>
-->
		<td class="tableTd"><?php __('Testworkout'); ?></td>
		<td class="tableTd"><?php __('Competition'); ?></td>
		<td class="tableTd"><?php __('Location'); ?></td>
		<td class="tableTd"><?php __('Weight'); ?></td>
		<td class="tableTd"><?php __('Trimp'); ?></td>
		<!--td class="tableTd"><?php __('Comment'); ?></td-->
</tr>
<?php

    for ( $i = 0; $i < count( $trainings ); $i++ )
    {
        $dt = $trainings[$i]['Trainingstatistics'];

			echo '<tr>';
			echo '   <td class="tableTdContent">'.$dt['date'].'</td>';
			echo '   <td class="tableTdContent">'.$dt['sportstype'].'</td>';
			echo '   <td class="tableTdContent">'.$dt['name'].'</td>';
			echo '   <td class="tableTdContent">'.$dt['distance'].'</td>';
			echo '   <td class="tableTdContent">'.$unitcalc->seconds_to_time($dt['duration']).'</td>';
			echo '   <td class="tableTdContent">'.$dt['avg_speed'].'</td>';
			echo '   <td class="tableTdContent">'.$dt['avg_pulse'].'</td>';
/**
			echo '   <td class="tableTdContent">'.$dt['avg_pulse_zone1'].'</td>';
			echo '   <td class="tableTdContent">'.$dt['avg_pulse_zone2'].'</td>';
			echo '   <td class="tableTdContent">'.$dt['avg_pulse_zone3'].'</td>';
			echo '   <td class="tableTdContent">'.$dt['avg_pulse_zone4'].'</td>';
			echo '   <td class="tableTdContent">'.$dt['avg_pulse_zone5'].'</td>';
**/
			echo '   <td class="tableTdContent">'.$dt['testworkout'].'</td>';
			echo '   <td class="tableTdContent">'.$dt['competition'].'</td>';
			echo '   <td class="tableTdContent">'.$dt['location'].'</td>';
			echo '   <td class="tableTdContent">'.$dt['weight'].'</td>';
			echo '   <td class="tableTdContent">'.$dt['trimp'].'</td>';
			//echo '    <td class="tableTdContent">'.$dt['comment'].'</td>';
			echo '</tr>';
    }
?>
</table>

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
                    'maxYear' => date('Y',time())+1
                    //'error' => array('wrap' => 'div', 'style' => 'color:red')
));
                  
/** not finished **/
echo $form->hidden('id');
echo $form->hidden('user_id');

echo $form->submit(__('Display',true), array('name' => 'display', 'class' => 'none'));

echo '<br />';

echo $form->submit(__('Export',true), array('name' => 'excel', 'class' => 'none'));
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
    <th><?php __('Trimp'); ?></th>
</tr>
<?php

for ( $j = 0; $j < count( $sumdata['collected_sportstypes'] ); $j++ )
{
          $sportstype = $sumdata['collected_sportstypes'][$j];

?>
<tr>
    <td><?php echo $sumdata['collected_sportstypes'][$j]; ?></td>
    
    <td>
    <?php $distance = $unitcalc->check_distance($sumdata['distance'][$sportstype]); echo $distance['amount'] . ' ' . $distance['unit']; ?>
    </td>
    
    <td>
    <?php echo $unitcalc->seconds_to_time($sumdata['duration'][$sportstype]); ?> h
    </td>
    
    <td>
    <?php echo round($sumdata['trimp'][$sportstype]); ?> <?php __('Points'); ?>
    </td>
</tr>

<?php
}
?>

</table>
</div>

<h2><?php __('Chart Distance'); ?></h2>

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

<br /><br />

<h2><?php __('Chart Duration'); ?></h2>

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

<?php
/**
<br /><br />

<h2><?php __('Chart trimp'); ?></h2>

<?php

$jsonurl = Configure::read('App.serverUrl') . '/trainingstatistics/statistics_whathaveidone_json/';

echo $ofc->createflash('my_chart3','680','400',$jsonurl.'type:trimp/start:' . $start . '/end:' . $end);

?>

<div id="my_chart3"></div>
**/

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

      $this->js_addon = <<<EOE
EOE;

}
?>