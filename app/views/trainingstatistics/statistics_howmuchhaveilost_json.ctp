<?php

$intervaldays = 4;
$tweight = $cweight = 0;

$output = '{ "results": [ '; $j = 0;

$j = 0; 

for ( $i = 0; $i < $maxweeks; $i++ ) 
{
    $w = $weeks[$i];
    if ( $trainings2[$w]['avgweight'] > 0 ) 
        $cweight = round($trainings2[$w]['avgweight'], 1); 
    else 
        $cweight = "null"; 

    if ( isset( $diff_per_week ) )
    {
        if ( $i > ( $maxweeks - ( $diffweek + 1 ) ) ) 
        {
            $tweight = round( ( $lastweight + ( $j * $diff_per_week ) ), 1); 
            $j++; 
        } else 
        {
            $tweight = "null"; 
        }
    }

    if ( $cweight == 0 || !isset($cweight) ) $cweight = "null";
    if ( $tweight == 0 || !isset($tweight) ) $tweight = "null";

    $output .= ' { ' . 
        '"tcttime": "' . $unitcalc->check_date( date( 'Y-m-d', $weeks_ts[$i] ) ) . '", ' . 
        '"tctdata1": ' . $cweight . ', ' . 
        '"tctdata2": ' . $tweight . 
    ' } ';

    if ( $i != ($maxweeks-1) ) $output .= ","; 

} 

$output .= ' ] }';

echo $output;

$this->js_addon = '';

?>