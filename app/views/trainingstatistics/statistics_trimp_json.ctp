<?php

$intervaldays = 10;

if ( $graphtype == 'chronic' )
{
       $gtitle = 'CTL';
       $day_back = 45;
       $step = round( $max_unit / 10 );
} elseif ( $graphtype == 'acute' )
{
       $gtitle = 'ATL';
       $day_back = 7;
       $step = round( $max_unit / 10 );
}
?>
{
"elements":[
/*{
 "type":"area",
 "fill-alpha": 0.4,
 "width": 2,
 "dot-size": 4,
 "halo-size": 2,
 "colour": "#FF6200",
 "fill": "#FFEC8A",     
 "text":"<?php __('TRIMP planned'); ?>",
 "on-show":  {"type": "shrink-in", "cascade":1, "delay":0.5},
 "values":[<?php for ( $i = $day_back; $i < ( count($trimp_tl_planned) ); $i++ ) { echo "{ \"value\": "; echo round($trimp_tl_planned[$i]); echo ",\"colour\": \"#D02020\", \"tip\": \"" . __('TRIMP planned', true) . "\n"; echo round($trimp_tl_planned[$i]) . "\"}"; if ( $i < ( count( $trimp_tl_planned ) - 1 ) ) echo ","; } ?>]
},*/
{
 "type":"area",
 "fill-alpha": 0.4,
 "width": 2,
 "dot-size": 4,
 "halo-size": 2,
// "colour": "#06FF02",
// "fill": "#CCFFCF",     
 "colour": "#f1ad28",
 "fill": "#fffccf",     
 "text":"<?php __('Acute Training Load'); ?>",
 "on-show": {"type": "shrink-in", "cascade":1, "delay":0.5},
 "values":[<?php for ( $i = $day_back; $i < ( count($trimp_tl_done) ); $i++ ) { echo "{ \"value\": "; echo round($trimp_tl_done[$i]); echo ",\"colour\": \"#D02020\", \"tip\": \"" . __('TRIMP real', true) . "\n" . round($trimp_tl_done[$i]) . "\"}"; if ( $i < ( count( $trimp_tl_done ) - 1 ) ) echo ","; } ?>]
}
	],
  "bg_colour": "#ffffff",
	"title":{
		"text":"<?php __('How fit am I?'); ?>",
		"style":"{font-size:12px;padding-bottom:10px;text-align:left;color:#999999;}"
	},
  "y_axis": {
    "colour": "#aaaaaa",
    "grid-colour": "#eeeeee",
    "stroke": 1,
    "tick-length": 5,
    "min": 0,
    "max":<?php echo $max_unit; ?>,
    "steps":<?php echo $step; ?>
  },
  "tooltip": {
    "stroke": 1,
    "colour": "#000000",
    "background": "#fffbca"
  },	
	"x_axis":{
    "colour": "#aaaaaa",
    "grid-colour": "#eeeeee",
    "stroke": 1,
    "tick-height": 4,
		"labels":{
      "rotate": "vertical",
			"labels":[<?php for ( $i = $day_back; $i < ( count($trimp_dates) ); $i++ ) { if ( $i%$intervaldays == 0 ) { $sday = date('D', strtotime($trimp_dates[$i])); echo "\"" . __($sday, true) . " "; echo $unitcalc->check_date($trimp_dates[$i],'show') . "\""; } else echo "\"\""; if ( $i < ( count( $trimp_dates ) - 1 ) ) echo ","; } ?> ]
			}
		},
	"bg_colour":"#ffffff"
}

<?php

$this->js_addon = '';

?>