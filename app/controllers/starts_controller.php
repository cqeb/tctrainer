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

      if ( $this->Session->read('session_userid') )
            $this->redirect('/users/index');
      
      $this->pageTitle = __('the interactive, online training plan service for run, bike and triathlon athletes ', true);

      if ( isset( $this->params['named'] ) ) 
      {
          if ( isset( $this->params['named']['distance'] ) ) $distance = $this->params['named']['distance'];
          else $distance = '';
          if ( isset( $this->params['named']['distance_unit'] ) ) $distance_unit = $this->params['named']['distance_unit'];
          else $distance_unit = '';
          if ( isset( $this->params['named']['duration'] ) ) $duration = $this->params['named']['duration'];
          else $duration = '';
          if ( isset( $this->params['named']['stype'] ) ) $stype = $this->params['named']['stype'];
          else $stype = '';
    
          $this->set('distance', $distance);
          $this->set('distance_unit', $distance_unit);
          $this->set('duration', $duration);
          $this->set('stype', $stype);
      }      
	}
  
  function error404()
  {
    $this->layout = 'default_trainer';
  }
  
  function features()
  {
    $this->layout = 'default_trainer';

  }

  function fill_my_database()
  {
      $this->checkSession();
      
      $this->autoRender = false;            
      $this->Filldatabase->prefill($this->Start);      
  }
}
?>
