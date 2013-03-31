<?php

// check for flot
if ( isset( $_GET['flot'] ) && $_GET['flot'] == 'true' ) {

$_GET['chart'] = htmlspecialchars( trim( $_GET['chart'] ) ); 

if ( isset( $_GET['chart'] ) ) $charttype = $_GET['chart'];
else $charttype = '';

//'#06FF02', '#CCFFCF',
//'#F1AD28', '#FFFCCF',

$charttitle1 = __('TRIMP planned', true);
$charttitle2 = __('TRIMP trained', true);
//$charttitle3 = "Test";

$chart_bgcolor = '#FFFFFF';

$chart_color1 = '#DC572E';
$chart_color2 = '#2E8DEF';
//$chart_color3 = '#DDDDDD';

//$chartdata_js =  "    var data1 = [];";
//$chartdata_js .= "    var data2 = [];";

/**
print_r( $timeperiod );
print_r( $trimp_tl_planned );
print_r( $trimp_tl_done );
**/
//echo count($trimp_tl_planned);
//echo count($trimp_tl_done);

$j=0;
$labels_output = '';


$chartdata_js =  "    var data1 = [";
for ( $i = $timeperiod; $i < ( count($trimp_dates) ); $i++ ) 
{
		$sday = date('D', strtotime($trimp_dates[$i])); 

		$chartdata_js .= "['" . $unitcalc->check_date($trimp_dates[$i],'show') . "','" . $trimp_tl_planned[$i] . "']";

		if ( $i < ( count( $trimp_dates ) - 1 ) ) $chartdata_js .= ",";
		$j++; 
		if ( $j == 15 ) { $chartdata_js .= "[0,0]"; break; }
} 	
$chartdata_js .= " ];";

$chartdata_js .= "    var data2 = [];";

//echo $labels_output;

/**
$chartdata_js .= "    var data3 = [ ['1', 2], ['2', 4], ['3', 3], ['4', 5], ['5', 3], ['6', 7], ['7', 9] ];";
$chartdata_js .= "    for (var i = 0; i < 8; i += 1) {
        j = i + 1;
        data1.push([i, j]);
        data2.push([i, i]);
    }";
**/

$chartdata =  "{ data: data1, label: '" . $charttitle1 . "', color: '" . $chart_color1 . "'}";
$chartdata .= ", { data: data2, label: '" . $charttitle2 . "', color: '" . $chart_color2 . "' }";
//$chartdata .= ", { data: data3, label: '" . $charttitle3 . "', color: '" . $chart_color3 . "' }";

?>
$(function () {

	<?php echo $chartdata_js; ?>                
               
    option_lines = {
                    series: {
                        lines: {
                            show: true,
                            fill: true
                        },
                        points: {
                            show: true
                        },
                        hoverable: true
                    },
                    grid: {
                        backgroundColor: '<?php echo $chart_bgcolor; ?>',
                        borderWidth: 1,
                        borderColor: '#CDCDCD',
                        hoverable: true,
                        //minBorderMargin: 20,
                        labelMargin: 10,
                        hoverable: true,
                        clickable: true,
                        mouseActiveRadius: 50,
                        margin: {
                            top: 8,
                            bottom: 20,
                            left: 20
                        },
                       /** markings: function(axes) {
                        var markings = [];
                        var xaxis = axes.xaxis;
                            for (var x = Math.floor(xaxis.min); x < xaxis.max; x += xaxis.tickSize * 2) {
                                markings.push({ xaxis: { from: x, to: x + xaxis.tickSize }, color: "rgba(232, 232, 255, 0.2)" });
                            }
                        return markings;
                        }**/
                    },
                    legend: {
                        show: true
                    },
                    xaxis: {
                        //mode: "categories",
                        tickLength: 0
                    },
                    yaxis: {
                        autoscaleMargin: 2
                    }
        
                };
                
 
    var plot = $.plot($("#<?php echo $charttype; ?>"),
           [ <?php echo $chartdata; ?> ], option_lines );

    function showTooltip(x, y, contents) {
        $('<div id="tooltip">' + contents + '</div>').css( {
            position: 'absolute',
            display: 'none',
            top: y + 5,
            left: x + 5,
            border: '1px solid #FDD',
            padding: '2px',
            'background-color': '#FEE',
            opacity: 0.80
        }).appendTo("body").fadeIn(200);
    }

    var previousPoint = null;
    $("#<?php echo $charttype; ?>").bind("plothover", function (event, pos, item) {
        $("#x").text(pos.x.toFixed(2));
        $("#y").text(pos.y.toFixed(2));

            if (item) {
                if (previousPoint != item.dataIndex) {
                    previousPoint = item.dataIndex;
                    
                    $("#tooltip").remove();
                    var x = item.datapoint[0].toFixed(2),
                        y = item.datapoint[1].toFixed(2);
                    
                    showTooltip(item.pageX, item.pageY,
                                item.series.label + " of " + x + " = " + y);
                }
            }
    });

    $("#<?php echo $charttype; ?>").bind("plotclick", function (event, pos, item) {
        if (item) {
            $("#clickdata").text("You clicked point " + item.dataIndex + " in " + item.series.label + ".");
            plot.highlight(item.series, item.datapoint);
        }
    });
});

<?php

} else { 

?>"elements":
[
{
<?php
	echo $statistics->chart_settings( __('TRIMP planned', true), '#06FF02', '#CCFFCF', 'shrink-in' );
	// values for planned trimps
	echo $statistics->trimp_values( $trimp_tl_planned, $timeperiod );
?>
	},
{
<?php
	echo $statistics->chart_settings( __('TRIMP trained', true), '#F1AD28', '#FFFCCF', 'mid-slide' );
	// values for trained trimps	
	echo $statistics->trimp_values ( $trimp_tl_done, $timeperiod );
/*
// do not active now!
?>
	},
{
<?php
	echo $statistics->chart_settings( __('TRIMP trained competitor', true), '#FF00EEE', '#FFFCCF', 'mid-slide' );
	// values for trained trimps of competitor	
	echo $statistics->trimp_values ( $trimp_tl_competitor, $timeperiod );
*/
?>

	}],

<?php

	//echo $statistics->chart_title( __('How fit am I?', true) );

	echo $statistics->y_axis( 1, $max_unit, 0, round($max_unit/8), __('Sum', true) . ' ' . __('Trimps', true) ); //. ' / ' . __('day', true)
			
	$j = 0;
	$labels_output = '';

	for ( $i = $timeperiod; $i < ( count($trimp_dates) ); $i++ ) 
	{
		$sday = date('D', strtotime($trimp_dates[$i])); 

		$labels_output .= '"' . $unitcalc->check_date($trimp_dates[$i],'show') . '"';
		
		if ( $i < ( count( $trimp_dates ) - 1 ) ) $labels_output .= ",";
		$j++; 
	} 

	echo $statistics->x_axis( __('Time', true), $labels_output, 1, '', count( $trimp_dates ) );		

	echo $statistics->chart_bgcolor();
?>
}
<?php

$this->js_addon = '';

} // end of flot check
?>