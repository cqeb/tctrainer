<?php 

$intervaldays = 14;
$startday_ts = strtotime( $start );

//print_r($trainings);

$output = '{ "results": [ '; $j = 0;

for ( $i = 0; $i < count($trainings); $i++ ) 
{
	$rdate = date( 'Y-m-d', ( $startday_ts + ( $i * 86400 ) ) );
	$val = $trainings[$rdate]['distanceperunit']; 
	$rdate = $unitcalc->check_date( $rdate );
    $output .= ' { ' . 
        '"tcttime": "' . $rdate . '", ' . 
        '"tctdata1": ' . $val . 
    ' } ';

	if ( $i < ( count( $trainings ) - 1 ) ) $output .= ","; 
} 

$output .= ' ] }';

echo $output;
   
$this->js_addon = '';

?>