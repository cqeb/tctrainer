<?php

if ( $stype == 'distance' )
{

?>
{
	"elements":[
		{
			"type":"line",
			"colour":"#ffae00",
			"text":"<?php __('Distance'); ?> (<?php echo $length_unit; ?>)",
			"font-size": 12,
			"dot-style": {
				"type":"solid-dot", "colour":"#a44a80", "dot-size": 3,
				"tip":"#val# <?php echo $length_unit; ?><br><?php __('Week'); ?> #x_label#" },
			"on-show":	{"type": "shrink-in", "cascade":1, "delay":0.5},
			"tip":"<?php __('Sum Distance:'); ?> #val#",
			"values":[<?php for ( $i = 0; $i < $maxweeks; $i++ ) { $w = $weeks[$i]; echo $trainings2[$w]['sumdistance']; if ( $i != ($maxweeks-1) ) echo ","; } ?>]
		}
	],
	"title":{
		"text":"<?php __('What have I done?'); ?>",
		"style":"{font-size:12px;padding-bottom:10px;text-align:left;color:#999999;}"
	},
	"y_axis":{
		"stroke":1,
		"colour":"#c6d9fd",
		"grid-colour":"#dddddd",
		"min":0,
		"max":<?php echo $maxdistance; ?>,
		"steps":30
	},
	"x_axis":{
		"offset":false,
		"stroke":1,
		"colour":"#c6d9fd",
		"grid-colour":"#dddddd",
		"labels":{
      "rotate": "vertical",
			"labels":[<?php for ( $i = 0; $i < $maxweeks; $i++ ) { echo "\"" . $weeks[$i] . "\""; if ( $i != ($maxweeks-1) ) echo ","; } ?> ]
			}
		},
	"bg_colour":"#ffffff"
}

<?php

}

if ( $stype == 'duration' )
{

?>
{
	"elements":[
		{
			"type":"line",
			"colour":"#ffae00",
			"text":"<?php __('Duration (hours)'); ?>",
			"font-size":12,
			"dot-style": {
				"type":"solid-dot", "colour":"#a44a80", "dot-size": 3,
				"tip":"#val# h<br><?php __('Week'); ?> #x_label#" },
			"on-show":	{"type": "shrink-in", "cascade":1, "delay":0.5},
			"tip":"<?php __('Sum Duration:'); ?> #val#",
			"values":[<?php for ( $i = 0; $i < $maxweeks; $i++ ) { $w = $weeks[$i]; echo round($trainings2[$w]['sumduration']); if ( $i != ($maxweeks-1) ) echo ","; } ?>]
		}
	],
	"title":{
		"text":"<?php __('What have I done?'); ?>",
		"style":"{font-size:12px;padding-bottom:10px;text-align:left;color:#999999;}"
	},
	"y_axis":{
		"stroke":1,
		"colour":"#c6d9fd",
		"grid-colour":"#dddddd",
		"min":0,
		"max":<?php echo $maxduration; ?>,
		"steps":<?php echo round($maxduration/20); ?>
	},
	"x_axis":{
		"offset":false,
		"stroke":1,
		"colour":"#c6d9fd",
		"grid-colour":"#dddddd",
		"labels":{
      "rotate": "vertical",
			"labels":[<?php for ( $i = 0; $i < $maxweeks; $i++ ) { echo "\"" . $weeks[$i] . "\""; if ( $i != ($maxweeks-1) ) echo ","; } ?> ]
			}
		},
	"bg_colour":"#ffffff"
}

<?php

}

if ( $stype == 'weight' )
{

?>
{
	"elements":[
		{
			"type":"line",
			"colour":"#ffae00",
			"text":"<?php __('Weight (kg/lbs)'); ?>",
			"font-size":12,
			"dot-style": {
				"type":"solid-dot", "colour":"#a44a80", "dot-size": 3,
				"tip":"#val#<br>#x_label#" },
			"on-show":	{"type": "shrink-in", "cascade":1, "delay":0.5},
			"tip":"<?php __('Sum Weight:'); ?> #val#",
			"values":[<?php for ( $i = 0; $i < $maxweeks; $i++ ) { $w = $weeks[$i]; echo $trainings2[$w]['sumweight']; if ( $i != ($maxweeks-1) ) echo ","; } ?>]
		}
	],
	"title":{
		"text":"<?php __('What have I done?'); ?>",
		"style":"{font-size:12px;padding-bottom:10px;text-align:left;color:#999999;}"
	},
	"y_axis":{
		"stroke":1,
		"colour":"#c6d9fd",
		"grid-colour":"#dddddd",
		"min":0,
		"max":150,
		"steps":5
	},
	"x_axis":{
		"offset":false,
		"stroke":1,
		"colour":"#c6d9fd",
		"grid-colour":"#dddddd",
		"labels":{
                        "rotate": "vertical",
			"labels":[<?php for ( $i = 0; $i < $maxweeks; $i++ ) { echo "\"" . $weeks[$i] . "\""; if ( $i != ($maxweeks-1) ) echo ","; } ?> ]
			}
		},
	"bg_colour":"#ffffff"
}

<?php

}

$this->js_addon = '';

?>