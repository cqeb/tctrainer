<?php

class StartsController extends AppController {
	var $name = 'Starts';
	// use no model
	//var $uses = null;
	var $useTable = false;

	var $helpers = array('Html', 'Form', 'Javascript', 'Time', 'Session'); // 'TabDisplay',
	var $components = array('Cookie', 'RequestHandler', 'Session', 'Unitcalc', 'Filldatabase');

	var $paginate = array(
       'User' => array(
                'limit' => 15
	)
	);

	function beforeFilter()
	{
		parent::beforeFilter();
		$this->layout = 'trainer_start';
	}

	function index()
	{

      $distance = $this->params['named']['distance'];
      $distance_unit = $this->params['named']['distance_unit'];
      $duration = $this->params['named']['duration'];
      $stype = $this->params['named']['stype'];

      $this->set('distance', $distance);
      $this->set('distance_unit', $distance_unit);
      $this->set('duration', $duration);
      $this->set('stype', $stype);
      
	}
  
  function features()
  {
    $this->layout = 'default_trainer';

  }

  function fill_my_database()
  {
      $this->autoRender = false;            
      $this->Filldatabase->prefill($this->Start);      
  }

}
?>