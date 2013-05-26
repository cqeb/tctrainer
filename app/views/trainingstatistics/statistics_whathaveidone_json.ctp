<?php

$intervaldays = round( $maxweeks / 8 );

$output = '{ "results": [ '; $j = 0;

if ( $stype == 'distance' )
{

	for ( $i = 0; $i <= $maxweeks; $i++ ) 
	{
			$w = $weeks[$i]; 
		    $output .= ' { ' . 
		        '"tcttime": "' . $weeks2[$i] . '", ' . //$unitcalc->check_date( date( 'Y-m-d', $weeks[$i] ) )
		        '"tctdata1": ' . $trainings2[$w]['sumdistance'] . 
		    ' } ';
			if ( $i != ($maxweeks) ) $output .= ","; 
	} 
		
} 

if ( $stype == 'duration' )
{

	for ( $i = 0; $i <= $maxweeks; $i++ ) 
	{
			$w = $weeks[$i]; 
		    $output .= ' { ' . 
		        '"tcttime": "' . $weeks2[$i] . '", ' . //$unitcalc->check_date( date( 'Y-m-d', $weeks[$i] ) )
		        '"tctdata1": ' . $trainings2[$w]['sumduration'] . 
		    ' } ';
			if ( $i != ($maxweeks) ) $output .= ","; 
	} 

}

$output .= ' ] }';

echo $output;

$this->js_addon = '';

?>