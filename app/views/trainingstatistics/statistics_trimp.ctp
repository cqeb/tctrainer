      <div class="panel panel-default" id="forms">
        <div class="panel-heading"><h1><?php __('Statistics'); ?></h1></div>
        
        <div class="panel-body">
                   
           <?php echo $form->create('Trainingstatistic', array('action' => 'statistics_trimp', 'class' => 'form-horizontal')); ?>
           <fieldset>
           <legend><?php __('How fit am I?'); ?></legend>

           <?php if ($session->read('flash')) { ?>
           <div class="<?php echo $statusbox; ?>">
           <?php echo $session->read('flash'); $session->delete('flash'); ?>
           </div><br />
           <?php } ?>

           <?php __('These graphs show you your short term (ATL) and long term training load (CTL). How exhausted you are (training load of the last 7 days) and fit you are (training load of last 42 days).'); ?> 
           <a target="statistics" href="/blog/<?php if ( $locale == 'eng' || $locale == '' ) { ?>en<?php } else { ?>de<?php } ?>/what-do-i-learn-from-the-statistics/"><?php __('Explanation on these statistics in our blog?'); ?></a>
           <br /><br />

<div class="form-group">
<?php

echo $form->input('sportstype',
                  array(
                  'legend' => false,
                  'label' => __('Sport', true),
                  'before' => '',
                  'after' => '',
                  'between' => '',
                  'class' => 'form-control',
                  'options' => array(
                                 '' => __('All', true),
                                 'RUN' => __('Run', true),
                                 'BIKE' => __('Bike', true),
                                 'SWIM' => __('Swim', true)
                                 )));
?>
</div>

<div class="form-group">
<?php

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
));
?>
</div>

<div class="form-group">
<?php

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
));

echo $form->hidden('id');
echo $form->hidden('user_id');

?>
<br />
<?php

echo $form->submit(__('Display',true), array('name' => 'display','class' => 'btn btn-primary'));

?>
</div>
                   </fieldset>
<?php

      echo $form->end();
?>

<?php

$chart_haxis = __('Sum', true) . ' ' . __('Trimps', true);
$chart_vaxis = __('Time', true);

$chart_color1 = '#06FF02';
$chart_color2 = '#F1AD28';

if ( count( $trainingdatas ) > 0 )
{
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
                var graphdata = [['<?php __('Time');?>', '<?php __('TRIMP planned'); ?>', '<?php __('TRIMP trained'); ?>']];
                
                jQuery.each(data.results, function(i, jsonobj) {
                    graphdata.push([jsonobj.tcttime, jsonobj.tctdata1, jsonobj.tctdata2,]);
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
            colors: ['<?php echo $chart_color1; ?>', '<?php echo $chart_color2; ?>'],
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

<h2><?php __('Grade of fitness (Chronic Training Load)'); ?></h2>

<?php

$js_url_graph_ctl = Configure::read('App.hostUrl') . Configure::read('App.serverUrl') . '/trainingstatistics/statistics_trimp_json/' . 'stype:' . $sportstype . '/start:' . $start . '/end:' . $end . '/gtype:chronic/?chart=chart1';

?>
<script language="JavaScript">
function get_ctl() {
  getJSONdata('<?php echo $js_url_graph_ctl; ?>', 'chart1');
}

google.setOnLoadCallback(get_ctl);
</script>

<div id="chart1"></div>

<!--
<?php if ( $_SERVER['HTTP_HOST'] == 'localhost' ) { ?>
<br /><br /><br /><br /><br /><br />
Debugging: (only localhost)<br />
<a href="<?php echo $js_url_graph_ctl; ?>" target="_blank"><?php echo $js_url_graph_ctl; ?></a>
<?php } ?>

<br /><br /><br /><br /><br /><br /><br /><br />
-->

<h2><?php __('Grade of fatigue (Acute Training Load)'); ?></h2>

<?php

$js_url_graph_atl = Configure::read('App.hostUrl') . Configure::read('App.serverUrl') . '/trainingstatistics/statistics_trimp_json/' . 'stype:' . $sportstype . '/start:' . $start . '/end:' . $end . '/gtype:acute/?chart=chart2';

?>

<script language="JavaScript">
function get_atl() {
  getJSONdata('<?php echo $js_url_graph_atl; ?>','chart2');
}

google.setOnLoadCallback(get_atl);
</script>

<div id="chart2"></div>

<!--
<?php if ( $_SERVER['HTTP_HOST'] == 'localhost' ) { ?>
<br /><br /><br /><br /><br /><br />
Debugging: (only localhost)<br />
<a href="<?php echo $js_url_graph_atl; ?>" target="_blank"><?php echo $js_url_graph_atl; ?></a>
<?php } ?>
-->

<?php 

} else
{
  __('No Chart data.');
}

?>

<!--
<br /><br /><br /><br /><br /><br /><br /><br />
-->
        </div>
      </div>

<?php

      $this->js_addon = '';

?>