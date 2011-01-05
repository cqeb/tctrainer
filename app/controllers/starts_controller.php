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
		if (array_key_exists('distance', $this->params['named'])) {
      		$this->set('distance', $this->params['named']['distance']);
      		$this->set('distance_unit', $this->params['named']['distance_unit']);
      		$this->set('duration', $this->params['named']['duration']);
      		$this->set('stype', $this->params['named']['stype']);
	  	}
      
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