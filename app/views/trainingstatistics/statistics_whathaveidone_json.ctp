<?php

$intervaldays = round( $maxweeks / 8 );

if ( $stype == 'distance' )
{

?>{
"elements":[{
<?php

	echo $statistics->chart_settings( __('Distance', true) . ' (' . $length_unit . ')', '#F1AD28', '#FFFCCF', 'mid-slide', 'area', null, '#val# ' . $length_unit . '<br>' . __('Week', true) . ' #x_label#');

?>
	  "values":[<?php 
for ( $i = 0; $i <= $maxweeks; $i++ ) 
{
		$w = $weeks[$i]; 
		echo $trainings2[$w]['sumdistance']; 
		if ( $i != ($maxweeks) ) echo ","; 
} 
?>]
}],

<?php

	//echo $statistics->chart_title( __('What have I done?', true) );

	echo $statistics->y_axis( 1, $maxdistance, 0, round( $maxdistance / 8), $length_unit );

	$labels_output = '';
	
	for ( $i = 0; $i <= $maxweeks; $i++ ) 
	{
		 $labels_output .= "\"" . substr( $weeks[$i], 0, 4) . "-" . substr( $weeks[$i], 4, 2) . "\""; 
		 if ( $i != ($maxweeks) ) $labels_output .= ","; 
	} 
	
	echo $statistics->x_axis( __('Time', true), $labels_output, round( count( $weeks ) / 8 ), '', $maxweeks );

	echo $statistics->chart_bgcolor();

?>

}

<?php

}

if ( $stype == 'duration' )
{

?>{
"elements":[{
<?php

	echo $statistics->chart_settings( __('Duration', true) . ' (' . __('hours',true) . ')', '#F1AD28', '#FFFCCF', 'mid-slide', 'area', null, '#val# h<br>' . __('Week', true) . ' #x_label#');

?>
	  "values":[<?php 

for ( $i = 0; $i <= $maxweeks; $i++ ) 
{
	 $w = $weeks[$i]; 
	 echo round($trainings2[$w]['sumduration'], 1); 
	 if ( $i != ($maxweeks) ) echo ","; 
} 
?>]
}],
<?php

	//echo $statistics->chart_title( __('What have I done?', true) );

	echo $statistics->y_axis( 1, $maxduration, 0, round( $maxduration / 8), __('hours',true) );

	$labels_output = '';
	
	for ( $i = 0; $i <= $maxweeks; $i++ ) 
	{
		 $labels_output .= "\"" . substr( $weeks[$i], 0, 4) . "-" . substr( $weeks[$i], 4, 2) . "\""; 
		 if ( $i != ($maxweeks) ) $labels_output .= ","; 
	} 
	
	echo $statistics->x_axis( __('Time', true), $labels_output, round( count( $weeks ) / 8 ), '', $maxweeks );

	echo $statistics->chart_bgcolor();

?>
}

<?php

}

$this->js_addon = '';

?>