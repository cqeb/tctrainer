<?php

$searchfilter = base64_encode( $searchfilter );

?>
      <div class="panel panel-default" id="forms">
        <div class="panel-heading"><h1><?php __('Statistics'); ?></h1></div>
        
        <div class="panel-body">

                   <?php echo $form->create('Trainingstatistic', array('action' => 'statistics_formcurve','class' => 'form-horizontal')); ?>
                   <fieldset>
                   <legend><?php __('How fast am I?'); ?></legend>

                   <?php if ($session->read('flash')) { ?>
                   <div class="<?php echo $statusbox; ?>">
                   <?php echo $session->read('flash'); $session->delete('flash'); ?>
                   </div>
                   <br />
                   <?php } ?>
                   
                   <?php __('You want to know whether you became faster? This statistic shows you based on your test-workouts your current speed.'); ?> 
                   <a target="statistics" href="/blog/<?php if ( $locale == 'eng' || $locale == '' ) { ?>en<?php } else { ?>de<?php } ?>/how-can-i-test-if-i-became-faster/"><?php __('Explanation on these statistics in our blog?'); ?></a>
                   <br /><br />

<div class="form-group">
<?php

for ( $i = 0; $i < count( $testworkoutsfilter ); $i++ )
{
    $dt = $testworkoutsfilter[$i]['trainingstatistics'];
    $key = $dt['name'] . '|||' . $dt['distance'];
    $distance = $unitcalc->check_distance( $dt['distance'] );
    $ccount = $testworkoutsfilter[$i][0]['ccount'];
    $searchname[$key] = $dt['sportstype'] . ' - ' . $dt['name'] . ' - ' . $distance['amount'] . ' ' . $length_unit . ' (' . $ccount . ')';
}

if ( count( $testworkoutsfilter ) == 0 ) $searchname['none'] = __('No workouts',true);

echo $form->input('search',
                  array(
                  'legend' => false,
                  'label' => __('Choose workout', true),
                  'before' => '',
                  'after' => '',
                  'between' => '',
                  'class' => 'form-control',
                  'options' => $searchname
                  ));

echo $form->input('fromdate',
                  array(
                  'type' => 'date',
                  'before' => '',
                  'after' => '',
                  'between' => '',
                  'class' => 'form-control',
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
                  'class' => 'form-control',
                  'label' => __('To', true),
                  'minYear' => date('Y',time())-5,
                  'maxYear' => date('Y',time())+1
                  //'error' => array('wrap' => 'div', 'style' => 'color:red')
));

/** not finished **/
echo $form->hidden('id');
echo $form->hidden('user_id');

?>
<br />
<?php
echo $form->submit(__('Display',true), array('name' => 'display','class'=>'btn btn-primary'));

?>
                   </div>
                   </fieldset>
<?php

      echo $form->end();
?>

<?php

$chart_haxis = __('min/' . $unit['length'], true);
$chart_vaxis = __('Time', true);

$chart_color1 = '#06FF02';
//$chart_color2 = '#F1AD28';

?>

<script type="text/javascript">

      google.load('visualization', '1', {packages: ['corechart']});

      function getJSONdata( jsonurl, chart ) { 
          jQuery.ajax({
              url: jsonurl,
              type: 'POST',
              success: function (data, textStatus, jqXHR) {
                //alert(data.toString());
                //alert(textStatus.toString());
                //alert(jqXHR.responseText);

                var data = jQuery.parseJSON(jqXHR.responseText);
                var graphdata = [['<?php __('Time');?>', '<?php __('Formcurve'); ?>']];
                
                jQuery.each(data.results, function(i, jsonobj) {
                    graphdata.push([jsonobj.tcttime, jsonobj.tctdata1]);
                });
                
                drawVisualization(graphdata, chart);
              }, error: function (data, textStatus, jqXHR) { 
                //alert(textStatus); 
                console.log( "JSON Data: ERROR"  );
              }
          });            
      }

      function drawVisualization(jsdata, chart) {
          console.log(jsdata);
          //jsdata = jsdata_title.concat(jsdata);
          
          var data = google.visualization.arrayToDataTable( jsdata );
        
          // Create and draw the visualization.
          var ac = new google.visualization.AreaChart(document.getElementById(chart));

          var graph_width = 700;
          var graph_height = 490;

          if ( window.innerWidth <= 1200 ) { 
            graph_width = 550; 
            graph_height = 450; 
          }   

          if ( window.innerWidth <= 992 ) { 
            graph_width = 350; 
            graph_height = 350; 
          }   

          if ( window.innerWidth <= 768 ) { 
            graph_width = 650; 
            graph_height = 550; 
          }   

          if ( window.innerWidth <= 400 ) { 
            graph_width = 270; 
            graph_height = 300; 
          }   

          // read size of div - write in variable and set here
          ac.draw(data, {
            //title : 'A vs. C',
            //isStacked: true,
            colors: ['<?php echo $chart_color1; ?>'],
            pointSize: 0,
            width: graph_width,
            height: graph_height,
            legend: { position: 'top' },
            chartArea: {'width': '80%', 'height': '65%'},
            vAxis: { title: "<?php echo $chart_haxis; ?>",  
              slantedText:true, slantedTextAngle:45 },
            hAxis: { title: "<?php echo $chart_vaxis; ?>" }
          });
      }
      
</script>

<h2><?php __('Formcurve'); ?></h2>

<?php

if ( $searchfilter && count($testworkoutsfilter) > 0 )
{

  $jsonurl = Configure::read('App.hostUrl') . Configure::read('App.serverUrl') . '/trainingstatistics/statistics_formcurve_json/'.'searchfilter:' . $searchfilter . '/type:' . '/start:' . $start . '/end:' . $end;

?>
<script language="JavaScript">
function get_formcurve() {
  getJSONdata('<?php echo $jsonurl; ?>','chart1');
}

google.setOnLoadCallback(get_formcurve);
</script>

<div id="chart1"></div>

<!--
<?php if ( $_SERVER['HTTP_HOST'] == 'local.tricoretraining.com' ) { ?>
<br /><br /><br /><br /><br /><br />
Debugging: (only local.tricoretraining.com)<br />
<a href="<?php echo $jsonurl ?>" target="_blank"><?php echo $jsonurl; ?></a>
<?php } ?>

<br /><br /><br /><br /><br /><br /><br /><br />
-->

<?php

} else
{
  __('Sorry, no graph available - choose a testworkout please.');

}
?>

        </div>
      </div>

<?php

      $this->js_addon = '';

?>