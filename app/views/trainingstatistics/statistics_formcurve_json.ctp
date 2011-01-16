<?php 

$intervaldays = 14;

?>{
"elements":[{
      "text":"<?php __('Formcurve'); ?>",
      "type":"area",
      "fill-alpha":0.4,
      "width":2,
      "dot-size":2,
      "halo-size":1,
	  "colour":"#F1AD28",
	  "fill":"#FFFCCF",     
      "on-show":{"type": "mid-slide", "cascade":1, "delay":0.5},
	  "dot-style":{
	  	"tip":"#val# min/<?php echo $unit['length']; ?>" 
	  },
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
	"title":{
			"text":"<?php __('How fast am I?'); ?>",
			"style":"{font-size:12px;padding-bottom:10px;text-align:left;color:#999999;}"
	},
	"y_axis":{
		"stroke":1,
		"offset":true,
	    "colour":"#AAAAAA",
		"grid-colour":"#DDDDDD",
		"min":0,
		"max":<?php echo $max_perunit; ?>
	},
	"x_axis":{
		"stroke":1,
		"offset":true,
	    "colour":"#AAAAAA",
		"grid-visible": false,
		"labels":{
	        	"rotate": "vertical",
				"steps": 20,
				"labels":[<?php 
for ( $i = 0; $i < count($trainings); $i++ ) 
{
	 $rdate = $unitcalc->check_date( date( 'Y-m-d', ( $startday_ts + ( $i * 86400 ) ) ) ); 
	 echo "\"" . $rdate . "\"";  
	 
	 if ( $i < ( count( $trainings ) - 1 ) ) echo ","; 
}  
?> ]
			}
	},
	"bg_colour":"#ffffff"
}

<?php

$this->js_addon = '';

?>