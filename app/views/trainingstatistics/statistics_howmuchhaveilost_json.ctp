<?php

if ( $stype == 'weight' )
{

?>
{
	"elements":[
<?php
if ( isset( $diff_per_week ) )
{
?>
{
      "type":"area",
      "fill-alpha": 0.4,
      "width": 2,
      "dot-size": 4,
      "halo-size": 2,
      "colour":"#00EE00",
      "fill": "#CCFF99",     
      "text":"<?php __('Weight planned'); echo ' (' . $weight_unit . ')'; ?>",
      "on-show":  {"type": "shrink-in", "cascade":1, "delay":0.5},
      "dot-style": {
        "tip":"#val# <?php echo $weight_unit; ?>" },
      "values":[<?php 
$j = 0; 
for ( $i = 0; $i < count($weeks); $i++ ) 
{
    if ( $i > ( count($weeks) - ( $diffweek + 1 ) ) ) 
    {
        echo round( ( $lastweight + ( $j * $diff_per_week ) ), 1); 
        $j++; 
    } else 
    {
        echo "null"; 
    }
    if ( $i != ($maxweeks-1) ) echo ","; 
} 
?>]
    },
<?php } ?>
{
      "type":"area",
      "fill-alpha": 0.4,
      "width": 2,
      "dot-size": 4,
      "halo-size": 2,
      "colour":"#FFAE00",
      "fill": "#FFFCCF",     
      "text":"<?php __('Weight'); echo ' (' . $weight_unit . ')'; ?>",
      "on-show":  {"type": "shrink-in", "cascade":1, "delay":0.5},
      "tip":"<?php __('Average weight'); ?> #val#",
      "dot-style": {
        "tip":"#val# <?php echo $weight_unit; ?>" },
			"values":[<?php 
for ( $i = 0; $i < $maxweeks; $i++ ) 
{
    $w = $weeks[$i];
    if ( $trainings2[$w]['avgweight'] > 0 ) 
        echo $trainings2[$w]['avgweight']; 
    else 
        echo "null"; 
    if ( $i != ($maxweeks-1) ) echo ","; 
} 
      ?>]
		}
	],
	"title":{
		"text":"<?php __('How much have I lost?'); ?>",
		"style":"{font-size:12px;padding-bottom:10px;text-align:left;color:#999999;}"
	},
	"y_axis":{
		"stroke":1,
		"colour":"#c6d9fd",
		"grid-colour":"#dddddd",
		"min":<?php echo $minweight; ?>,
		"max":<?php echo $maxweight; ?>,
		"steps":<?php echo $step; ?>
	},
	"x_axis":{
		"offset":false,
		"stroke":1,
		"colour":"#c6d9fd",
		"grid-colour":"#dddddd",
		"labels":{
    "rotate": "vertical",
			"labels":[<?php 
for ( $i = 0; $i < $maxweeks; $i++ ) 
{
    echo "\"" . substr( $weeks[$i], 0, 4 ) . '-' . substr( $weeks[$i], 4, 2 ) . "\""; 
    if ( $i != ($maxweeks-1) ) echo ","; 
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