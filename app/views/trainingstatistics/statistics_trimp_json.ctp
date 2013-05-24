    <?php

    $values_array_1 = $statistics->trimp_values( $trimp_tl_planned, $timeperiod );

    $values_array_2 = $statistics->trimp_values( $trimp_tl_done, $timeperiod );
        
    $output = '{"datas": ['; $j = 0;

    for ( $i = $timeperiod; $i < ( count($trimp_dates) ); $i++ ) 
    {
        $sday = date('D', strtotime($trimp_dates[$i])); 

        $output .= '{ "time": "' . $unitcalc->check_date($trimp_dates[$i],'show') . '", "planned": "' . 
            $values_array_1[$j] . '", "trained": "' . $values_array_2[$j] . '" }';
        if ( $i != ( count( $trimp_dates ) - 1 )) $output .= ',';
        $j++;
    } 
    $output .= ']}';

    echo $output;

$this->js_addon = '';

?>