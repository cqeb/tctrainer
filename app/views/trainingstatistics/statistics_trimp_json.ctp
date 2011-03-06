{
"elements":
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

?>
<?php
			
$j = 0;
$labels_output = '';

for ( $i = $timeperiod; $i < ( count($trimp_dates) ); $i++ ) 
{
	$sday = date('D', strtotime($trimp_dates[$i])); 

	$labels_output .= '"' . $unitcalc->check_date($trimp_dates[$i],'show') . '"';
	
	if ( $i < ( count( $trimp_dates ) - 1 ) ) $labels_output .= ",";
	$j++; 
} 

?>
<?php
	echo $statistics->x_axis( __('Time', true), $labels_output, 1, '', count( $trimp_dates ) );		

	echo $statistics->chart_bgcolor();
?>
}

<?php

$this->js_addon = '';

?>