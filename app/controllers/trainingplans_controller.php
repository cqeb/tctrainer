<?php

class TrainingplansController extends AppController {
	var $name = 'Trainingplans';

	var $uses = array();
	var $useTable = false;
		
	var $helpers = array('Html', 'Form', 'Javascript', 'Time', 'Session', 'Ofc');
	var $components = array('Email', 'Cookie', 'RequestHandler', 'Session', 'Provider');

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
				$usersport = __('Swim',true) . ',' . __('Bike', true) . ',' . __('Run', true);
				break;
			case 'DUATHLON':
				$usersport = __('Bike', true) . ',' . __('Run', true);
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
		
		// fill the info section
		$schedule = $this->Provider->athlete->getSchedule();
		if ($schedule && count($schedule->getRaces()) == 0) {
			$this->set('info', '<div class="statusbox"><p>' . 
			__("You might want to add some competitions to refine your training plan.", true) . 
			'</p><button onclick="javascript:document.location=\'/trainer/competitions/list_competitions\'">' .
			__("Add competition", true) . 
			"</button>
			</div>");
		} else {
			$this->set('info', '<script type="text/javascript">jQuery(".box.info").hide();</script>');
		}
		
		$this->set('advancedFeatures', $this->Provider->athlete->isAdvancedFeatures());
		$this->set('rlth', $this->Provider->athlete->getThreshold());
		$this->set('blth', $this->Provider->athlete->getBikeThreshold());
	}
	
	/**
	 * ajax call for retrieving plans 
	 */
	function get() {
		$this->layout = 'plain';
		if (!isset($_GET["debug"])) {
			Configure::write('debug', 0);
		}
		$html = $this->Provider->getPlan();
		$this->set('plan', $html);
	}
	
	/**
	 * set an average training time via ajax
	 */
	function set_avg() {
		$this->layout = 'plain';
		if ($this->Provider->athlete->setTrainingTime($_POST["time"])) {
			$this->set('res', 'ok');
		} else {
			$this->set('res', 'error');
		}
	}
	
	/**
	 * persist workout settings such as time and ratio to database
	 */ 
	function save_workout_settings() {
		$this->layout = 'plain';
		Configure::write('debug', 0);
		$this->set('data', $this->Provider->saveWorkoutSettings($_POST));
	}
}

?>