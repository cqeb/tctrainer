<?php

class StatisticsHelper extends AppHelper {
	var $components = array('Email', 'Cookie', 'RequestHandler', 'Session', 'Unitcalc');
	var $helpers = array('Html', 'Form', 'Javascript', 'Time', 'Session', 'Ofc', 'Unitcalc', 'Xls');

	function beforeRender() 
	{
	
	}

	function chart_settings( $chart_title, $color, $fill, $showtype = 'mid-slide', $type = 'area', $tip = '<br>#x_label#', $tipreplace = '' )
	{
		$chart_tip = $chart_title;
		$tip = $chart_tip . ' #val# ' . $tip;
		if ( isset( $tipreplace ) && $tipreplace != '' ) $tip = $tipreplace;
		 
		//showtype mid-slide
		$default_settings = '
		"type":"' . $type . '",
		"fill-alpha":0.4,
		"width":2,
		"dot-size":4,
		"halo-size":2,
		"colour":"' . $color . '",
		"fill":"' . $fill . '",     
		"text":"' . $chart_title . '",
		"on-show": {"type": "' . $showtype . '", "cascade":1, "delay":0.5},
	    "dot-style":{
	      	"tip":"' . $tip . '"
	    },
	    ';
		
		return $default_settings;
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
			$steps = round( $number_labels / 8 );
		} else
		{
			$steps = 8;
		}
		
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
	function chart_title( $title )
	{

		$chart_title = '"title":{
			"text":"' . $title . '",
			"style":"{font-size:12px;padding-bottom:10px;text-align:left;color:#999999;}"
		},';
		
		return $chart_title;
		
	}
	
	function chart_bgcolor()
	{

	    $chart_bgcolor = '
	    ,"bg_colour":"#FFFFFF"
	    ';
		return $chart_bgcolor;
	}

	function trimp_values( $values, $start )
	{
		
		$output = '
		"values":['; 

		for ( $i = $start; $i < ( count($values) ); $i++ ) 
		{
			 $output .= round($values[$i]); 
			 if ( $i < ( count( $values ) - 1) ) $output .= ","; 
		}
		$output .= ' 
		]
		';
		return $output;
		
	}
}
?>