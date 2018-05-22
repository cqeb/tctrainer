<?php

class TrainingplansController extends AppController {

	var $name = 'Trainingplans';

	var $uses = array();
	var $useTable = false;
		
	var $helpers = array('Html', 'Form', 'Javascript', 'Time', 'Session');
	var $components = array('Email', 'Cookie', 'RequestHandler', 'Provider', 'Session','Transactionhandler');

	function beforeFilter() {
		parent::beforeFilter();
		$this->layout = 'trainingplans';
	}

	// view your training plan
	function view() {

        $this->checkSession();

		$week = new DateInterval("P7D");
		$timezone = new DateTimeZone('UTC');

		if (isset($_GET['d'])) {
			$now = $_GET['d'];
			$prev = new DateTime($_GET['d'], $timezone);
			$next = new DateTime($_GET['d'], $timezone);
		} else {
			$now = new DateTime('now',$timezone);
			$now = $now->format("Y-m-d H:i");
			$next = DateTimeHelper::getWeekStartDay(new DateTime('now',$timezone));
			$prev = DateTimeHelper::getWeekStartDay(new DateTime('now',$timezone));
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
		$schedule = $this->Provider->getAthlete()->getSchedule();

		if ($schedule && count($schedule->getRaces()) == 0) {
			$this->set('info', '<div class="alert"><p>' . 
			__("You might want to add some competitions to refine your training plan.", true) . 
			'</p><button onclick="javascript:document.location=\'/trainer/competitions/list_competitions\'">' .
			__("Add competition", true) . 
			"</button>
			</div>");
		} else {
			$this->set('info', '<script type="text/javascript">jQuery(".box.info").hide();</script>');
		}
		
		$this->set('advancedFeatures', $this->Provider->getAthlete()->isAdvancedFeatures());
		$this->set('rlth', $this->Provider->getAthlete()->getThreshold());
		$this->set('blth', $this->Provider->getAthlete()->getBikeThreshold());
		
		$this->set('mesocycles', $this->Provider->renderMesoCycle($now, $u["id"]));
	}
	
	/**
	 * ajax call for retrieving plans 
	 */
	function get() {

        $this->checkSession();

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

        $this->checkSession();

		$this->layout = 'plain';
		if ($this->Provider->getAthlete()->setTrainingTime($_POST["time"])) {
			$this->set('res', 'ok');
		} else {
			$this->set('res', 'error');
		}
	}
	
	/**
	 * calculate the TRIMP for a workout
	 * requires get parameters sport (like BIKE, RUN), time (in minutes) and hr (average heart rate)
	 */
	function calc_trimp() {

        $this->checkSession();

		$this->layout = 'plain';
		Configure::write('debug', 0);
		$this->set('res',
			$this->Provider->getAthlete()->calcTRIMP(
				$_GET['sport'], $_GET['time'], $_GET['hr']
			)
		);
	}
	
	/**
	 * persist workout settings such as time and ratio to database
	 */ 
	function save_workout_settings() {

        $this->checkSession();

		$this->layout = 'plain';
		Configure::write('debug', 0);
		$this->set('data', $this->Provider->saveWorkoutSettings($_POST));
	}

	/**
	 * get workouts as events for your calendar
	 */ 
	function get_events() {

		// do not check
        //$this->checkSession();		

		if ( !isset( $_GET['key'] ) )
			$this->checkSession();
		else {
			if ( $_GET['key'] == $this->Transactionhandler->_encrypt_data( $_GET['athlete_id'] ) ) {
				$this->loadModel('User');
		        $results = $this->User->findById( $_GET['athlete_id'] );
		        $user_object = $results['User'];
		        $this->Session->write('userobject', $user_object);
		    } else
		    	$this->checkSession();
		}

		$this->layout = 'plain';

		Configure::write('debug', 0);
		if ( $this->Provider ) {
			$this->Provider->getPlan(false);
		} else
			echo "ERROR: no Provider set.";
	}

	/**
	 * check former training plans whether they exist
	 */ 	
	function check_trainingplans() {

		// secure access
		if ( $_SERVER['REMOTE_ADDR'] != '::1' && $_SERVER['REMOTE_ADDR'] != '127.0.0.1' && $_SERVER['REMOTE_ADDR'] != '78.142.159.226' && isset( $_GET['access'] ) && $_GET['access'] != 'mikau2345$' ) 
					die('No access!');
				
		$_SESSION = array();
		$this->Session->destroy();
		$this->layout = 'plain';
		Configure::write('Session.start', false);
		$debug = true;

		$start = 0;

		$sql = "SELECT * FROM users ORDER BY id";

		// DEBUG
		if ( isset( $_GET['debug'] ) ) $sql .= " LIMIT 1";
		//print_r($this->User);
		$users_results = $this->User->query($sql);

		$count_results = count( $users_results );

		//if ( isset( $_GET['end'] ) && $_GET['end'] < $count_results ) $count_results = $_GET['end'];
			
		for ( $i = $start; $i < $count_results; $i++ )
		{
			$user = $users_results[$i]['users'];

			$this->Provider->checkPlanForUser( $user );
		}
	}


}

?>
