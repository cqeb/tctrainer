<?php

class Competition extends AppModel {

	var $name = 'Competition';
        //var $belongsTo = array ('User');

        var $validate = array(
          'name' => array(
                  'notempty' => array(
                             'rule' => 'notEmpty',
                             'required' => true                             
                  ),
          ),
          'competitiondate' => array(
                 'rule' => 'date',
                 'allowEmpty' => false
          ));

}

?>