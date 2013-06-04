
<?php

if ( $export == true )
{

		$yesno[1] = __('Yes', true);
		$yesno[0] = __('No', true);

?>

<!DOCTYPE html>
<html lang="<?php if ( $locale == 'ger' ) echo 'de'; else echo 'en'; ?>">
<head>
    <title>TriCoreTraining <?php __('Statistics'); ?></title>
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
<tr id="titles">
		<td class="tableTd"><?php __('Date'); ?></td>
    	<td class="tableTd"><?php __('Sport'); ?></td>
    	<td class="tableTd"><?php __('Distance'); ?></td>
		<td class="tableTd"><?php __('Duration'); ?></td>
		<td class="tableTd"><?php __('AVG heart rate'); ?></td>
<?php if ( $userobject['advanced_features'] ) { ?>
		<td class="tableTd"><?php __('Competition'); ?></td>
<?php } ?>
<?php /*		<td class="tableTd"><?php __('Testworkout'); ?></td> */ ?>
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
        $dt = $trainings[$i]['trainingstatistics'];

  			echo '<tr>';
  			echo '   <td class="tableTdContent">'.$unitcalc->check_date($dt['date'], 'show', 'single').'</td>';
  			echo '   <td class="tableTdContent">'.$dt['sportstype'].'</td>';
        	echo '   <td class="tableTdContent">'.$unitcalc->check_distance($dt['distance'], 'show', 'single', 'excel').'</td>';
  			echo '   <td class="tableTdContent">'.$unitcalc->seconds_to_time($dt['duration']).'</td>';
  			echo '   <td class="tableTdContent">'.$dt['avg_pulse'].'</td>';
  		if ( $userobject['advanced_features'] ) {
  			echo '   <td class="tableTdContent">'.$yesno[$dt['competition']].'</td>';
		}
  			//echo '   <td class="tableTdContent">'.$yesno[$dt['testworkout']].'</td>';
        	echo '   <td class="tableTdContent">'.$dt['name'].'</td>';
        	echo '   <td class="tableTdContent">'.str_replace("\n", "", str_replace("\r", "", $dt['comment'])).'</td>';
  			echo '   <td class="tableTdContent">'.$unitcalc->check_weight($dt['weight'], 'show', 'single', 'excel').'</td>';
  		if ( $userobject['advanced_features'] ) {
  			echo '   <td class="tableTdContent">'.$dt['location'].'</td>';
        	echo '   <td class="tableTdContent">'.$dt['workout_link'].'</td>';
		}
  			echo '   <td class="tableTdContent">'.$dt['trimp'].'</td>';
        	echo '   <td class="tableTdContent">'.$unitcalc->check_distance($dt['avg_speed'], 'show', 'single', 'excel').'</td>';
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

                   <?php if ($session->read('flash')) { ?>
                   <div class="<?php echo $statusbox; ?>">
                   <?php echo $session->read('flash'); $session->delete('flash'); ?>
                   </div><br />
                   <?php } ?>

                   <?php __('These statistics show you what and how much you have achieved in a certain period of time.'); ?> 
                   <a target="statistics" href="/blog/<?php if ( $locale == 'eng' || $locale == '' ) { ?>en<?php } else { ?>de<?php } ?>/what-do-i-learn-from-the-statistics/"><?php __('Explanation on these statistics in our blog?'); ?></a>
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
                                 'SWIM' => __('Swim', true)
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

$chart_haxis = __('Time', true);

$chart_color1 = '#06FF02';
$chart_color2 = '#F1AD28';

?>

<br />
<script type="text/javascript">

      google.load('visualization', '1', {packages: ['corechart']});

      function getJSONdata( jsonurl, chart, chart_vaxis ) { 
          jQuery.ajax({
              url: jsonurl,
              type: 'POST',
              success: function (data, textStatus, jqXHR) {
                //alert(data.toString());
                //alert(textStatus.toString());
                //alert(jqXHR.responseText);

                var data = jQuery.parseJSON(jqXHR.responseText);
                var graphdata = [['<?php __('Time');?>', chart_vaxis ]];

                jQuery.each(data.results, function(i, jsonobj) {
                    graphdata.push([jsonobj.tcttime, jsonobj.tctdata1]);
                });
                
                drawVisualization(graphdata, chart, chart_vaxis );
              }, error: function (data, textStatus, jqXHR) { 
                //alert(textStatus); 
                console.log( "JSON Data: ERROR"  );
              }
          });            
      }

      function drawVisualization(jsdata, chart, chart_vaxis) {
          console.log(jsdata);
          //jsdata = jsdata_title.concat(jsdata);
          
          var data = google.visualization.arrayToDataTable( jsdata );
        
          // Create and draw the visualization.
          var ac = new google.visualization.AreaChart(document.getElementById(chart));
       
          var graph_width = 680;
          var graph_height = 500;

          if ( window.innerWidth <= 320 ) { graph_width = 270; graph_height = 300; }

          // read size of div - write in variable and set here
          ac.draw(data, {
            //title : 'A vs. C',
            //isStacked: true,
            colors: ['<?php echo $chart_color1; ?>', '<?php echo $chart_color2; ?>'],
            pointSize: 0,
            width: graph_width,
            height: graph_height,
            legend: { position: 'top' },
            chartArea: {'width': '80%', 'height': '65%'},
            vAxis: { title: chart_vaxis,  
              slantedText:true, slantedTextAngle:45 },
            hAxis: { title: "<?php echo $chart_haxis; ?>"}
          });
      }
      
</script>

<h2><?php __('Season Statistics'); ?></h2>

<table width="100%">
<tr>
    <th><?php __('Sport'); ?></th>
    <th><?php __('Sum'); ?></th>
    <th><?php __('Duration'); ?></th>
    <th><?php __('TRIMP'); ?></th>
</tr>
<?php

sort($sumdata['collected_sportstypes']);

for ( $j = 0; $j < count( $sumdata['collected_sportstypes'] ); $j++ )
{
          $sportstype = $sumdata['collected_sportstypes'][$j];

?>
<tr>
    <td><?php $sport = $sumdata['collected_sportstypes'][$j]; __($sport); ?></td>
    
    <td style="text-align:right;">
    <?php $distance = $unitcalc->check_distance($sumdata['distance'][$sportstype]); echo round( $distance['amount'], 1 ) . ' ' . $distance['unit']; ?>
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
    
  $jsonurl = Configure::read('App.hostUrl') . Configure::read('App.serverUrl') . '/trainingstatistics/statistics_whathaveidone_json/' .
    'type:distance/start:' . $start . '/end:' . $end . '/sportstype:' . $post_sportstype;
?>
<script language="JavaScript">
function get_distance() {
  getJSONdata('<?php echo $jsonurl; ?>','chart1','<?php echo $length_unit; ?>');
}

google.setOnLoadCallback(get_distance);
</script>
<?php

} else
{
  __('No Chart data.');
}

?>

<div id="chart1"></div>

<!--
<?php if ( $_SERVER['HTTP_HOST'] == 'localhost' && isset( $jsonurl ) ) { ?>
<br /><br /><br /><br /><br /><br />
Debugging: (only localhost)<br />
<a href="<?php echo $jsonurl; ?>" target="_blank"><?php echo $jsonurl; ?></a>
<?php } ?>
-->

<br /><br /><br /><br /><br /><br /><br /><br />

<h2><?php __('Duration Statistics'); ?></h2>

<?php

if ( count( $trainings ) > 0 ) 
{
    
	$jsonurl = Configure::read('App.hostUrl') . Configure::read('App.serverUrl') . '/trainingstatistics/statistics_whathaveidone_json/' .
	'type:duration/start:' . $start . '/end:' . $end . '/sportstype:' . $post_sportstype;
?>
<script language="JavaScript">
function get_duration() {
  getJSONdata('<?php echo $jsonurl; ?>','chart2','<?php __('hours'); ?>');
}

google.setOnLoadCallback(get_duration);
</script>
<?php
} else
{
  __('No Chart data.');
}

?>

<div id="chart2"></div>

<!--
<?php if ( $_SERVER['HTTP_HOST'] == 'localhost' && isset( $jsonurl ) ) { ?>
<br /><br /><br /><br /><br /><br />
Debugging: (only localhost)<br />
<a href="<?php echo $jsonurl; ?>" target="_blank"><?php echo $jsonurl; ?></a>
<?php } ?>
-->

<br /><br /><br /><br /><br /><br /><br /><br />


<?php

      $this->js_addon = '';

}

?>