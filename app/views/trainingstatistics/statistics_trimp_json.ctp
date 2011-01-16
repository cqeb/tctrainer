<?php

if ( $graphtype == 'chronic' )
{
       $gtitle = 'CTL';
       $day_back = 42;

} elseif ( $graphtype == 'acute' )
{
       $gtitle = 'ATL';
       $day_back = 7;
}
?>{
"elements":
[
<?php if ( $userobject['advanced_features'] ) { ?>{
		"type":"area",
		"fill-alpha":0.4,
		"width":2,
		"dot-size":4,
		"halo-size":2,
		"colour":"#06FF02",
		"fill":"#CCFFCF",     
		"text":"<?php __('TRIMP planned'); ?>",
		"on-show": {"type": "shrink-in", "cascade":1, "delay":0.5},
	    "dot-style":{
	      	"tip":"<?php __('TRIMP planned'); ?> #val#<br>#x_label#"
	    },
		"values":[<?php 
for ( $i = $day_back; $i < ( count($trimp_tl_planned) ); $i++ ) 
{
	 echo round($trimp_tl_planned[$i]); 
	 if ( $i < ( count( $trimp_tl_planned ) - 1) ) echo ","; 
} 
?>]
	},
<?php } ?>
{
		"type":"area",
		"fill-alpha":0.4,
		"width":2,
		"dot-size":4,
		"halo-size":2,
		"colour":"#F1AD28",
		"fill":"#FFFCCF",     
		"text":"<?php __('TRIMP trained'); ?>",
      	"on-show":{"type": "mid-slide", "cascade":1, "delay":0.5},
	    "dot-style":{
	      	"tip":"<?php __('TRIMP trained'); ?> #val#<br>#x_label#"
	    },
		"values":[<?php 
for ( $i = $day_back; $i < ( count($trimp_tl_done) ); $i++ ) 
{
	 echo round($trimp_tl_done[$i]); 

	 if ( $i < ( count( $trimp_tl_done ) - 1 ) ) echo ","; 
} 
?>]
	}],
	
	"title":{
			"text":"<?php __('How fit am I?'); ?>",
			"style":"{font-size:12px;padding-bottom:10px;text-align:left;color:#999999;}"
	},
	"y_axis": {
	    "colour":"#AAAAAA",
	    "grid-colour":"#DDDDDD",
	    "stroke":1,
	    "min":0,
	    "max":<?php echo $max_unit; ?>,
	    "steps":10
	},
	"x_axis":{
		"offset":true,
	    "colour":"#AAAAAA",
		"grid-visible": false,
	    "stroke":1,
		"labels":{
	      		"rotate":"vertical",
	    		"steps":20,
				"labels":[<?php 
				
$j = 0;
for ( $i = $day_back; $i < ( count($trimp_dates) ); $i++ ) 
{
	$sday = date('D', strtotime($trimp_dates[$i])); 
	//echo "\"" . __($sday, true) . " "; 
	if ( $i%20 == 0 ) echo '"' . $unitcalc->check_date($trimp_dates[$i],'show') . '"';
	else echo '""'; 
	
	if ( $i < ( count( $trimp_dates ) - 1 ) ) echo ",";
	$j++; 
} 

?> ]
		}
	},
	
	"bg_colour":"#FFFFFF"
}

<?php

$this->js_addon = '';

?>