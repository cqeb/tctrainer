<?php

$intervaldays = round( $maxweeks / 10 );

if ( $stype == 'distance' )
{

?>{
"elements":[{
      "type":"area",
      "fill-alpha":0.4,
      "width":2,
      "dot-size":4,
      "halo-size":2,
 	  "colour":"#F1AD28",
	  "fill":"#FFFCCF",
	  "text":"<?php __('Distance'); ?> (<?php echo $length_unit; ?>)",
      "on-show":{"type": "mid-slide", "cascade":1, "delay":0.5},
      "dot-style":{
			"tip":"#val# <?php echo $length_unit; ?><br><?php __('Week'); ?> #x_label#" 
      },
	  "values":[<?php for ( $i = 0; $i <= $maxweeks; $i++ ) { $w = $weeks[$i]; echo $trainings2[$w]['sumdistance']; if ( $i != ($maxweeks) ) echo ","; } ?>]
}],
	
"title":{
		"text":"<?php __('What have I done?'); ?>",
		"style":"{font-size:12px;padding-bottom:10px;text-align:left;color:#999999;}"
},

"y_axis":{
		"stroke":1,
	    "colour":"#AAAAAA",
		"grid-colour":"#DDDDDD",
		"min":0,
		"max":<?php echo $maxdistance; ?>,
		"steps":<?php echo round( $maxdistance / 10); ?>
},

"x_axis":{
		"offset":true,
		"stroke":1,
	    "colour": "#AAAAAA",
		"grid-visible":false,
		"labels":{
      		"rotate": "vertical",
	      	"steps": <?php echo round( count( $weeks ) / 8 ); ?>,
			"labels":[<?php for ( $i = 0; $i <= $maxweeks; $i++ ) { echo "\"" . substr( $weeks[$i], 0, 4) . "-" . substr( $weeks[$i], 4, 2) . "\""; if ( $i != ($maxweeks) ) echo ","; } ?> ]
		}
	},
	"bg_colour":"#ffffff"
}

<?php

}

if ( $stype == 'duration' )
{

?>{
"elements":[{
      "type":"area",
      "fill-alpha":0.4,
      "width":2,
      "dot-size":4,
      "halo-size":2,
 	  "colour":"#F1AD28",
	  "fill":"#FFFCCF",     
	  "text":"<?php __('Duration'); echo ' ('; __('hours'); echo ')'; ?>",
      "on-show":{"type": "mid-slide", "cascade":1, "delay":0.5},
      "dot-style":{
			"tip":"#val# h<br><?php __('Week'); ?> #x_label#"  
      },
	  "values":[<?php 
for ( $i = 0; $i <= $maxweeks; $i++ ) 
{
	 $w = $weeks[$i]; 
	 echo round($trainings2[$w]['sumduration'], 1); 
	 if ( $i != ($maxweeks) ) echo ","; 
} 
?>]
}],
	"title":{
		"text":"<?php __('What have I done?'); ?>",
		"style":"{font-size:12px;padding-bottom:10px;text-align:left;color:#999999;}"
	},
	"y_axis":{
		"stroke":1,
	    "colour":"#AAAAAA",
		"grid-colour":"#DDDDDD",
		"min":0,
		"max":<?php echo $maxduration; ?>,
		"steps":<?php echo round($maxduration/10); ?>
	},
	"x_axis":{
		"offset":true,
		"stroke":1,
	    "colour":"#AAAAAA",
		"grid-visible":false,
		"labels":{
	      	"rotate":"vertical",
	      	"steps":<?php echo round( count( $weeks ) / 8 ); ?>,
			"labels":[<?php 
for ( $i = 0; $i <= $maxweeks; $i++ ) 
{
	 echo "\"" . substr( $weeks[$i], 0, 4) . "-" . substr( $weeks[$i], 4, 2) . "\""; 
	 if ( $i != ($maxweeks) ) echo ","; 
} 
?> ]
		}
	},
	"bg_colour":"#ffffff"
}

<?php

}

$this->js_addon = '';

?>