<?php

class UsersController extends AppController {
	var $name = 'Users';

	var $helpers = array('Html', 'Form', 'Javascript', 'Time', 'Session', 'Flowplayer', 'Unitcalc'); // 'TabDisplay',
	var $components = array('Email', 'Cookie', 'RequestHandler', 'Session', 'Recaptcha', 'Unitcalc', 'Transactionhandler');

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
      $this->set('statusbox', 'statubox');		
      if ( $this->Session->read('session_userid') ) 
      {
        $this->checkSession();
      }
	}

	function login()
	{
    if ( $this->Session->read('session_userid') ) 
    {
      $this->checkSession();
      $this->redirect('/users/index');
    } else
    {
		  $this->pageTitle = __('Login', true);
		  $this->set('error', false);

		if ($this->data)
		{
      $this->User->set( $this->data );

      if ($this->User->saveAll($this->data, array('validate' => 'only'))) 
      { }

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
						//$session_timeout = 60*60*24*28;
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
					$this->Session->setFlash(__('Logged in. Welcome.', true));
					$this->redirect('/users/index');
				} else
				{
					// login data is wrong, redirect to login page
					$this->Session->setFlash(__('Not activated yet. Please follow the activation link in the welcome mail.',true));
					$this->redirect('/users/login');
				}
			} else
			{
				// login data is wrong, redirect to login page
				$this->Session->setFlash(__('Wrong or non-existing email or password. Please try again.', true));
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
		$this->Session->setFlash(__('You\'re logged out. Bye.',true));
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
				$statusbox = 'errorbox';
				$this->Session->setFlash(__('Sorry Captcha not correct!',true));
				//$this->redirect('/users/password_forgotten');
			}

			if ( $statusbox != 'errorbox' )
			{
				$results = $this->User->findByEmail($this->data['User']['email']);
				if ( !is_array($results) )
				{
					$statusbox = 'errorbox';
					$this->Session->setFlash(__('Email not found in database!',true));
				} else
				{
					$statusbox = 'statusbox';
					$status = 'sent';
					$this->_sendPasswordForgotten($results['User']['id']);
					$this->Session->setFlash(__('Click link in the E-mail to reset password!',true));
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
		$this->Transactionhandler->delete_transaction( $this->Transaction, $this->transaction_id );

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

				$this->Session->setFlash(__('Your new password is sent to your email.',true));
			} else
			{
			  $statusbox = 'errorbox';
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
    $this->pageTitle = __('Create your account', true);
    $success = false;
    $statusbox = 'statusbox_none';
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

      // yet not implemented
      $this->data['User']['coldestmonth'] = $this->UnitCalc->coldestmonth_for_country('DE');
      $this->data['User']['unit'] = $this->UnitCalc->unit_for_country('DE', 'unit');
      $this->data['User']['unitdate'] = $this->UnitCalc->unit_for_country('DE', 'unitdate');;
      $this->data['User']['yourlanguage'] = $this->Session->read('session_userlanguage');

      $this->data['User']['passwordcheck'] = "1";
      $this->data['User']['publicprofile'] = "0";
      $this->data['User']['publictrainings'] = "0";
      
      // approximation - max. heart rate is not in use any more
      $this->data['User']['maximumheartrate'] = $this->data['User']['lactatethreshold'] / 0.85;
      
      /**
      if ($this->User->save($this->data, array(
               'validate' => 'only',
               'fieldList' => array( 
                  $check_array
               )))) { }     
      **/
      
      $password_unenc = ($this->data['User']['password']);
      $this->data['User']['password'] = md5( $password_unenc );
      
      if ( $this->User->save( $this->data, array(
           'validate' => true,
           'fieldList' => array(
               'firstname', 'lastname', 'gender', 'email', 
               'password', 'birthday',
               'lactatethreshold', 
               'maximumheartrate',
               'typeofsport', 
               'medicallimitations',
               'passwordcheck', 'emailcheck', 
               'payed_from', 'payed_to',
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
          $this->data['User']['password'] = $password_unenc ;
          //pr($this->User->invalidFields( ));
      }

      $statusbox = 'errorbox';
      $this->Session->setFlash(__('Some errors occured',true));
      $this->set('statusbox', $statusbox);
    }

    $this->set('sports', $this->Unitcalc->get_sports());
    $this->set('statusbox', $statusbox);
  }

/**
 * deprecated registration form
 */	
 
	function add_step1($id = null)
	{
    die();
    
		$this->pageTitle = __('Registration - Step 1/2',true);
		$statusbox = 'statusbox_none';

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
				$statusbox = 'errorbox';
				$this->Session->setFlash(__('Some errors occured',true));
				$this->set('statusbox', $statusbox);
			}
			//}
		}
		$this->set('statusbox', $statusbox);
	}

	function add_step2($id = null) {
    die();

		$this->pageTitle = __('Registration - Step 2/2',true);
		$statusbox = 'okbox';

		if (empty($this->data))
		{
			// for security reasons - if somebody wants to hack by changing the userid in request_url
			$session_register_userid = $this->Session->read('register_userid');

			if ( $session_register_userid != $this->User->id )
			{
				$this->Session->setFlash(__('Sorry. Something is wrong. Don\'t hack other accounts!',true));
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
          'typeofsport', 'rookie', 'medicallimitations', 'weeklyhours',
          'dayofheaviesttraining', 'maximumheartrate', 'unit', 'unitdate',
          'coldestmonth', 'level', 'payed_from', 'payed_to', 'yourlanguage'
          ) ) ) )
          {
          	//$this->_sendNewUserMail( $this->User->id );
          	// send user with activation link
          	$tid = $this->_sendNewUserMail( $this->User->id );

          	// write imperial / metric to session and date-format
          	$this->Session->write('session_unit', $this->data['User']['unit']);
          	$this->Session->write('session_unitdate', $this->data['User']['unitdate']);

          	$this->Session->setFlash(__('User registration finished. Please click your activation link in your E-mail!',true));
          	$this->redirect(array('action' => 'register_finish', $this->User->id));
          } else
          {
          	$statusbox = 'errorbox';
          	$this->Session->setFlash(__('Some errors occured',true));
          	$this->set('statusbox', $statusbox);
          }
		}

		$this->set('statusbox', $statusbox);
		$this->set('sports', $this->Unitcalc->get_sports());
	}

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

			$this->set('payed_from', $this->Unitcalc->check_date($this->data['User']['payed_from']));
			$this->set('payed_to', $this->Unitcalc->check_date($this->data['User']['payed_to']));

			$session_register_userid = $this->Session->read('register_userid');

			if ( $session_register_userid != $this->User->id )
			{
				$this->Session->setFlash(__('Sorry. Something is wrong. Don\'t hack other accounts!',true));
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
		  $error_msg .= __('Sorry, your E-Mail', true);
      $error_msg .= ' ' . $checkuseremail . ' '; 
		  $error_msg .= __('is not correct!', true);
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
        $error_msg .= __('Sorry, your E-Mail', true);
        //$error_msg .= ' ' . $checkuseremail . ' ';
        $error_msg .= ' ';  
        $error_msg .= __('is already registered!', true);
        $error_msg .= '</div>';
        
				$this->set("emailcheck", $error_msg);
				$this->set("emailcheck_var", "false");
				return 0;
			} else {
				// that's good, you can use this email at registration
				if ( $shownoerror == "false" )
				{
          $error_msg = '<div class="ok-message">';
          $error_msg .= __('GREAT! E-Mail is not registered!', true);
          $error_msg .= '</div>';
          
					$this->set("emailcheck", $error_msg);
				} else
				{
          $error_msg = '<div class="error-message">';
          $error_msg .= __('E-Mail has not changed!', true);
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

				$this->Session->setFlash(__('You will receive regularly trainingplans from TriCoreTraining.com. Start your sports career.',true));
			} else
			{
				$this->Session->setFlash( __('Something went wrong - sorry. Maybe you\'re already activated? If not', true) . ', <a href="mailto:support@tricoretraining.com">' . __('contact our support', true) . '.</a>');
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
		if ( $bmi_return['bmi'] < 50 && $bmi_return['bmi'] > 10 )
		{
			$bmi_message = __("Your BMI is",true) . ' ' . $bmi_return['bmi'] . '. ' . __("Your BMI-check says: ",true) . $bmi_return['bmi_status'] . ".";
      
			$message_color = "green";
		} else
		{
			$bmi_message = __('Please check your height and weight again - we got an incorrect BMI', true) . ' ' . $bmi_return['bmi'] . ') - ' . __("thank you", true) . '.';
			$message_color = "red";
		}

		$this->set("bmicheck", '<div class="error-message" style="color: ' . $message_color . ';">' . $bmi_message . '</div>');
	}

	function edit_userinfo()
	{
		$this->checkSession();

		$this->pageTitle = __('Change profile',true);
		$statusbox = 'statusbox_none';

		$session_userid = $this->Session->read('session_userid');
    $this->User->id = $session_userid;
    
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
      /**'newsletter', 'youknowus',**/
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
      	   $statusbox = 'okbox';
      	   $this->Session->setFlash(__('User info saved.',true));

      } else
      {
      	   $statusbox = 'errorbox';
      	   $this->Session->setFlash(__('Some errors occured.',true));
      }
		}
		$this->set('statusbox', $statusbox);
	}

	function edit_traininginfo()
	{
		$this->pageTitle = __('Change training info',true);

		$this->checkSession();
		//$this->js_addon = '';
		$statusbox = 'statusbox_none';

		$session_userid = $this->Session->read('session_userid');
    $this->User->id = $session_userid;

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
        'publicprofile', 'publictrainings', 'medicallimitations', 'maximumheartrate',
        'lactatethreshold'
        ) ) ) )
        {
        	  $statusbox = 'okbox';
          	$this->Session->setFlash('Trainingsinfo saved.');
        	  //$this->redirect(array('action' => 'edit_traininginfo', $this->User->id));
        } else
        {
        	  $this->Session->setFlash(__('Some errors occured.', true));
        	  $statusbox = 'errorbox';
        }
		}
		$this->set('statusbox', $statusbox);
		$this->set('sports', $this->Unitcalc->get_sports());
	}

	function edit_weight()
	{
		$this->pageTitle = __('Change weight management', true);
		$this->checkSession();
		//$this->js_addon = '';
		$statusbox = 'statusbox_none';
		$targetweighterror = '';
    $additional_message = '';
    
		$session_userid = $this->Session->read('session_userid');
    $this->User->id = $session_userid;

		if (empty($this->data))
		{
			$this->data = $this->User->read();

			// TODO errors in rounding :(
			// convert back to show in form
			if ( isset( $this->data['User']['weight'] ) )
			       $this->data['User']['weight'] = $this->Unitcalc->check_weight( $this->Unitcalc->check_decimal( $this->data['User']['weight'] ), 'show', 'single' );
			if ( isset( $this->data['User']['height'] ) )
			       $this->data['User']['height'] = $this->Unitcalc->check_height( $this->Unitcalc->check_decimal( $this->data['User']['height'] ), 'show', 'single' );
			if ( isset( $this->data['User']['targetweight'] ) )
			       $this->data['User']['targetweight'] = $this->Unitcalc->check_weight( $this->Unitcalc->check_decimal( $this->data['User']['targetweight'] ), 'show', 'single' );
		
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

				} elseif ( $diff_weight < 1 )
				{
					   $targetweighterror = __('Your target weight is too low!', true);
					   $this->data['User']['targetweightcheck'] = 1;
					   $this->set('targetweighterror', $targetweighterror);

				} else
				{
    				// calculate weight per month
    				$weight_per_month = $diff_weight / $diff_time['months'];
            
    				if ( $weight_per_month < 0 ) $weight_per_month * (-1);
    
    				// maximum 2 kg per month
    				if ( $weight_per_month > 2 )
    				      $this->data['User']['targetweightcheck'] = 1;
    				else
    				      $this->data['User']['targetweightcheck'] = 0;
    
    				$max_weight_per_month = $this->Unitcalc->check_weight( 2, 'show', 'single' );
    				$weight_per_month_array = $this->Unitcalc->check_weight( $weight_per_month, 'show' );
            $weight_per_month = $weight_per_month_array['amount'];
    
        		$max_weight_per_month = round( $max_weight_per_month, 2 );
    				$weight_per_month = round( $weight_per_month, 2 );
    				$weight_unit = $weight_per_month_array['unit'];
    
    				$this->set('max_weight_per_month', $max_weight_per_month);
    				$this->set('weight_per_month', $weight_per_month);
    				$this->set('weight_unit', $weight_unit);
				}

			} else
			{
				  $this->data['User']['targetweightcheck'] = 0;
			}

			$age = $this->Unitcalc->how_old( $this->data['User']['birthday'] );

			if ( $this->data['User']['weight'] && $this->data['User']['height'] )
			$bmi = $this->Unitcalc->calculate_bmi( $this->data['User']['weight'], $this->data['User']['height'], $age );

			if ( $this->data['User']['targetweight'] == 0 )
      {
			       unset( $this->data['User']['targetweight'] );
			} else
			{
				// is your targetweight BMI-compliant :)
				if ( $this->data['User']['targetweightcheck'] == 0 )
				{
					   if ( $this->data['User']['targetweight'] && $this->data['User']['height'] )
					   $targetbmi = $this->Unitcalc->calculate_bmi( $this->data['User']['targetweight'], $this->data['User']['height'], $age );
					   if ( $targetbmi['bmi'] < 16 || $targetbmi['bmi'] > 30 )
					   {
        						$targetweighterror = __('Your target weight is not ok. Your goals would bring your BMI to a critical ',true) . $targetbmi['bmi'];
        						$this->data['User']['targetweightcheck'] = 1;
        						$this->set('targetweighterror', $targetweighterror);
					   }
				}
        if ( isset( $weight_per_month ) )
        { 
            $additional_message = 
                  __('You have to loose', true) . 
                  ' ' . $weight_per_month . ' ' . $weight_unit . ' ' . 
                  __('per month to reach your weight goal', true);
        }
			}

			if ($this->User->save( $this->data, array(
         'validate' => true,
         'fieldList' => array(
         'height', 'weight', 'targetweight',
         'targetweightdate', 'targetweightcheck'
         ) ) ) )
         {
         $this->Session->setFlash(__('Weight settings saved.',true).$additional_message);
         $statusbox = 'okbox';

         // convert back in case of error and no redirect
         if ( isset( $this->data['User']['weight'] ) )
              $this->data['User']['weight'] = $this->Unitcalc->check_weight( $this->Unitcalc->check_decimal( $this->data['User']['weight'] ), 'show', 'single' );
         if ( isset( $this->data['User']['height'] ) )
         	    $this->data['User']['height'] = $this->Unitcalc->check_height( $this->Unitcalc->check_decimal( $this->data['User']['height'] ), 'show', 'single' );
         if ( isset( $this->data['User']['targetweight'] ) )
         	    $this->data['User']['targetweight'] = $this->Unitcalc->check_weight( $this->Unitcalc->check_decimal( $this->data['User']['targetweight'] ), 'show', 'single' );
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
               $statusbox = 'errorbox';
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
		$statusbox = 'statusbox_none';

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
          	$statusbox = 'okbox';
          	$this->Session->setFlash(__('Image(s) saved.',true));
          	//$this->redirect(array('action' => 'edit_images', $this->User->id));
          } else
          {
          	$this->Session->setFlash(__('Some errors occured.',true));
          	$statusbox = 'errorbox';
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
		$statusbox = 'statusbox_none';

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

			if ($this->User->save( $this->data, array(
         'validate' => true,
         'fieldList' => array(
         'unit', 'unitdate', 'yourlanguage'
         ) ) ) )
         {
         	$this->Session->setFlash(__('Metric information saved.',true));
         	$this->Session->write('session_unit', $this->data['User']['unit']);
         	$this->Session->write('session_unitdate', $this->data['User']['unitdate']);
         	$statusbox = 'okbox';
         } else
         {
         	$statusbox = 'errorbox';
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
		$statusbox = 'statusbox_none';

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
             	  $statusbox = 'okbox';
                $this->data['User']['password'] = '';
                $this->data['User']['passwordapprove'] = '';
                
             } else
             {
                $this->data['User']['password'] = $save_pw;
    
                //pr($this->User->validationErrors);
                
             	  $statusbox = 'errorbox';
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
		$type_accepted_files = array("");
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
		$this->Email->subject = __('TriCoreTraining.com registration',true);
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
		$this->Email->subject = __('TriCoreTraining (TCT) - Password forgotten',true);
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
		$this->Session->write('Config.language', $this->code);
		$this->Session->setFlash(__('Language changed.',true));
		$this->redirect(array('action'=>'index'));
	}

	function traininghours_calc()
	{


	}

	function check_notifications()
	{
		$sql = "SELECT id, email, lastname, firstname, yourlanguage, level, payed_to FROM users WHERE deactivated = 0 and activated = 1";
		$results = $this->User->query($sql);
		//print_r($results);

		// check trainings
		for ( $i = 0; $i < count( $results ); $i++ )
		{
			$user = $results[$i]['users'];
			// maybe more efficient if you query by AND user_id IN ( ... )
			// check last training - if older than 10 days - reminder!
			$this->check_lasttraining( $user );

			if ( $user['level'] == 'freemember' )
			{
				// if freemember remind him/her of premiumservice
				$payed_to = strtotime( $user['payed_to'] );
				// from 1 week to end remind user of premium service
				if ( time() > ( $payed_to - ( 86400 * 7 ) ) )
				{
					$mailsubject = __('My TCT coach for 30 Cents a day', true);
					$mailtemplate = 'premiumreminder_' . $user['yourlanguage'];
					$this->_sendMail( $user, $mailsubject, $mailtemplate );
				}
			}
		}
	}

	function check_lasttraining( $user )
	{
		$userid = $user['id'];
		$this->loadModel('Trainingstatistic');

		$sql = "SELECT max(date) AS ldate FROM trainingstatistics WHERE user_id = " . $userid;
		$results = $this->Trainingstatistic->query($sql);

		$last_training = strtotime($results[0][0]['ldate']);
		$diff_time = time() - ( 86400 * 10 );

		if ( $diff_time > $last_training )
		{
			$mailsubject = __('TCT Training reminder', true);
			$mailtemplate = 'trainingreminder_' . $user['yourlanguage'];
			$this->_sendMail( $user, $mailsubject, $mailtemplate );
		}
	}

	function check_unfinished_userprofiles()
	{

		/**
		 firstname
		 lastname
		 gender
		 phonemobile
		 address
		 zip
		 city
		 country
		 birthday
		 maximumheartrate
		 lactatethreshold
		 youknowus
		 height
		 weight
		 coldestmonth
		 unit
		 unitdate
		 weeklyhours
		 dayofheaviesttraining
		 yourlanguage
		 myimage
		 mybike
		 **/

		/**
		 $sql = "SELECT * FROM users WHERE email = '" . $checkuseremail . "' AND id != '" . $checkuserid . "'";
		 $User_entries = $this->User->query( $sql );

		 // email exists
		 if ( is_array( $User_entries ) && count( $User_entries ) > 0 )
		 {
		 $User_entries['User'] = $User_entries[0]['users'];
		 if ( $User_entries['User']['email'] == "" ) $usethisemail = "true";
		 else $usethisemail = "false";
		 }
		 **/
	}

	function _sendMail($user, $subject, $template)
	{
		$this->Email->to = $user['email'];
		$this->Email->replyTo = Configure::read('App.mailFrom');
		$this->Email->from = Configure::read('App.mailFrom');
		$this->Email->subject = $subject;

		//Set view variables as normal
		$this->set('user', $user);

		echo $template;

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

	}
}

?>