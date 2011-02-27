<?php

$intervaldays = 4;

?>
{
	"elements":[
<?php

if ( isset( $diff_per_week ) )
{

?>
{
<?php

	echo $statistics->chart_settings( __('Weight planned', true) . ' (' . $weight_unit . ')', '#00EE00', '#CCFF99', 'mid-slide', 'area', null, __('Average weight planned', true) . ' #val# ' . $weight_unit . '<br>' . __('Week', true) . ' #x_label#' );
	
?>
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
<?php

	echo $statistics->chart_settings( __('Weight', true) . ' (' . $weight_unit . ')', '#FFAE00', '#FFFCCF', 'mid-slide', 'area', null, __('Average weight', true) . ' #val# ' . $weight_unit . '<br>' . __('Week', true) . ' #x_label#' );
	
?>
 	  "values":[<?php 
for ( $i = 0; $i < $maxweeks; $i++ ) 
{
    $w = $weeks[$i];
    if ( $trainings2[$w]['avgweight'] > 0 ) 
        echo round($trainings2[$w]['avgweight'], 1); 
    else 
        echo "null"; 
    if ( $i != ($maxweeks-1) ) echo ","; 
} 
      ?>]
		}
	],
<?php

	//echo $statistics->chart_title( __('How much have I lost?', true) );

	echo $statistics->y_axis( 1, round($maxweight), $minweight, 10, $weight_unit );


$labels_output = '';
for ( $i = 0; $i < $maxweeks; $i++ ) 
{
    $labels_output .= '"' . substr( $weeks[$i], 0, 4 ) . '-' . substr( $weeks[$i], 4, 2 ) . '"';
    if ( $i != ($maxweeks-1) ) $labels_output .= ","; 
} 

	echo $statistics->x_axis( __('Time', true), $labels_output, 1, '', $maxweeks );

	echo $statistics->chart_bgcolor();
?>
}

<?php

$this->js_addon = '';

?>