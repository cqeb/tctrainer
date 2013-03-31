<?php 

$intervaldays = 14;
$startday_ts = strtotime( $start );

?>{
"elements":[{
<?php

	echo $statistics->chart_settings( __('Formcurve', true), '#F1AD28', '#FFFCCF', 'mid-slide', 'area', 'min/' . $unit['length'] . '<br>#x_label#');

?>
	  "values":[<?php 

	  for ( $i = 0; $i < count($trainings); $i++ ) 
{
	 $rdate = date( 'Y-m-d', ( $startday_ts + ( $i * 86400 ) ) ); 
	 $val = $trainings[$rdate]['distanceperunit']; 
	 echo $val; 
	 if ( $i < ( count( $trainings ) - 1 ) ) echo ","; 
} 

?>]
	}],
<?php

	//echo $statistics->chart_title( __('How fast am I?', true) );

	echo $statistics->y_axis( 1, $max_perunit, 0, 1, 'min/' . $unit['length'] );

	$labels_output = '';
	
	for ( $i = 0; $i < count($trainings); $i++ ) 
	{
		
		$rdate = $unitcalc->check_date( date( 'Y-m-d', ( $startday_ts + ( $i * 86400 ) ) ) );
		$labels_output .= '"' . $rdate . '"';  
		 
		if ( $i < ( count( $trainings ) - 1 ) ) $labels_output .= ","; 
	}  
	
	echo $statistics->x_axis( __('Time', true), $labels_output, 1, '', count( $trainings ) );

	echo $statistics->chart_bgcolor();

?>
}

<?php

$this->js_addon = '';

?>