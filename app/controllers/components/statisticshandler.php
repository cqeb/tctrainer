<?php

class StatisticshandlerComponent extends Object {
	
   var $helpers = array('Html', 'Form', 'Javascript', 'Time', 'Session', 'Ofc', 'Unitcalc', 'Xls');
   var $components = array('Email', 'Cookie', 'RequestHandler', 'Session', 'Unitcalc');

   var $paginate = array(
       'Trainingstatistic' => array(
                'limit' => 15,
                'order' => array(
                        'Trainingstatistic.date' => 'asc'
                )
       )
   );



}

?>