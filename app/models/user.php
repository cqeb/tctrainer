<?php

class User extends AppModel {
	var $name = 'User';

	//The Associations below have been created with all possible keys, those that are not needed can be removed
	/*
	 var $belongsTo = array(
	 'Group' => array('className' => 'Group',
	 'foreignKey' => 'group_id',
	 'conditions' => '',
	 'fields' => '',
	 'order' => '',
	 'counterCache' => ''),
	 );
	 var $hasMany = array ('Payment','Competition');
	 */

	/*
	 // I18N
	 var $actsAs = array(
	 'Translate'
	 );
	 */

	var $validate = array(
          'firstname' => array(
                  'length' => array(
                           'rule' => array('minLength', '2')
                           //'message' => 'Firstname: Mimimum 2 characters long'
                           ),
                  'notempty' => array(
                           'rule' => 'notEmpty',
                           'required' => true
                           //'message' => 'Enter your firstname, please'
                           ),
                        ),
          'lastname' => array(
                  'length' => array(
                           'rule' => array('minLength', '2')
                           //'message' => 'Lastname: Mimimum 2 characters long'
                           ),
                  'notempty' => array(
                           'rule' => 'notEmpty',
                           'required' => true
                           //'message' => 'Enter your lastname, please'
                           ),
                        ),
          'email' => array(
                  'notempty' => array(
                          'rule' => 'email',
                          'required' => true
                          //'message' => 'Enter your email, please'
                          ),
                        ),
          'emailcheck' => array(
                  'rule' => array('equalTo', '1'),
                  'required' => true
                  //'message' => 'Your email is not correct or is already registered. Use "password forgotten" to retrieve your password!'
                  ),
          'password' => array(
                  'length' => array(
                           'rule' => array('minLength', '4')
                           //'message' => 'Password: Mimimum 4 characters long'
                           ),
                  'notempty' => array(
                             'rule' => 'notEmpty',
                             'required' => true
                             //'message' => 'Enter your password, please'
                             ),
                          ),
          'passwordapprove' => array(
                  'length' => array(
                           'rule' => array('minLength', '4')
                           //'message' => 'Password: Mimimum 4 characters long'
                           ),
                  'notempty' => array(
                             'rule' => 'notEmpty',
                             'required' => true
                             //'message' => 'Enter your password, please'
                             ),
                          ),
          /*
          'passwordcheck' => array(
                   'rule' => array('equalTo', '1'),
                   'required' => true,
                   'message' => 'Your password check does not match!'
                   ),
          */
         'tos' => array(
                  'notempty' => array(
                      'rule' => array('equalTo', '1'),
                      'required' => true
                      //'message' => 'Your password check does not match!'
                   ),
          ),
          'mailingtos' => array(
                'notempty' => array(
                    'rule' => array('equalTo', '1'),
                    'required' => true
                    //'message' => 'Your password check does not match!'
                 ),
        ),
        'healthtos' => array(
                'notempty' => array(
                'rule' => array('equalTo', '1'),
                'required' => true
                //'message' => 'Your password check does not match!'
                ),
        ),          
          'birthday' => array(
                  'rule' => 'date',
                  'allowEmpty' => false
                  //'message' => 'Enter a valid date'
                  ),
          'typeofsport' => array(
                  'notempty' => array(
                             'rule' => 'notEmpty',
                             'required' => true
                             //'message' => 'Enter your weekly available training hours, please'
                  ),
                  ),
          'weeklyhours' => array(
                  'numeric' => array(
                            'rule' => 'numeric'
                            //'message' => 'Please supply the your weekly training hours.'
                            ),
                  'greater' => array(
                            'rule' => array('comparison', '>=', 0)
                            //'message' => 'Must be at least 0 hours'
                            ),
                  'lower' => array(
                            'rule' => array('comparison', '<=', 60)
                            //'message' => 'Must be at lower than 60 hours'
                            ),
                  'notempty' => array(
                             'rule' => 'notEmpty',
                             'required' => true
                             //'message' => 'Enter your weekly available training hours, please'
                             ),
                             ),
          'maximumheartrate' => array(
                  'numeric' => array(
                            'rule' => 'numeric'
                            //'message' => 'Please supply your maximum heart rate (for approx. 220 minus your age).'
                            ),
                  'greater' => array(
                            'rule' => array('comparison', '>=', 120)
                            //'message' => 'Must be at least 120'
                            ),
                  'lower' => array(
                            'rule' => array('comparison', '<=', 220)
                            //'message' => 'Must be at lower than 220'
                            ),
                  'notempty' => array(
                             'rule' => 'notEmpty',
                             'required' => true,
                             //'message' => 'Enter a maximum heart rate, please'
                             ),
                             ),
          'lactatethreshold' => array(
                  'numeric' => array(
                            'rule' => 'numeric'
                            //'message' => 'Please supply your lactate threshold from testworkouts in your schedule.'
                            ),
                  'greater' => array(
                            'rule' => array('comparison', '>=', 120)
                            //'message' => 'Must be at least 120'
                            ),
                  'lower' => array(
                            'rule' => array('comparison', '<=', 220)
                            //'message' => 'Must be at lower than 220'
                            ),
                  'notempty' => array(
                             'rule' => 'notEmpty',
                             'required' => true
                             //'message' => 'Enter a lactate threshold, please (get it from your testworkouts - for approx. take 85% of your maximum heart rate).'
                             ),
                             ),
          'bikelactatethreshold' => array(
                  'numeric' => array(
                            'rule' => 'numeric'
                            ),
                  'greater' => array(
                            'rule' => array('comparison', '>=', 120)
                            ),
                  'lower' => array(
                            'rule' => array('comparison', '<=', 220)
                            ),
                  'notempty' => array(
                             'rule' => 'notEmpty',
                             'required' => true
                             ),
                             ),
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
                  'notempty' => array(
                             'rule' => 'notEmpty',
                             'required' => true
                             //'message' => 'Enter your current weight, please'
                             ),
                             ),
          'height' => array(
                  'numeric' => array(
                            'rule' => 'numeric'
                            //'message' => 'Please enter your height.'
                            ),
                  'greater' => array(
                            'rule' => array('comparison', '>=', 100)
                            //'message' => 'Must be at least 100 centimeters'
                            ),
                  'lower' => array(
                            'rule' => array('comparison', '<=', 230)
                            //'message' => 'Must be at lower than 230 centimeters'
                            ),
                  'notempty' => array(
                             'rule' => 'notEmpty',
                             'required' => true
                             //'message' => 'Enter your height'
                             ),
                             ),
          'targetweight' => array(
                  'numeric' => array(
                            'rule' => 'numeric'
                            //'message' => 'Please supply target current weight.'
                            ),
                  'greater' => array(
                            'rule' => array('comparison', '>=', 40)
                            //'message' => 'Must be at least 40 kilograms.'
                            ),
                  'lower' => array(
                            'rule' => array('comparison', '<=', 150)
                            //'message' => 'Must be at lower than 150 kilograms.'
                            )
                            ),
          'targetweightcheck' => array(
                   'rule' => array('comparison', '<', 1),
                   'required' => true
                   //'message' => "Error: You should only lose 2 kg per month (maximum)."
                   )
	);

	function checkcorrectness($check, $data){
    	return true;
    }
}

?>