{

  "title":{
    "text":"Training Cycles",
    "style":"{font-size: 30px;}"
  },

  "elements":[
    {
      "type":      "pie",
      "colours":   ["#d01f3c","#e03f3c","#0f1f3c","#c01f3c","#356aa0","#C79810"],
      "alpha":     0.6,
      "animate":   true,
      "border":    2,
      "start-angle": 35,
      "values" :   [
        {"value":6,"label":"1. Transition (6 weeks)", "on-click":"http://another"},
        {"value":4,"label":"2. Preparation (4 weeks)", "on-click":"http://another"},
        {"value":12,"label":"3. Base (12 weeks)", "on-click":"http://another"},
        {"value":8,"label":"4. Build (8 weeks)", "on-click":"http://another"},
        {"value":2,"label":"5. Peak (2 weeks)", "on-click":"http://another"},
        {"value":3,"label":"6. Race (3 weeks)", "tip":"Race (3 weeks)","on-click":"http://another"}
      ]
    }
  ]
}
<?php
die();

include( $_SERVER['DOCUMENT_ROOT']. '/cakephp_1.2.5/app/vendors/OFC/OFC_Chart.php' );

$title = new OFC_Elements_Title( 'Training Cycles' );

$pie = new OFC_Charts_Pie();
$pie->set_start_angle( 35 );
$pie->set_animate( true );

$pie->type             = 'pie';
$pie->colours          = array(
                       "#d01f3c",
                       "#e03f3c",
                       "#0f1f3c",
                       "#c01f3c",
                       "#356aa0",
                       "#C79810"
                       );
$pie->alpha	       = 0.6;
$pie->border	       = 19;
$pie->values	       = array(
                    new OFC_Charts_Pie_Value(3, 'Race'),
                    new OFC_Charts_Pie_Value(2, 'Peak'),
                    new OFC_Charts_Pie_Value(8, 'Build'),
                    new OFC_Charts_Pie_Value(12, 'Base'),
                    new OFC_Charts_Pie_Value(4, 'Preparation'),
                    new OFC_Charts_Pie_Value(6, 'Transition')
                    );
/**
•	1-3 Wochen Race
•	1-2 Wochen Peak (kann man im Notfall auch kübeln)
•	6-8 Wochen Build
•	8-12 Wochen Base (hier gehts eigentlich erst los)
•	3-4 Wochen Preparation
•	1-6 Wochen Transition (unstrukturiertes Training)
**/

$chart = new OFC_Chart();
$chart->set_title( $title );
$chart->add_element( $pie );


$chart->x_axis = null;

echo $chart->toPrettyString();

$this->js_addon = '';

?>