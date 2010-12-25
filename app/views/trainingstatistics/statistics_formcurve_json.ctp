<?php 

$intervaldays = 7;

?>
{
	"elements":[
		{
      "text":"<?php __('Formcurve'); ?>",
      "type":"area",
      "fill-alpha": 0.4,
      "width": 2,
      "dot-size": 2,
      "halo-size": 1,
      "colour": "#FF6200",
      "fill": "#FFEC8A",     
			//"type":"line",
			//"colour":"#ffae00",
			//"font-size":12,
			"dot-style": {
				//"type":"solid-dot", "colour":"#a44a80", "dot-size": 3,
				"tip":"#val# <?php echo $unit['length']; ?>/h" },
			"on-show":	{"type": "shrink-in", "cascade":1, "delay":0.5},
			"values":[<?php for ( $i = 0; $i < count($trainings); $i++ ) { $rdate = date( 'Y-m-d', ( $startday_ts + ( $i * 86400 ) ) ); $val = $trainings[$rdate]['distanceperunit']; /**if ( $val == 0 ) echo "\"\""; else **/ echo $val; if ( $i < ( count( $trainings ) - 1 ) ) echo ","; } ?>]
		}
	],
	"title":{
		"text":"<?php __('How fast am I?'); ?>",
		"style":"{font-size:12px;padding-bottom:10px;text-align:left;color:#999999;}"
	},
	"y_axis":{
		"stroke":1,
		"colour":"#c6d9fd",
		"grid-colour":"#dddddd",
		"min":0,
		"max":<?php echo $max_perunit; ?>,
		"steps":<?php echo $max_perunit/10; ?>
    //"labels": "#val km/h"
	},
	"x_axis":{
		"offset":true,
		"stroke":1,
		"colour":"#c6d9fd",
		"grid-colour":"#FFFFFF",
		"labels":{
      "rotate": "vertical",
			"labels":[<?php for ( $i = 0; $i < count($trainings); $i++ ) { $rdate = $unitcalc->check_date( date( 'Y-m-d', ( $startday_ts + ( $i * 86400 ) ) ) ); if ( $i%$intervaldays != 0 ) $rdate = ""; echo "\"" . $rdate . "\"";  if ( $i < ( count( $trainings ) - 1) ) echo ","; } ?> ]
			}
		},
	"bg_colour":"#ffffff"
}

<?php

$this->js_addon = '';

?>