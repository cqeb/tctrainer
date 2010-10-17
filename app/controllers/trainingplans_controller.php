<?php

class TrainingplansController extends AppController {
	var $name = 'Trainingplans';

	var $helpers = array('Html', 'Form', 'Javascript', 'Time', 'Session', 'Ofc');
	var $components = array('Email', 'Cookie', 'RequestHandler', 'Session', 'Provider');

	var $paginate = array(
       'Trainingplan' => array(
                'limit' => 15
	)
	);

	function beforeFilter()
	{
		parent::beforeFilter();
		$this->layout = 'trainingplans';
		$this->checkSession();

	}

	// view your training plan
	function view() {
		$week = new DateInterval("P7D");

		if (isset($_GET['d'])) {
			$now = $_GET['d'];
			$prev = new DateTime($_GET['d']);
			$next = new DateTime($_GET['d']);
		} else {
			$now = new DateTime();
			$now = $now->format("Y-m-d");
			$next = DateTimeHelper::getWeekStartDay(new DateTime());
			$prev = DateTimeHelper::getWeekStartDay(new DateTime());
		}
		
		$prev->sub($week);
		$next->add($week);
		
		$u = $this->Session->read('userobject');
		$usersport = '';
		// build list of user sports
		switch ($this->Provider->getMultisportType($u['typeofsport'])) {
			case 'TRIATHLON':
				$usersport = __('Swim,Bike,Run', true);
				break;
			case 'DUATHLON':
				$usersport = __('Bike,Run', true);
				break;
			case 'RUN':
				$usersport = __('Run', true);
				break;
			case 'BIKE':
				$usersport = __('Bike', true);
				break;
			default:
				throw new Exception('Unkown user sport ' . $u['typeofsport']);
				break;
		}
		$this->set('usersport', $usersport);
		$this->set('weeklyhours', $u['weeklyhours']);
		$this->set('rightcol', $this->Provider->renderMesoCycle($now, $u["id"]));
	}
	
	// ajax call for retrieving plans
	function get() {
		$this->layout = 'plain';
		if (!isset($_GET["debug"])) {
			Configure::write('debug', 0);
		}
		$html = $this->Provider->getPlan();
		$this->set('plan', $html);
	}
	
	// persist workout settings such as time and ratio to database
	function save_workout_settings() {
		$this->layout = 'plain';
		Configure::write('debug', 0);
		$this->set('data', $this->Provider->saveWorkoutSettings($_POST));
	}
}

?>