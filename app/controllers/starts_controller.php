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

	}
  
  function fill_my_database()
  {
      $this->autoRender = false;            
      $this->Filldatabase->prefill($this->Start);      

    
    
  }

}
?>