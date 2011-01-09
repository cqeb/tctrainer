<?php

class UsersController extends AppController {
	var $name = 'Users';

	var $helpers = array('Html', 'Form', 'Javascript', 'Time', 'Session', 'Flowplayer', 'Unitcalc'); // 'TabDisplay',
	var $components = array('Email', 'Cookie', 'RequestHandler', 'Session', 'Recaptcha', 'Unitcalc', 'Transactionhandler', 'Provider');

	var $paginate = array(
       'User' => array(
                'limit' => 15
	     )
	);

	function beforeFilter()
	{
  		parent::beforeFilter();
  		$this->layout = 'default_trainer';
  
  		// necessary for upload
  		// fill with associated array of name, type, size to the corresponding column name
  		$this->FileUpload->fields = array('name'=> 'file_name', 'type' => 'file_type', 'size' => 'file_size');
  
  		// captcha keys
  		$this->Recaptcha->publickey = "6LcW_goAAAAAAHjN9I5AKsOI0dqsWwwkTifVde97";
  		$this->Recaptcha->privatekey = "6LcW_goAAAAAAN3zO8KEcJiWsg9tbQd-0VJ68LPb";
  
  		$this->js_addon = '';
	}

	function index()
	{
      $this->checkSession();
      $this->set('statusbox', 'statubox');    
	}

	function login()
	{
	    if ( $this->Session->read('session_userid') ) 
	    {
	      $this->checkSession();
	      $this->redirect('/trainingplans/view');

	    } else
	    {
		  $this->pageTitle = __('Login', true);
		  $this->set('error', false);

			if ($this->data)
			{
		      $this->User->set( $this->data );
		
		      $this->User->saveAll($this->data, array('validate' => 'only')); 

      		// check submitted email address against database
			$results = $this->User->findByEmail($this->data['User']['email']);

			// is password valid?
			if ( $results && ($results['User']['password'] == md5($this->data['User']['password'])) )
			{
				// has user activated his profile and do WE not have deactivated user
				if ($results['User']['activated'] == 1 && $results['User']['deactivated'] != 1)
				{
					// if you want to stay logged in, we have to write a cookie
					if ( $this->data['User']['remember_me'] )
					{
						$session_timeout = 60*60*24*365;
						$cookie = array();
						$cookie['email'] = $results['User']['email'];
						$cookie['userid'] = $results['User']['id'];

						//Configure::write('Session.timeout', $session_timeout);
						$this->Cookie->write('tct_auth', $cookie, true, '+52 weeks');
					}

					// set "user" session equal to email address
					// user might have a different session from other login
					$this->Session->write('session_useremail', $results['User']['email']);
					$this->Session->write('session_userid', $results['User']['id']);
					$this->set('session_userid', $results['User']['id']);

					// set "last_login" session equal to users last login time
					$results['User']['last_login'] = date("Y-m-d H:i:s");
					$this->Session->write('last_login', $results['User']['last_login']);

					// save last_login date
					//$this->User->save($results);
					//$this->Session->setFlash(__('Logged in. Welcome.', true));
					$this->redirect('/trainingplans/view');
				} else
				{
					// login data is wrong, redirect to login page
					$this->Session->setFlash(__('Not activated yet. Please follow the activation link in the welcome mail.',true));
					$this->redirect('/users/login');
				}
			} else
			{
				// login data is wrong, redirect to login page
				$this->Session->setFlash(__('Wrong or non-existing e-mail or password. Please try again.', true));
        		// You must not redirect otherwise you won't see errors
				//$this->redirect('/users/login');
			}
		}
		}
	}

	function logout()
	{
		$this->pageTitle = __('Logout', true);

		// kill all session information
		$this->Session->del('session_useremail');
		$this->Session->del('session_userid');
		$this->Cookie->del('tct_auth');

		$this->set('session_userid', '');
		$this->set('session_useremail', '');
		$this->set('session_unit', '');
		$this->set('session_unitdate', '');
		$this->set('session_firstname', '');
		$this->set('session_lastname', '');

		// login data is wrong, redirect to login page
		$this->Session->setFlash(__("You're logged out. Bye.",true));
		$this->redirect('/users/login');
	}

	function password_forgotten($id = null)
	{
		$this->pageTitle = __('Password forgotten', true);
		$this->set('transaction_id', '');
		$statusbox = 'statusbox';
		$status = '';

		if ( $this->data )
		{
        $this->User->set( $this->data );
        if ($this->User->saveAll($this->data, array('validate' => 'only'))) {
        } else {
        }
        /**
        if ( !$this->User->validates( array( 'fieldList' => array( 'email' ) ) ) )
        {
            pr($this->User->invalidFields( array( 'fieldList' => array( 'email' ) ) ));
        }
        **/

			// deactivate this if you're working offline
			// captcha checks for your correct entry
			if( !$this->Recaptcha->valid($this->params['form']) )
			{
				$statusbox = 'statusbox error';
				$this->Session->setFlash(__('Sorry Captcha not correct!',true));
				//$this->redirect('/users/password_forgotten');
			}

			if ( $statusbox != 'statusbox error' )
			{
				$results = $this->User->findByEmail($this->data['User']['email']);
				if ( !is_array($results) )
				{
					$statusbox = 'statusbox error';
					$this->Session->setFlash(__('E-mail was not found in database!',true));
				} else
				{
					$statusbox = 'statusbox';
					$status = 'sent';
					$this->_sendPasswordForgotten($results['User']['id']);
					$this->Session->setFlash(__('Click link in e-mail to reset password!',true));
				}
			}
		}
    	$this->layout = 'default_trainer';

		$this->set('statusbox', $statusbox);
		$this->set('status', $status);
	}

	function password_reset()
	{
    $statusbox = 'statusbox';
		$this->pageTitle = __('Password reset',true);

		//$this->email = base64_decode($this->params['named']['email']);
		//$this->userid = base64_decode($this->params['named']['id']);

		// information is saved in transaction
		$this->transaction_id = $this->params['named']['transaction_id'];
		$this->loadModel('Transaction');

		$transactions = $this->Transactionhandler->handle_transaction( $this->Transaction, $this->transaction_id, 'read');
		$this->email = $transactions['forgotten_email'];
		$this->userid = $transactions['forgotten_userid'];

		// after usage - delete transaction information
		$this->Transactionhandler->_delete_transaction( $this->Transaction, $this->transaction_id );

		if ( $this->email )
		{
			$results = $this->User->findByEmail($this->email);

			if (  $this->userid == $results['User']['id'] )
			{
				// create a random password
				$randompassword = rand(111111, 999999);
        		$randompassword_enc = md5( $randompassword );
        
				// save single field to user profile
				$this->User->id = $this->userid;
				$this->User->savefield('password', $randompassword_enc, false);

				// send email with information
				$this->_sendPasswordForgotten($this->userid, $randompassword);
				$this->set('transaction_id', $this->Session->read('forgotten_transaction_id'));

				$this->Session->setFlash(__('Your new password is sent to your e-mail.',true));
			} else
			{
			  	$statusbox = 'statusbox error';
        		$flash_message = __('Something is wrong - sorry.', true) . '<a href="mailto:support@tricoretraining.com">' . __('Contact our support.', true) . '</a>';
				$this->Session->setFlash($flash_message);
			}
		}
    	$this->set('statusbox',$statusbox);
	}

	/**
	 * registration for new users 
	 */
	function register() 
	{
	  
    if ( $this->Session->read('session_userid') ) 
    {
      $this->checkSession();
      $this->redirect('/trainingplans/view');
    }
    
    $this->pageTitle = __('Create your account', true);
    $success = false;
    $statusbox = 'statusbox';
    //$save_fails = 'false';
    
    if (empty($this->data))
    {
      
    } else
    {
      // tells you - user clicked back in browser :(
      $session_register_userid_just_in_case = $this->Session->read('register_userid');

      // check email (if correct and not duplicate) at registration
      if ( $this->data['User']['email'] && $this->data['User']['id'] )
      {
        $checkemail = $this->check_email_function( $this->data['User']['email'], $this->data['User']['id'], true );
      } else
      {
        if ( $session_register_userid_just_in_case != '' )
        {
          // change insert to update statement by setting userid for user-data
          $set_userid = $session_register_userid_just_in_case;
        } else
        {
          $set_userid = null;
        }
        // check email - maybe user already registered with this email
        $checkemail = $this->check_email_function( $this->data['User']['email'], $set_userid, true );
      }

      // checkemail is a hidden field in form which tells the model whether the email is ok or not
      if ( $checkemail == 0 && $this->data['User']['email'] != '' )
      {
        // email is already taken - sorry.
        $this->data['User']['emailcheck'] = "0";
      } else
      {
        $this->data['User']['emailcheck'] = "1";
      }

/**
      // check if password + password-approve field are equal
      if ( $this->data['User']['password'] == $this->data['User']['passwordapprove'] )
      {
           $this->data['User']['passwordcheck'] = "1";
           $save_pw = $this->data['User']['password'];
           $this->data['User']['password'] = md5($this->data['User']['password']);
           
      } else
      {
           $this->data['User']['passwordcheck'] = "0";
      }
**/

        // no chance - you have to get the newsletter
        $this->data['User']['newsletter'] = "1";
        // we do not ask for "where do you know us from?" - for Clemens' sake :)
        $this->data['User']['dayofheaviesttraining'] = 'FRI';

		// locate your country automatically
		$countries = $this->Unitcalc->get_countries();
	
		/*
		https://github.com/fiorix/freegeoip/blob/master/README.rst
		http://freegeoip.net/json/74.200.247.59
		http://freegeoip.net/csv/74.200.247.59
		http://freegeoip.net/xml/74.200.247.59
		*/
		
		if ( $_SERVER['HTTP_HOST'] == 'localhost' )
			$freegeoipurl = 'http://freegeoip.net/json/81.217.23.232';
		else
			$freegeoipurl = 'http://freegeoip.net/json/' . $_SERVER['REMOTE_ADDR'];
			
		$yourlocation = @json_decode( implode( '', file( $freegeoipurl ) ) );
	
		if ( isset( $yourlocation->country_code ) && isset( $countries[$yourlocation->country_code]) && strlen( $yourlocation->country_code ) > 0 )
		{
				$this->data['User']['country'] = $yourlocation->country_code;
				//$this->data['User']['city'] = $yourlocation->city;
		} else
				$this->data['User']['country'] = 'DE';
		
      // yet not implemented
      $this->data['User']['coldestmonth'] = $this->Unitcalc->coldestmonth_for_country('DE');
      $this->data['User']['unit'] = $this->Unitcalc->unit_for_country('DE', 'unit');
      $this->data['User']['unitdate'] = $this->Unitcalc->unit_for_country('DE', 'unitdate');;
      $this->data['User']['yourlanguage'] = $this->Session->read('Config.language');

      $this->data['User']['passwordcheck'] = "1";
      $this->data['User']['publicprofile'] = "0";
      $this->data['User']['publictrainings'] = "0";
      
      if ( $this->data['User']['password'] && strlen($this->data['User']['password']) > 3 ) 
      {
	        $password_unenc = ($this->data['User']['password']);
	        $this->data['User']['password'] = md5( $password_unenc );
      }
      
	  
      if ( isset( $this->data['User']['birthday'] ) )
      {
			$age = $this->Unitcalc->how_old( $this->data['User']['birthday'] );
			
			// default value for weekly hours
			$whrs = 6;
			
			switch ($this->data['User']['typeofsport']) {
				case 'TRIATHLON IRONMAN':
				case 'RUN ULTRA':
				case 'BIKE ULTRA':
					$whrs = 12;
					break;
				case 'TRIATHLON HALFIRONMAN':
				case 'RUN MARATHON':
				case 'DUATHLON MIDDLE':
				case 'BIKE LONG':
					$whrs = 8;
					break;
				case 'TRIATHLON OLYMPIC':
				case 'RUN HALFMARATHON':
				case 'DUATHLON SHORT':
				case 'BIKE MIDDLE':
					$whrs = 6;
					break;
				case 'TRIATHLON SPRINT':
				case 'RUN 10K':
				case 'BIKE SHORT':
					$whrs = 5;
					break;
				default:
					$whrs = 4;
					break;
			}
			$this->data['User']['weeklyhours'] = $whrs;
						
      		// approximations
      		$this->data['User']['lactatethreshold'] = round( ( 220 - $age ) * 0.85 );
      		$this->data['User']['bikelactatethreshold'] = round ( $this->data['User']['lactatethreshold'] * 0.96 );
      		$this->data['User']['maximumheartrate'] = round ( $this->data['User']['lactatethreshold'] / 0.85 );
	  }

      if ( $this->User->save( $this->data, array(
           'validate' => true,
           'fieldList' => array(
               'firstname', 'lastname', 'gender', 'email', 
               'password', 
               'birthday',
               'lactatethreshold', 
               'bikelactatethreshold', 
               'maximumheartrate',
               'typeofsport', 
               'tos',
               'country',
               'passwordcheck', 'emailcheck', 
               'paid_from', 'paid_to',
               'rookie', 'weeklyhours',
               'newsletter', 'coldestmonth', 'dayofheaviesttraining',
               'publicprofile','publictrainings',
               'maximumheartrate', 
               'unit', 'unitdate', 'yourlanguage' 
           ) ) ) )
      {
          // send user with activation link
          $tid = $this->_sendNewUserMail( $this->User->id );

          // write imperial / metric to session and date-format
          $this->Session->write('session_unit', $this->data['User']['unit']);
          $this->Session->write('session_unitdate', $this->data['User']['unitdate']);

          $statusbox = 'statusbox_ok';
          $this->Session->write('register_userid', $this->User->id);

          $this->Session->setFlash(__('Registration finished',true));
          $this->redirect(array('action' => 'register_finish', $this->User->id));
      } else
      {
          if ( isset( $password_unenc ) ) $this->data['User']['password'] = $password_unenc;
          //pr($this->User->invalidFields( ));
      }

      $statusbox = 'statusbox error';
      $this->Session->setFlash(__('Some errors occured',true));
      $this->set('statusbox', $statusbox);
    }

    $this->set('sports', $this->Unitcalc->get_sports());
    $this->set('statusbox', $statusbox);
  }

/**
 * deprecated registration form
 */	
 
/**

  	function add_step1($id = null)
	{
    	die();
    
		$this->pageTitle = __('Registration - Step 1/2',true);
		$statusbox = 'statusbox';

		if (empty($this->data))
		{ } else
		{
			// tells you - user clicked back in browser :(
			$session_register_userid_just_in_case = $this->Session->read('register_userid');

			// check email (if correct and not duplicate) at registration
			if ( $this->data['User']['email'] && $this->data['User']['id'] )
			{
				$checkemail = $this->check_email_function( $this->data['User']['email'], $this->data['User']['id'], true );
			} else
			{
				if ( $session_register_userid_just_in_case != '' )
				{
					// change insert to update statement by setting userid for user-data
					$set_userid = $session_register_userid_just_in_case;
				} else
				{
					$set_userid = null;
				}
				// check email - maybe user already registered with this email
				$checkemail = $this->check_email_function( $this->data['User']['email'], $set_userid, true );
			}

			// checkemail is a hidden field in form which tells the model whether the email is ok or not
			if ( $checkemail == 0 && $this->data['User']['email'] != '' )
			{
				// email is already taken - sorry.
				$this->data['User']['emailcheck'] = "0";
			} else
			{
				$this->data['User']['emailcheck'] = "1";
			}

			// check if password + password-approve field are equal
			if ( $this->data['User']['password'] == $this->data['User']['passwordapprove'] )
      {
			     $this->data['User']['passwordcheck'] = "1";
           $save_pw = $this->data['User']['password'];
           $this->data['User']['password'] = md5($this->data['User']['password']);
           
			} else
			{
			     $this->data['User']['passwordcheck'] = "0";
      }

			// no chance - you have to get the newsletter
			$this->data['User']['newsletter'] = "1";
			// we do not ask for "where do you know us from?" - for Clemens' sake :)

			// save user profile part 1
			if ($this->User->save( $this->data, array(
           'validate' => true,
           'fieldList' => array( 'firstname', 'lastname', 'gender', 'email', 'password', 'birthday',
           'passwordcheck', 'emailcheck', 'newsletter', 'youknowus' )
			) ) )
			{
				$statusbox = 'statusbox_ok';
				$this->Session->write('register_userid', $this->User->id);
				$this->Session->setFlash(__('Step 1. of registration finished',true));
				$this->redirect(array('action' => 'add_step2', $this->User->id));
			} else
			{
			  $this->data['User']['password'] = $save_pw; 
				$statusbox = 'statusbox error';
				$this->Session->setFlash(__('Some errors occured',true));
				$this->set('statusbox', $statusbox);
			}
			//}
		}
		$this->set('statusbox', $statusbox);
	}

	function add_step2($id = null) 
    {
    	die();

		$this->pageTitle = __('Registration - Step 2/2',true);
		$statusbox = 'statusbox ok';

		if (empty($this->data))
		{
			// for security reasons - if somebody wants to hack by changing the userid in request_url
			$session_register_userid = $this->Session->read('register_userid');

			if ( $session_register_userid != $this->User->id )
			{
				$this->Session->setFlash(__("Sorry. Something is wrong. Don't hack other accounts!",true));
				$this->redirect(array('action' => 'add_step1'));
			}

			// read userdata from last form
			$this->data = $User = $this->User->read();

			// you have to preset view-variables - otherwise you get an error
			$this->set('UserID', $this->User->id);
			$this->set('smtperrors', '');

			// loads userdata twice - ramsch :)
			//$User = $this->User->read(null,$this->User->id);
			$birthday = $User['User']['birthday'];

			// calculate age of user
			$age = $this->Unitcalc->how_old( $birthday );
			$this->set('age',$age);

		} else
		{
			$birthday = $this->data['User']['birthday'];
			$age = $this->Unitcalc->how_old( $birthday );

			$this->set('age',$age);

			if ($this->User->save( $this->data, array(
          'validate' => true,
          'fieldList' => array( 
          'typeofsport', 'rookie', 'tos', 'weeklyhours',
          'dayofheaviesttraining', 'maximumheartrate', 'unit', 'unitdate',
          'coldestmonth', 'level', 'paid_from', 'paid_to', 'yourlanguage'
          ) ) ) )
          {
          	//$this->_sendNewUserMail( $this->User->id );
          	// send user with activation link
          	$tid = $this->_sendNewUserMail( $this->User->id );

          	// write imperial / metric to session and date-format
          	$this->Session->write('session_unit', $this->data['User']['unit']);
          	$this->Session->write('session_unitdate', $this->data['User']['unitdate']);

          	$this->Session->setFlash(__('Registration finished. Please click your activation link in your e-mail!',true));
          	$this->redirect(array('action' => 'register_finish', $this->User->id));
          } else
          {
          	$statusbox = 'statusbox error';
          	$this->Session->setFlash(__('Some errors occured',true));
          	$this->set('statusbox', $statusbox);
          }
		}

		$this->set('statusbox', $statusbox);
		$this->set('sports', $this->Unitcalc->get_sports());
	}
**/

	function register_finish($id = null)
	{
		$this->pageTitle = __('Registration - Finished',true);

		if (empty($this->data))
		{
			$this->data = $User = $this->User->read();

			// activation key
			$this->set('transaction_id', $this->Session->read('activation_transaction_id'));

			$this->set('user', $User);
			$this->set('smtperrors', '');

			$this->set('paid_from', $this->Unitcalc->check_date($this->data['User']['paid_from']));
			$this->set('paid_to', $this->Unitcalc->check_date($this->data['User']['paid_to']));

			$session_register_userid = $this->Session->read('register_userid');

			if ( $session_register_userid != $this->User->id )
			{
				$this->Session->setFlash(__("Sorry. Something is wrong. Don't hack other accounts!",true));
				$this->redirect(array('action' => 'add_step1'));
			}
		} else
		{
			// there's no form - this shouldn't happen :)
		}
	}

	/**
	 * quick check if an email-adress is already registered
	 */
	function check_email_available() 
	{
		$this->layout = "plain";
		Configure::write('debug', 0);
		$email = $_POST['email'];
		
		$res = $this->User->findByEmail($email);
		if ($res === false) {
			$response = "ok";
		} else {
			$response = "error";
		}
		
		$this->set('response', $response);
	}
	
	function check_email()
	{
		/**
		 we use this function in several ways (registration, edit data, ajax-request) - that's the reason why it's broken up in 2 functions
		 **/

		$this->layout = "ajaxrequests";
		//$this->render('check_email');
		$autorender = false;

		/**
		 // this is the classic parameter reading of cakephp
		 $check_useremail = $this->params['named']['checkuseremail'];
		 $check_userid = $this->params['named']['checkuserid'];
		**/
		$check_useremail = $_POST['checkuseremail'];
		$check_userid = $_POST['checkuserid'];

		$return = $this->check_email_function( $check_useremail, $check_userid, $autorender );
	}

	function check_email_function($checkuseremail = "", $checkuserid = "", $autorender = false) 
	{
		//Configure::write('debug', 1);
		//$this->render('check_email');
		$usethisemail = "true";
		$shownoerror = "false";
    	$error_msg = "";
    
		// if no userid is set but email
		if ( !$checkuserid && $checkuseremail )
		{
			// check at first registration, is this email already registered?
			$User_entry = $this->User->findByEmail($checkuseremail);

			// yes, this email is already in use
			if ( is_array( $User_entry ) && count( $User_entry ) > 0 )
			{
				if ( $User_entry['User']['email'] == "" ) $usethisemail = "true";
				else $usethisemail = "false";
			}

		} elseif ( $checkuserid && $checkuseremail )
		{
			/**
			 $User = $this->User->find('list',
			 array('conditions' =>
			 array('User.email' => $checkuseremail, 'User.id <>' => $checkuserid ) )
			 );
			 **/

			// check at editing user profile, your profile email is in database, but is this email used by another userid?
			$sql = "SELECT * FROM users WHERE email = '" . $checkuseremail . "' AND id != '" . $checkuserid . "'";
			$User_entries = $this->User->query( $sql );

			// email exists
			if ( is_array( $User_entries ) && count( $User_entries ) > 0 )
			{
				$User_entries['User'] = $User_entries[0]['users'];
				if ( $User_entries['User']['email'] == "" ) $usethisemail = "true";
				else $usethisemail = "false";
			}

			$sql = "SELECT * FROM users WHERE email = '" . $checkuseremail . "' AND id = '" . $checkuserid ."'";
			$User_same = $this->User->query( $sql );

			if ( is_array( $User_same ) && count( $User_same ) > 0 )
			{
				$User_same['User'] = $User_same[0]['users'];
				if ( $User_same['User']['email'] != "" ) $shownoerror = "true";
				else $shownoerror = "false";
			}
		}

		// check whether email format is correct
		if ( !eregi("^[a-z0-9]+([-_\.]?[a-z0-9])+@[a-z0-9]+([-_\.]?[a-z0-9])+\.[a-z]{2,4}$", $checkuseremail ))
		{
			  	$error_msg = '<div class="error-message">';
			  	$error_msg .= __('Sorry, your e-mail is not correct!', true);
		      	/**
		      	$error_msg .= ' ' . $checkuseremail . ' '; 
				$error_msg .= __('is not correct!', true);
		      	**/
		      	$error_msg .= '</div>';
			
				$this->set("emailcheck", $error_msg);
				$this->set("emailcheck_var", "false");
				return 0;

		} else
		{
			// you can not use this email at registration or at profile changes
			if ( $usethisemail == "false" )
			{
		        $error_msg = '<div class="error-message">';
		        $error_msg .= __('Sorry, your e-mail is already registered!', true);
		        //$error_msg .= ' ' . $checkuseremail . ' ';
		        /**
		        $error_msg .= ' ';  
		        $error_msg .= __('is already registered!', true);
		        **/
		        $error_msg .= '</div>';
        
				$this->set("emailcheck", $error_msg);
				$this->set("emailcheck_var", "false");
				return 0;
			} else {
				// that's good, you can use this email at registration
				if ( $shownoerror == "false" )
				{
			          	$error_msg = '<div class="ok-message">';
			          	$error_msg .= __('E-mail is not registered!', true);
			          	$error_msg .= '</div>';
						$error_msg = '';
						$this->set("emailcheck", $error_msg);
				} else
				{
			          $error_msg = '<div class="error-message">';
			          $error_msg .= __('E-mail changed!', true);
			          $error_msg .= '</div>';

					$this->set("emailcheck", $error_msg);
				}
				$this->set("emailcheck_var", "true");
				return 1;
			}
		}
	}

	function activate($id = null)
	{
		$this->pageTitle = __('Registration - Activation',true);

		// load transaction with information about user
		$this->transaction_id = $this->params['named']['transaction_id'];
		//echo $this->transaction_id;
		$this->loadModel('Transaction');
		$transactions = $this->Transactionhandler->handle_transaction( $this->Transaction, $this->transaction_id, 'read');

		// transaction exist
		if ( $transactions['activation_email'] )
		{
			// find email in database
			$results = $this->User->findByEmail($transactions['activation_email']);

			// check whether userid of transaction equals userid in database
			if (  $transactions['activation_userid'] == $results['User']['id'] )
			{
				// save single field
				$this->User->id = $transactions['activation_userid'];
				$this->User->savefield('activated', 1, false);

				$this->Session->setFlash(__('You will receive regularly training schedules from TriCoreTraining.com. Start your sports career.',true));
        
        if ($results['User']['activated'] == 0 && $results['User']['deactivated'] != 1)
        {
          $this->Session->write('session_useremail', $results['User']['email']);
          $this->Session->write('session_userid', $results['User']['id']);
          $this->set('session_userid', $results['User']['id']);

          // set "last_login" session equal to users last login time
          $results['User']['last_login'] = date("Y-m-d H:i:s");
          $this->Session->write('last_login', $results['User']['last_login']);

          // save last_login date
          //$this->User->save($results);
          //$this->Session->setFlash(__('Logged in. Welcome.', true));
          $this->redirect('/trainingplans/view');
        }
			} else
			{
				$this->Session->setFlash( __("Something went wrong - sorry. Maybe you're already activated?", true) . ' ' . __('If not', true) . ', <a href="mailto:support@tricoretraining.com">' . __('contact our support', true) . '.</a>');
			}
		}
	}

	function check_bmi()
	{
		$this->layout = "ajaxrequests";
		Configure::write('debug', 1);

		// check BMI with weight
		$checkweight = $this->Unitcalc->check_weight( $this->Unitcalc->check_decimal( $_POST['checkweight'] ), 'save', 'single' );
		$checkheight = $this->Unitcalc->check_height( $this->Unitcalc->check_decimal( $_POST['checkheight'] ), 'save', 'single' );
		$age = $this->Unitcalc->how_old( $_POST['checkbirthday'] );

		$bmi_return = $this->Unitcalc->calculate_bmi( $checkweight, $checkheight, $age );
		if ( $bmi_return['bmi'] < 60 && $bmi_return['bmi'] > 10 )
		{
			$bmi_message = __("Your BMI is",true) . ' ' . $bmi_return['bmi'] . '. ' . __("Your BMI-check says:",true) . ' ' . $bmi_return['bmi_status'] . ".";
      $class = "statusbox ok";
		} else
		{
			$bmi_message = __('Please check your height and weight again - we got an incorrect BMI', true) . ' ' . $bmi_return['bmi'] . ') - ' . __("thank you", true) . '.';
      $class = "error-message";
		}

		$this->set("bmicheck", '<div class="'.$class.'">' . $bmi_message . '</div>');
	}

	function edit_userinfo()
	{
		$this->checkSession();

		$this->pageTitle = __('Change profile',true);
		$statusbox = 'statusbox';

		$session_userid = $this->Session->read('session_userid');
    	$this->User->id = $session_userid;
    
    	$countries = $this->Unitcalc->get_countries();
    
		if (empty($this->data))
		{
			$this->data = $this->User->read();
			$this->set('UserID', $this->User->id);

		} else
		{

			$this->set('UserID', $this->User->id);
	
			if ($this->User->save( $this->data, array(
		      'validate' => true,
		      'fieldList' => array( 'firstname', 'lastname', 'gender', 'email', 'birthday',
		      'address', 'zip', 'city', 'country', 'phonemobile' ) ) ) )
		      {
		          // we have to change all session info because of email change
		          if ( $this->data['User']['email'] != $this->Session->read('session_useremail') )
		          {
		                $new_email = $this->data['User']['email'];
		                $this->Session->write( 'session_useremail', $new_email );
		                if ( $this->Cookie->read('email') )
		                {
		                      $cookie = array();
		                      $cookie['email'] = $new_email;
		                      $cookie['userid'] = $session_userid;
		                      
		                      $this->Cookie->write('tct_auth', $cookie, true, '+52 weeks');
		                }
		           }
		      	   $statusbox = 'statusbox ok';
		      	   $this->Session->setFlash(__('User profile saved.',true));
		
		      } else
		      {
		      	   $statusbox = 'statusbox error';
		      	   $this->Session->setFlash(__('Some errors occured.',true));
		      }
		}
    	$this->set('countries', $countries);
		$this->set('statusbox', $statusbox);
	}

	function edit_address()
	{
		$this->checkSession();

		$this->pageTitle = __('Change address',true);
		$statusbox = 'statusbox';

		$session_userid = $this->Session->read('session_userid');
    	$this->User->id = $session_userid;
    
    	$countries = $this->Unitcalc->get_countries();
    
		if (empty($this->data))
		{
			$this->data = $this->User->read();
			$this->set('UserID', $this->User->id);

		} else
		{

			$this->set('UserID', $this->User->id);
	
			if ($this->User->save( $this->data, array(
		      'validate' => true,
		      'fieldList' => array( 'address', 'zip', 'city', 'country', 'phonemobile' ) ) ) )
		      {
		      	   	//$statusbox = 'statusbox ok';
		      	   	//$this->Session->setFlash(__('User profile saved.',true));
		      	   	if ( $this->referer() ) 
				   		$this->redirect($this->referer());
	    			else 
	        			$this->redirect(array('controller'=>'payments','action'=>'subscribe_triplans'));
		      } else
		      {
		      	   $statusbox = 'statusbox error';
		      	   $this->Session->setFlash(__('Some errors occured.',true));
		      }
		}
    	$this->set('countries', $countries);
		$this->set('statusbox', $statusbox);
	}

	function edit_traininginfo() 
	{

		$this->pageTitle = __('Change training info',true);

		$this->checkSession();
		$statusbox = 'statusbox';
		$this->User->id = $session_userid = $this->Session->read('session_userid');
		$this->set('unitmetric', $this->Unitcalc->get_unit_metric() );

		if (empty($this->data))	
		{
			$this->data = $this->User->read();
			$this->set('UserID', $this->User->id);
			$this->set('unit', $this->data['User']['unit']);
		} else 
		{
			$this->set('UserID', $this->User->id);
			if ($this->User->save( $this->data, array(
		        'validate' => true,
        		'fieldList' => array(
		        'typeofsport', 'rookie', 
					//'dayofheaviesttraining',
		        'weeklyhours', 'coldestmonth',
		        'publicprofile', 'publictrainings', 
		        'tos', 
		        'lactatethreshold',
		        'bikelactatethreshold'
	        	)))) {
	        	$statusbox = 'statusbox ok';
	        	$this->Session->setFlash(__('Traininginfo saved.', true));
	        	// recalculate time track by updating athlete
	        	$this->Provider->athlete->setTrainingTime(
	        		$this->data['User']['weeklyhours'] * 60
	        	);
	        } else 
	        {
	        	$this->Session->setFlash(__('Some errors occured.', true));
	        	$statusbox = 'statusbox error';
	        }
		}
		$this->set('statusbox', $statusbox);
		$this->set('sports', $this->Unitcalc->get_sports());
	}

	function edit_weight()
	{
		$this->pageTitle = __('Change weight management', true);
		$this->checkSession();
		$this->js_addon = '';
    
		$statusbox = 'statusbox';
		$targetweighterror = '';
    	$additional_message = '';
    
		$session_userid = $this->Session->read('session_userid');
    	$this->User->id = $session_userid;

		if ( empty($this->data) )
		{
    			$this->data = $this->User->read();

    			// convert back to show in form
    			if ( isset( $this->data['User']['height'] ) )
    			       $this->data['User']['height'] = round( $this->Unitcalc->check_height( $this->Unitcalc->check_decimal( $this->data['User']['height'] ), 'show', 'single' ), 2);

    			if ( isset( $this->data['User']['weight'] ) )
    			       $this->data['User']['weight'] = round( $this->Unitcalc->check_weight( $this->Unitcalc->check_decimal( $this->data['User']['weight'] ), 'show', 'single' ), 1);
    			if ( isset( $this->data['User']['targetweight'] ) )
    			       $this->data['User']['targetweight'] = round( $this->Unitcalc->check_weight( $this->Unitcalc->check_decimal( $this->data['User']['targetweight'] ), 'show', 'single' ), 1);
    		
    	} else 
		{
  			// check decimal + convert metric to save
  			if ( isset( $this->data['User']['weight'] ) )
  			       $this->data['User']['weight'] = $this->Unitcalc->check_weight( $this->Unitcalc->check_decimal( $this->data['User']['weight'] ), 'save', 'single' );
  			if ( isset( $this->data['User']['height'] ) )
  			       $this->data['User']['height'] = $this->Unitcalc->check_height( $this->Unitcalc->check_decimal( $this->data['User']['height'] ), 'save', 'single' );
  			if ( isset( $this->data['User']['targetweight'] ) )
  			       $this->data['User']['targetweight'] = $this->Unitcalc->check_weight( $this->Unitcalc->check_decimal( $this->data['User']['targetweight'] ), 'save', 'single' );
  
  			// targetweight is set - calculate maximum loss per month
  			// calculate target weight and date
  			if ( isset( $this->data['User']['targetweight'] ) && $this->data['User']['targetweight'] != 0 )
  			{
  				// calculate time to loose weight
  				$diff_time = $this->Unitcalc->time_from_to( '', $this->data['User']['targetweightdate'] );
  				$diff_weight = $this->data['User']['weight'] - $this->data['User']['targetweight'];
  
  				// future date for lost weight is in the past
  				if ( round($diff_time['months']) <= 0 )
  				{
  					   $targetweighterror = __('Your target weight date is in the past and must be in the future!', true);
  					   $this->data['User']['targetweightcheck'] = 1;
  					   $this->set('targetweighterror', $targetweighterror);
  
  				} elseif ( $diff_weight < 0 )
  				{
  					   $targetweighterror = __("This system won't work if you want to gain weight!", true);
  					   $this->data['User']['targetweightcheck'] = 1;
  					   $this->set('targetweighterror', $targetweighterror);
  
  				} else
  				{
      				  // calculate weight per month
      				  $weight_per_month_kg = $diff_weight / $diff_time['months'];

      				  if ( $weight_per_month_kg < 0 ) $weight_per_month_kg * (-1);

		              $max_weight_per_month = round( $this->Unitcalc->check_weight( 2, 'show', 'single' ), 2 );
					  
		              $weight_per_month_array = $this->Unitcalc->check_weight( $weight_per_month_kg, 'show' );
		              
		              $weight_per_month = round( $weight_per_month_array['amount'], 2);
					  
		              $weight_unit = $weight_per_month_array['unit'];
		              
		              $additional_message = __('You have to loose', true) . ' ' . $weight_per_month .
                      	' ' . $weight_unit . ' ' . __('per month to achieve your goal.', true);
                  
		              // maximum 2 kg per month
		              if ( $weight_per_month_kg > 2 )
		              {
		                    $targetweighterror = __('You should at maximum loose', true) . ' ' .  
		                        $this->Unitcalc->check_weight('2', 'show', 'single') . ' ' . $weight_unit . ' ' . 
		                        __('per month.', true);
		                    $this->data['User']['targetweightcheck'] = 1;
		              } else
		              {
		                    $this->data['User']['targetweightcheck'] = 0;
		              }
      				  $this->set('weight_unit', $weight_unit);
              		  $this->set('targetweighterror', $targetweighterror);
  				}
  
  			} else
  			{
  				  $this->data['User']['targetweightcheck'] = 0;
  			}
  
  			$age = $this->Unitcalc->how_old( $this->data['User']['birthday'] );
  
  			if ( $this->data['User']['weight'] && $this->data['User']['height'] )
  			{
  			   	   $bmi = $this->Unitcalc->calculate_bmi( $this->data['User']['weight'], $this->data['User']['height'], $age );
        	}
        
  			if ( $this->data['User']['targetweight'] == 0 )
        	{
  			       unset( $this->data['User']['targetweight'] );
  			} else
  			{
  				// is your targetweight BMI-compliant :)
  				if ( $this->data['User']['targetweightcheck'] == 0 )
  				{
  					   if ( $this->data['User']['targetweight'] && $this->data['User']['height'] )
  					   {
  					       $targetbmi = $this->Unitcalc->calculate_bmi( $this->data['User']['targetweight'], $this->data['User']['height'], $age );
	  					   if ( $targetbmi['bmi'] < 16 || $targetbmi['bmi'] > 30 )
	  					   {
	          						$targetweighterror = __('Your target weight is not ok. Your goals would bring your BMI to a critical',true) . ' ' . $targetbmi['bmi'];
	          						$this->data['User']['targetweightcheck'] = 1;
	          						$this->set('targetweighterror', $targetweighterror);
	  					   }
					   }
  				}
          /**
          if ( isset( $weight_per_month ) && !isset( $targetweighterror ) )
          {
              $additional_message = 
                    __('You have to loose', true) . 
                    ' ' . $weight_per_month . ' ' . $weight_unit . ' ' . 
                    __('per month to reach your weight goal', true);
          }
          **/
  			}
  
  			if ( $this->User->save( $this->data, 
  			   array(
               'validate' => true,
               'fieldList' => array(
                 'height', 'weight', 'targetweight',
                 'targetweightdate', 'targetweightcheck'
           ) ) ) )
           {
                 $this->Session->setFlash(__('Your settings are saved.',true).' '.$additional_message);
                 $statusbox = 'statusbox ok';
        
                 // convert back in case of error and no redirect
                 if ( isset( $this->data['User']['height'] ) )
                 	    $this->data['User']['height'] = round($this->Unitcalc->check_height( $this->Unitcalc->check_decimal( $this->data['User']['height'] ), 'show', 'single' ), 2);
                 if ( isset( $this->data['User']['weight'] ) )
                      $this->data['User']['weight'] = round($this->Unitcalc->check_weight( $this->Unitcalc->check_decimal( $this->data['User']['weight'] ), 'show', 'single' ), 1);
                 if ( isset( $this->data['User']['targetweight'] ) )
                 	    $this->data['User']['targetweight'] = round($this->Unitcalc->check_weight( $this->Unitcalc->check_decimal( $this->data['User']['targetweight'] ), 'show', 'single' ), 1);
                 //$this->redirect(array('action' => 'edit_weight', $this->User->id));
           
           } else
           {
                 // convert back in case of error
                 if ( isset( $this->data['User']['weight'] ) )
                      $this->data['User']['weight'] = $this->Unitcalc->check_weight( $this->Unitcalc->check_decimal( $this->data['User']['weight'] ), 'show', 'single' );
                 if ( isset( $this->data['User']['height'] ) )
                   	  $this->data['User']['height'] = $this->Unitcalc->check_height( $this->Unitcalc->check_decimal( $this->data['User']['height'] ), 'show', 'single' );
                 if ( isset( $this->data['User']['targetweight'] ) )
                   	  $this->data['User']['targetweight'] = $this->Unitcalc->check_weight( $this->Unitcalc->check_decimal( $this->data['User']['targetweight'] ), 'show', 'single' );
                 $statusbox = 'statusbox error';
                 if ( $targetweighterror )
                    $this->Session->setFlash(__($targetweighterror,true));
                 else
                    $this->Session->setFlash(__('Some errors occured',true));
           }
		}

    $this->set('unit', $this->Unitcalc->get_unit_metric());
		$this->set('statusbox', $statusbox);
		$this->set('targetweighterror', $targetweighterror);
	}

	function edit_images()
	{
		$this->pageTitle = __('Change profile - images',true);
		$this->checkSession();
		$statusbox = 'statusbox';

		$session_userid = $this->Session->read('session_userid');
    	$this->User->id = $session_userid;

		$this->set('unitmetric', $this->Unitcalc->get_unit_metric() );

		if (empty($this->data))
		{
			$this->data = $this->User->read();

			$this->set('UserID', $this->User->id);
			$this->set('unit', $this->data['User']['unit']);
			$this->set('myimage_show', $this->data['User']['myimage']);
			$this->set('mybike_show', $this->data['User']['mybike']);

		} else
		{
			$this->set('UserID', $this->User->id);

			// binary images - upload procedure
			$this->set('myimage_show', $this->data['User']['myimage']);
			$this->set('mybike_show', $this->data['User']['mybike']);

			$myimage_file = $this->data['User']['myimage_upload'];
			if ( $myimage_file['tmp_name'] )
			{
				$userid = $this->User->id;
				$return = $this->_save_file($myimage_file, $userid, "image", "myimage");
				if (!$return['error']) $this->data['User']['myimage'] = $return['destination'];
			}

			$mybike_file = $this->data['User']['mybike_upload'];
			if ( $mybike_file['tmp_name'] )
			{
				$userid = $this->User->id;
				$return = $this->_save_file($mybike_file, $userid, "image", "mybike");
				if (!$return['error'] ) $this->data['User']['mybike'] = $return['destination'];
			}

			if ($this->User->save( $this->data, array(
          'validate' => true,
          'fieldList' => array(
          'myimage', 'mybike',
          'mytrainingsphilosophy'
          ) ) ) )
          {
          	$statusbox = 'statusbox ok';
          	$this->Session->setFlash(__('Image(s) saved.',true));
          	//$this->redirect(array('action' => 'edit_images', $this->User->id));
          } else
          {
          	$this->Session->setFlash(__('Some errors occured.',true));
          	$statusbox = 'statusbox error';
          }
		}
		$this->set('statusbox', $statusbox);
	}
	
	function delete_image($field = 'myimage')
	{
		if ( $this->params['named']['field'] ) $field = $this->params['named']['field'];
		$this->checkSession();
		$session_userid = $this->Session->read('session_userid');
		$this->User->id = $session_userid;
		$this->data = $this->User->read();

		// UPDATE image field
		$this->User->savefield($field, '', false);

		$this->Session->setFlash(__('Image deleted.',true));
		$this->redirect(array('action' => 'edit_images', $this->User->id));
	}

	function edit_metric()
	{
		$this->pageTitle = __('Change profile - metric',true);
		$this->checkSession();
		//$this->js_addon = '';
		$statusbox = 'statusbox';

		$session_userid = $this->Session->read('session_userid');
    $this->User->id = $session_userid;

		if (empty($this->data))
		{
			$this->data = $this->User->read();
			$this->set('UserID', $this->User->id);
			$this->set('user', $this->data['User']);
		} else
		{
			$this->set('UserID', $this->User->id);
			$this->set('user', $this->data['User']);

			//pr($this->data);
		  if ($this->User->save( $this->data, array(
         'validate' => true,
         'fieldList' => array(
         'unit', 'unitdate', 'yourlanguage'
         ) ) ) )
         {
         	$this->Session->setFlash(__('Metric information saved.',true));
         	$this->Session->write('session_unit', $this->data['User']['unit']);
         	$this->Session->write('session_unitdate', $this->data['User']['unitdate']);
         	$statusbox = 'statusbox ok';
         } else
         {
         	$statusbox = 'statusbox error';
         	$this->Session->setFlash(__('Some errors occured.',true));
         }
		}
		$this->set('statusbox', $statusbox);
	}

	function edit_password() 
	{
		$this->pageTitle = __('Change profile - password', true);
		$this->checkSession();
		//$this->js_addon = '';
		$statusbox = 'statusbox';

		$session_userid = $this->Session->read('session_userid');
    	$this->User->id = $session_userid;

		if (empty($this->data))
		{
			$this->data = $this->User->read();
			$this->set('UserID', $this->User->id);
      		$this->data['User']['password'] = '';
      		$this->data['User']['passwordapprove'] = '';
      
		} else
		{
	      $this->User->set($this->data);
	      /**
	      if ($this->User->saveAll($this->data, array('validate' => 'only'))) 
	      { }
	      **/
	      
	      $save_pw = $this->data['User']['password'];
	      
	      if ( !$this->data['User']['password'] || !$this->data['User']['passwordapprove'] ||
	           $this->data['User']['password'] != $this->data['User']['passwordapprove'] )
	      {      
	          $this->set('errormessage', __('No passwords entered or passwords do not match!', true) );
	      } else
	      {
	          $this->data['User']['password'] = md5($this->data['User']['password']);
	          $this->data['User']['passwordcheck'] = 1;
	    
	    			if ($this->User->save( $this->data, array(
	             'validate' => true,
	             'fieldList' => array(
	             'password', 'passwordcheck'
	             ) ) ) )
	             {
	             	  $this->Session->setFlash(__('New password saved.',true));
	             	  $statusbox = 'statusbox ok';
	                $this->data['User']['password'] = '';
	                $this->data['User']['passwordapprove'] = '';
	                
	             } else
	             {
	                $this->data['User']['password'] = $save_pw;
	    
	                //pr($this->User->validationErrors);
	                
	             	  $statusbox = 'statusbox error';
	             	  $this->Session->setFlash(__('Some errors occured.',true));
	             }
	      }
	    }
		$this->set('statusbox', $statusbox);
	}

  	/** protect method by adding _ in front of the name **/
	function _save_file($file, $userid, $type = "image", $addthis = "")
	{
		//$num_args = func_num_args();
		//$arg_list = func_get_args();
 
		$destination = Configure::read('App.uploadDir');
		$weburl = Configure::read('App.serverUrl') . '/files/';

		$unlinkElement = array();
		$type_accepted_images = array("image/jpeg", "image/gif", "image/png");
		$filesize_accepted_images = 200000;

		// none
		$type_accepted_files = array("vnd.ms-excel");
		$filesize_accepted_files = 300000;

		if ( $type == "image" )
		{
			if ( in_array( $file['type'], $type_accepted_images ) )
			{
				if ( $file['size'] < $filesize_accepted_images )
				{
					$new_name = $addthis . '_' . $userid . '_' . $file['name'];
					$destination .= $new_name;
					$weburl .= $new_name;

					if ( move_uploaded_file( $file['tmp_name'], $destination ) )
					{
						//unlink($file['tmp_name']);
						$return['destination'] = $weburl;
						$return['error'] = '';
						return $return;
					}

				} else
				$return['error'] = 'filesize_not_accepted';
      }
     } elseif ( $type == "file")
     {
      if ( in_array( $file['type'], $type_accepted_files ) )
      {
        if ( $file['size'] < $filesize_accepted_files )
        {
          $new_name = $addthis . '_' . $userid . '_' . $file['name'];
          $destination .= $new_name;
          $weburl .= $new_name;

          if ( move_uploaded_file( $file['tmp_name'], $destination ) )
          {
            //unlink($file['tmp_name']);
            $return['destination'] = $weburl;
            $return['error'] = '';
            return $return;
          }
        } else
            $return['error'] = 'filesize_not_accepted';
       
       
       
     } else
			$return['error'] = 'type_not_accepted';
		}
		return $return;
		//$extension = substr($value[0]['name'] , strrpos($value[0]['name'] , '.') +1);
	}

	function _sendNewUserMail($id)
	{
    //$this->layout = 'newsletter';

		$User = $this->User->read(null, $id);
		$this->loadModel('Transaction');

		$tid = $this->Transactionhandler->handle_transaction( $this->Transaction, '', 'create', 'activation_userid', $User['User']['id'] );
		$this->Transactionhandler->handle_transaction( $this->Transaction, $tid, 'add', 'activation_email', $User['User']['email'] );

		/* Check for SMTP errors. */
		//Set view variables as normal
		$this->set('user', $User);
		$this->set('transaction_id', $tid);
		//$this->set('encoded_id', $encoded_id);
		//$this->set('encoded_email', $encoded_email);
		$this->set('smtperrors', $this->Email->smtpError);
		$this->set('mailsend', 'mail sent');

		$this->Email->to = $User['User']['email'];
		//$this->Email->bcc = array('secret@example.com');
		$this->Email->subject = __('TriCoreTraining signup',true);
		$this->Email->replyTo = Configure::read('App.mailFrom');
		$this->Email->from = Configure::read('App.mailFrom');

		$this->Email->template = 'welcomemail'; // note no '.ctp'
		//Send as 'html', 'text' or 'both' (default is 'text')
		$this->Email->sendAs = 'both'; // because we like to send pretty mail
		/* SMTP Options */

		$mailPort = Configure::read('App.mailPort');
		$mailHost = Configure::read('App.mailHost');
		$mailUser = Configure::read('App.mailUser');
		$mailPassword = Configure::read('App.mailPassword');

		$this->Email->smtpOptions = array(
        'port'=>$mailPort,
        'timeout'=>'30',
        'host'=>$mailHost,
        'username'=>$mailUser,
        'password'=>$mailPassword,
        'client'=>'smtp_helo_hostname'
        );
        /* Set delivery method */
        $this->Email->delivery = 'smtp';
        /* Do not pass any args to send() */
        $this->Email->send();

        $this->Session->write('activation_transaction_id', $tid);
        return $tid;
	}

	function _sendPasswordForgotten($id, $randompassword = null)
	{
	  //$this->layout = 'newsletter';
    
		if ( $randompassword )
		{
			$this->template = 'passwordreset';
			$this->set('randompassword',$randompassword);
		} else
		{
			$this->template = 'passwordforgotten';
		}

		$User = $this->User->read(null,$id);

		$this->loadModel('Transaction');

		$tid = $this->Transactionhandler->handle_transaction( $this->Transaction, '', 'create', 'forgotten_userid', $User['User']['id'] );
		$this->Transactionhandler->handle_transaction( $this->Transaction, $tid, 'add', 'forgotten_email', $User['User']['email'] );

		//$encoded_email = base64_encode($User['User']['email']);
		//$encoded_id    = base64_encode($User['User']['id']);

		$this->Email->to = $User['User']['email'];
		$this->Email->subject = __('TriCoreTraining - password forgotten',true);
		$this->Email->replyTo = Configure::read('App.mailFrom');
		$this->Email->from = Configure::read('App.mailFrom');

		//Set view variables as normal
		$this->set('user', $User);
		$this->set('transaction_id', $tid);
		$this->Session->write('forgotten_transaction_id', $tid);

		$this->Email->template = $this->template; // note no '.ctp'
		//Send as 'html', 'text' or 'both' (default is 'text')
		$this->Email->sendAs = 'both'; // because we like to send pretty mail
		/* SMTP Options */
		$mailPort = Configure::read('App.mailPort');
		$mailHost = Configure::read('App.mailHost');
		$mailUser = Configure::read('App.mailUser');
		$mailPassword = Configure::read('App.mailPassword');

		$this->Email->smtpOptions = array(
        'port'=>$mailPort,
        'timeout'=>'30',
        'host'=>$mailHost,
        'username'=>$mailUser,
        'password'=>$mailPassword,
        'client'=>'smtp_helo_hostname'
        );
        /* Set delivery method */
        $this->Email->delivery = 'smtp';
        /* Do not pass any args to send() */
        $this->Email->send();
        /* Check for SMTP errors. */
        $this->set('smtperrors', $this->Email->smtpError);
        $this->set('mailsend', 'mail sent');
	}

	function change_language()
	{
		$this->code = $this->params['named']['code'];

	    if ( $this->Session->read('session_userid') )
	    {
	          $this->User->id = $this->Session->read('session_userid');
	          $this->User->savefield('yourlanguage', $this->code, false);
	    }

		$this->Session->write('Config.language', $this->code);
		$this->Session->setFlash(__('Language changed.',true));

		if ( $this->referer() ) 
		    $this->redirect($this->referer());
	    else 
	        $this->redirect(array('action'=>'index'));

	}

/**
    go through all users (even not activated once) and send notifications
    or make modifications
    * tracked workouts for last 10 days?
    * strange userdata --> notify admin --> or delete
    * script which changes users back to free member
    * check each day if member has subscribed, then change to freemember after validationperiod
**/

	function check_notifications()
	{
	    $this->layout = 'plain';
	    // Sun = 0
	    $check_on_day = 0;
    
		$sql = "SELECT * FROM users";
		$results = $this->User->query($sql);

		for ( $i = 0; $i < count( $results ); $i++ )
		{
			$user = $results[$i]['users'];

      		echo $user['id'] . ' ' . $user['firstname'] . ' ' . $user['lastname'] . '<br /><br />';
      
			// check last training - if older than 10 days - reminder!
			if ( $user['deactivated'] == 0 && $user['activated'] == 1 && ( date('w', time()) == $check_on_day ) && $user['notifications'] != 1 ) 
			         $this->_check_lasttraining( $user );

      		if ( date('w', time()) == $check_on_day )
               $this->_check_more( $user );
              
			if ( $user['level'] == 'freemember' && $user['notifications'] != 1 )
			{
				// if freemember remind him/her of premiumservice
				$paid_to = strtotime( $user['paid_to'] );
        		//echo $user['paid_to'] . ' ' . date('w', time()) . '<br /><br />';
				// from 1 week to end remind user of premium service
				if ( ( time() > ( $paid_to - ( 86400 * 7 ) ) ) && ( date('w', time()) == $check_on_day ) ) 
				{
					$mailsubject = __('My TriCoreTraining coach for the costs of a coffee a week.', true);
					$mailtemplate = 'premiumreminder';
					$this->_sendMail( $user, $mailsubject, $mailtemplate, '', $user['yourlanguage'] );
				}
			}

		}

		$this->loadModel('Transaction');

		// delete old transactions
		$this->Transactionhandler->_delete_old_transactions( $this->Transaction );


	}

  /**
   * when did user last perform a workout?
   */
	function _check_lasttraining( $user )
	{
	  $last_workout_limit = 10; // 10 days 
	  
		$userid = $user['id'];
		$this->loadModel('Trainingstatistic');

		$sql = "SELECT max(date) AS ldate FROM trainingstatistics WHERE user_id = " . $userid;
		$results = $this->Trainingstatistic->query($sql);

		$last_training = strtotime($results[0][0]['ldate']);
		$diff_time = time() - ( 86400 * $last_workout_limit );

		if ( $diff_time > $last_training )
		{
			$mailsubject = __('TriCoreTraining - track you workout - reminder', true);
			$mailtemplate = 'trainingreminder';
			$this->_sendMail( $user, $mailsubject, $mailtemplate, '', $user['yourlanguage'] );
		}
	}

	function _check_more( $user )
	{
      $u = $user;
      $text_for_mail = '';
   
      // check if profile is complete from technical point of view
      $wrong_attributes = "";
      $check_attributes = array( 'firstname', 'lastname', 'gender', 'email', 'emailcheck', 'birthday',
        'password', 'passwordcheck', 'lactatethreshold', 'bikelactatethreshold', 'typeofsport',
        'coldestmonth', 'unit', 'unitdate', 'weeklyhours',
        'dayofheaviesttraining', 'yourlanguage', 'level' );

      foreach ( $check_attributes as $key => $value )
      {
            //echo "check " . $value . "<br />";
            //echo $u[$value] . '<br />';
            if ( $u[$value] == '' ) $wrong_attributes .= $value . '=' . $u[$value] . " <br />\n";
      }
      
      if ( $wrong_attributes != '' ) 
      {
            $to_user['email'] = 'support@tricoretraining.com';
            $to_user['name'] = 'Admin';
            
            $mailsubject = 'Funky TCT user - plz check';
            $mailtemplate = 'standardmail';
            //echo $u['email'] . "<br />";
            //echo $wrong_attributes . '<br />';
            $mailcontent = 'These attributes are not set at the user profile: ' . "\n\n<br /><br />" .  
                'ID=' . $u['id'] . " <br />\n" . 
                'firstname=' . $u['firstname'] . " <br />\n" . 
                'lastname=' . $u['lastname'] . " <br />\n" .
                $wrong_attributes;
            $this->_sendMail( $u, $mailsubject, $mailtemplate, $mailcontent, 'eng', $to_user );
      } 
      //else
      // that's ok - kms
      if ( $user['notifications'] != 1 ) 
      {   
          // check name + address
          if ( !$u['firstname'] ) 
            $text_for_mail .= '<li>' . __('Your firstname is missing!',true) . ' ' . __('Please add it to your profile.', true) .
             " " . '<a href="' . Configure::read('App.hostUrl') . 
             Configure::read('App.serverUrl') . '/users/edit_userinfo" target="_blank">&raquo; ' . 
             __('Change it.', true) . '</a>' . 
            "</li>\n";
    
          if ( !$u['lastname'] ) 
            $text_for_mail .= '<li>' . __('Your lastname is missing!',true) . ' ' . __('Please add it to your profile.', true) . 
             " " . '<a href="' . Configure::read('App.hostUrl') . 
             Configure::read('App.serverUrl') . '/users/edit_userinfo" target="_blank">&raquo; ' . 
             __('Change it.', true) . '</a>' . 
             "</li>\n";
          
          if ( $u['level'] == 'paymember' && !$u['address'] ) 
            $text_for_mail .= '<li>' . __('Your address is missing!',true) . ' ' . __('Please add it to your profile.', true) .
             " " . '<a href="' . Configure::read('App.hostUrl') . 
             Configure::read('App.serverUrl') . '/users/edit_userinfo" target="_blank">&raquo; ' . 
             __('Change it.', true) . '</a>' . 
             "</li>\n";
    
          if ( $u['level'] == 'paymember' && !$u['zip'] ) 
            $text_for_mail .= '<li>' . __('Your zip is missing!',true) . ' ' . __('Please add it to your profile.', true) . 
             " " . '<a href="' . Configure::read('App.hostUrl') . 
             Configure::read('App.serverUrl') . '/users/edit_userinfo" target="_blank">&raquo; ' . 
             __('Change it.', true) . '</a>' . 
             "</li>\n";
    
          if ( $u['level'] == 'paymember' && !$u['city'] ) 
            $text_for_mail .= '<li>' . __('Your city is missing!',true) . ' ' . __('Please add it to your profile.', true) .
             " " . '<a href="' . Configure::read('App.hostUrl') . 
             Configure::read('App.serverUrl') . '/users/edit_userinfo" target="_blank">&raquo; ' . 
             __('Change it.', true) . '</a>' . 
             "</li>\n";
    
          if ( $u['level'] == 'paymember' && !$u['country'] ) 
            $text_for_mail .= '<li>' . __('Your country is missing!',true) . ' ' . __('Please add it to your profile.', true) .
             " " . '<a href="' . Configure::read('App.hostUrl') . 
             Configure::read('App.serverUrl') . '/users/edit_userinfo" target="_blank">&raquo; ' . 
             __('Change it.', true) . '</a>' . 
             "</li>\n";
    
          // check birthday
          if ( !$u['birthday'] ) 
            $text_for_mail .= '<li>' . __('Your birthday is missing! This is essentiell for calculations.', true) . "</li>\n";
          
          // check lactatethreshold
          if ( $u['lactatethreshold'] > 100 && $u['lactatethreshold'] < 210 ) {
            $nothing = "";
          } else {
            $text_for_mail .= '<li>' . __('Your lactate threshold must be between 100 and 210.', true) . 
              " " . '<a href="' . Configure::read('App.hostUrl') . 
              Configure::read('App.serverUrl') . '/users/edit_traininginfo" target="_blank">' . __('Change it.', true) . '</a>' . "</li>\n";
          }

          // check bike lactatethreshold
          if ( $u['bikelactatethreshold'] > 100 && $u['bikelactatethreshold'] < 210 ) {
            $nothing = "";
          } else {
            $text_for_mail .= '<li>' . __('Your bike lactate threshold must be between 100 and 210.', true) . 
              " " . '<a href="' . Configure::read('App.hostUrl') . 
              Configure::read('App.serverUrl') . '/users/edit_traininginfo" target="_blank">' . __('Change it.', true) . '</a>' . "</li>\n";
          }
          
          //echo $u['targetweight']; echo $u['targetweightdate'];
          
          // check for target weight
          if ( $u['targetweight'] && $u['targetweightdate'] )
          {
              $nowts = time();
              $futurets = strtotime( $u['targetweightdate'] );
              
              $diff_weight = ( $u['targetweight'] - $u['weight'] ) * (-1);
              $divisor = ( $futurets - $nowts ) / 86400 / 30;

              // weight you have to loose to achieve your weight target
              $weight_per_month_check = $diff_weight / $divisor;

              if ( $weight_per_month_check > 2 ) 
              {
                  $weight_unit_array = $this->Unitcalc->check_weight(2, 'show');
                  $weight_unit = $weight_unit_array['unit'];

                  $text_for_mail .= '<li>' . __('Your weight loss per month to achieve your weight goal must be', true) . ' ' . 
                      round( $this->Unitcalc->check_weight($weight_per_month_check, 'show', 'single'), 1 ) .
                      ' ' . $weight_unit . ' - ' . __("that's not healthy - set a new weight goal!", true) . ' ' . 
                      " " . '<a href="' . Configure::read('App.hostUrl') . 
                      Configure::read('App.serverUrl') . '/users/edit_weight" target="_blank">' . __('Change it.', true) . '</a>' .
                      "</li>\n";
              } 
          }
        
          // TODO (B) hours per sport          
          if ( !$u['weeklyhours'] ) 
          {
              // check per sport how many hours an user should train
              //case ($u['sports'] )
              //$text_for_mail .= '<li>' . __('You do not train enough for your sport. Please check the recommended training load for your type of sport.', true) . "</li>\n";
              $text_for_mail .= '<li>' . __('You have not entered training hours per week for your sport.', true) . 
              " " . '<a href="' . Configure::read('App.hostUrl') . 
              Configure::read('App.serverUrl') . '/users/edit_traininginfo" target="_blank">' . __('Change it.', true) . '</a>' .
              "</li>\n";
          }
    
          // after 9 month of being rookie
          $rookie_month = 9;

          if ( ( ( strtotime( $u['created'] ) + 86400*30*$rookie_month ) < time() ) && $u['rookie'] == '1' )
          {
              $text_for_mail .= '<li>' . __("You told TriCoreTraining that you're a rookie. Since you're training with TriCoreTraining since more than 9 months, maybe you should change that!", true) .
              " " . '<a href="' . Configure::read('App.hostUrl') . 
              Configure::read('App.serverUrl') . '/users/edit_traininginfo" target="_blank">' . __('Change it.', true) . '</a>' .
              "</li>\n";
          }   

      } 

      // check for recommendations
      // TODO (B) not yet implemented
/**
      if ( !$u['recommendation'] )
      { 
          $text_for_mail .= __('Please recommend our service! Get a free trainingmonth.', true) . '[LINK].', true);
          $text_for_mail .= '<br />';
      }
**/
      
      // check for medical limitations
      if ( $u['tos'] == '0')
      { 
          $text_for_mail .= '<li>' . __("You haven't agreed to our terms and conditions or your medical conditions are not good enough for training. Is that still correct? You want receive training schedules with bad health. Sorry!", true) . 
          " " . '<a href="' . Configure::read('App.hostUrl') . 
          Configure::read('App.serverUrl') . '/users/edit_traininginfo" target="_blank">' . __('Change it.', true) . '</a>' .
          "</li>\n";
      }

      if ( 
        ( ( strtotime( $u['created'] ) + (86400*5) ) < time() ) && 
        ( ( strtotime( $u['created'] ) + (86400*25) ) > time() ) && 
        $u['activated'] != '1' )
      {
          $text_for_mail .= '<li>' . __('Your account is not activated yet. Please use your activation mail to activate your account or contact our support. Thanks.', true) . "</li>\n";
      }   

      if ( ( strtotime( $u['paid_to'] ) < time() ) && $u['level'] != 'freemember' )
      {
          // set level = paymember
          $this->User->id = $u['id'];
          $this->User->savefield('level', 'freemember', false);
          $text_for_mail .= '<li>' . __('Your PREMIUM membership is over. If you want to continue your training with your interactive, online training coach, please', true) . ' ' .
            '<a href="' . Configure::read('App.hostUrl') . Configure::read('App.serverUrl') . '/payments/subscribe_triplans" target="_blank">&raquo; ' . __('subscribe', true) . '</a>' . "</li>\n";
      }

      if ( $text_for_mail )
      {
          $mailsubject = __('TriCoreTraining informs you.', true);
          $template = 'standardmail';
          $content = __('This TriCoreTraining message comes to you because some information in your profile is missing.', true) . 
          '<br />' . '<ol>' . $text_for_mail . '</ol>';
          //echo $content . '<br /><br />';

          $this->_sendMail($u, $mailsubject, $template, $content, $u['yourlanguage']);
      } 
  
	}

	function _sendMail($user, $subject, $template, $content = '', $language = 'eng', $to_user = '' )
	{
	  	if ( $language ) Configure::write('Config.language',$language);
    
    	if ( isset( $user['User'] ) ) $user = $user['User'];
    
	    if ( !isset($to_user['email']) ) $to_user['email'] = $user['email'];
	    if ( !isset($to_user['email']) ) $to_user['email'] = $user['User']['email'];
	    if ( !isset($to_user['name']) ) $to_user['name'] = $user['firstname'];
	    if ( !isset($to_user['name']) && isset( $user['User'] ) ) $to_user['name'] = $user['User']['firstname'];

		$this->Email->to = $to_user['email'];
		$this->Email->replyTo = Configure::read('App.mailFrom');
		$this->Email->from = Configure::read('App.mailFrom');
		$this->Email->subject = $subject;
    
		//Set view variables as normal
		if ( isset( $to_user['name'] ) ) $this->set('to_name', $to_user['name']);
		$this->set('user', $user);
	    //$this->set('content', $content);
	    $this->set('mcontent', $content);

		$this->Email->template = $template; // note no '.ctp'

		//Send as 'html', 'text' or 'both' (default is 'text')
		$this->Email->sendAs = 'both'; // because we like to send pretty mail

		/* SMTP Options */
		$mailPort = Configure::read('App.mailPort');
		$mailHost = Configure::read('App.mailHost');
		$mailUser = Configure::read('App.mailUser');
		$mailPassword = Configure::read('App.mailPassword');

		$this->Email->smtpOptions = array(
        'port'=>$mailPort,
        'timeout'=>'30',
        'host'=>$mailHost,
        'username'=>$mailUser,
        'password'=>$mailPassword,
        'client'=>'smtp_helo_hostname'
        );

	    /* Set delivery method */
	    $this->Email->delivery = 'smtp';
	    /* Do not pass any args to send() */
	    $this->Email->send();
	    /* Check for SMTP errors. */
	    $this->set('smtperrors', $this->Email->smtpError);
	    $this->set('mailsend', 'mail sent');
	
	    // TODO (B) maybe later to prevent spam-suspicion
	    //sleep(5); 
	}
}

?>