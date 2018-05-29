<?php

class StatisticsHelper extends AppHelper {
	var $components = array('Email', 'Cookie', 'RequestHandler', 'Session', 'Unitcalc');
	var $helpers = array('Html', 'Form', 'Javascript', 'Time', 'Session', 'Unitcalc', 'Xls');

	function beforeRender() 
	{
	
	}

	function y_axis( $stroke = 1, $max, $min = 0, $steps = 1, $legend )
	{
		$chart_yaxis = '
		"y_axis": {
		    "colour":"#AAAAAA",
		    "grid-colour":"#DDDDDD",
		    "stroke":' . $stroke . ',
		    "min":' . $min . ',
		    "max":' . $max . ',
		    "offset":true,
		    "steps":' . $steps . '
		},
		"y_legend":{
		    "text":"' . $legend . '",
		    "style":"{font-size: 12px; color:#000000;}"
		},
		
		';
		
		return $chart_yaxis;
	}
	
	function x_axis( $legend, $labels, $stroke = 1, $steps = '', $number_labels = null )
	{
		if ( !isset( $steps ) || $steps == '' )
		{
			if ( isset( $number_labels ) )
			{
				if ( $number_labels < 10 )
					$steps = 2;
				elseif ( $number_labels < 20 )
					$steps = 3;
				else
					$steps = 5; //round( $number_labels / 5 );
				
			} else
			{
				$steps = 5;
			}
		}
		
		if ( $steps < 1 ) $steps = 1;
		
		$chart_xaxis = '
		"x_legend":{
		    "text":"' . $legend . '",
		    "style":"{font-size: 12px; color:#000000;}"
		},
		"x_axis":{
			"offset":true,
		    "colour":"#AAAAAA",
			"grid-visible": false,
		    "stroke":' . $stroke . ',
			"labels":{
		      		"rotate":"vertical",
		    		"steps":' . $steps . ',
					"labels":[
					' . $labels . '
 					]
		}
	}					
		';
		
		return $chart_xaxis;
	}

/*	
	function chart_title( $title )
	{

		$chart_title = '"title":{
			"text":"' . $title . '",
			"style":"{font-size:12px;padding-bottom:10px;text-align:left;color:#999999;}"
		},';
		
		return $chart_title;
		
	}
*/	
/*
	function chart_bgcolor()
	{

	    $chart_bgcolor = '
	    ,"bg_colour":"#FFFFFF"
	    ';
		return $chart_bgcolor;
	}
*/

	function trimp_values( $values, $start )
	{
		
		for ( $i = $start; $i < ( count($values) ); $i++ ) 
		{
			 $output[] = round($values[$i]); 
		}
		return $output;
		
	}
}
?>