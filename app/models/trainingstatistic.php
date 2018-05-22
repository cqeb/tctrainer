<?php

class Trainingstatistic extends AppModel {

        var $name = 'Trainingstatistic';
        //var $belongsTo = array ('User');

        var $validate = array(
          'date' => array(
                  'notempty' => array(
                             'rule' => 'notEmpty',
                             'required' => true
                  ),
          ),
          'sportstype' => array(
                  'notempty' => array(
                             'rule' => 'notEmpty',
                             'required' => true
                  ),
          ),
          'distance' => array(
                  'numeric' => array(
                            'rule' => 'numeric'
                            ),
                  'notempty' => array(
                             'rule' => 'notEmpty',
                             'required' => true
                  ),
          ),
          'duration' => array(
                  'notempty' => array(
                             'rule' => 'notEmpty',
                             'required' => true
                  ),
                  'greater' => array(
                            'rule' => array('comparison', '>', 0)
                            ),
          ),
          /*
          'weight' => array(
                  'numeric' => array(
                            'rule' => 'numeric'
                            //'message' => 'Please supply your current weight.'
                            ),
                  'greater' => array(
                            'rule' => array('comparison', '>=', 40)
                            //'message' => 'Must be at least 40 kilograms.'
                            ),
                  'lower' => array(
                            'rule' => array('comparison', '<=', 150)
                            //'message' => 'Must be lower than 150 kilograms.'
                            ),
          ),
          */
          'avg_pulse' => array( // should be avgHR
                  'numeric' => array(
                            'rule' => 'numeric'
                            ),
                  'notempty' => array(
                            'rule' => 'notEmpty',
                            'required' => true
                            ),
                  'greater' => array(
                            'rule' => array('comparison', '>=', 80)
                            ),
                  'lower' => array(
                            'rule' => array('comparison', '<=', 240)
                            ),
          ));

}

?>