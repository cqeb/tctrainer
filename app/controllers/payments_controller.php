<?php

/**
do the payment with PAYPAL
**/

class PaymentsController extends AppController {
   var $name = 'Payments';

   var $components = array('Email', 'Cookie', 'RequestHandler', 'Session', 'Recaptcha', 'Unitcalc', 'Transactionhandler', 'Loghandler', 'Rebatehandler', 'Sendmailhandler');
   var $helpers = array('Html', 'Form', 'Javascript', 'Time', 'Session', 'Unitcalc');

   var $paginate = array(
       'Payments' => array(
                'limit' => 15
       )
   );

   function beforeFilter()
   {
	        parent::beforeFilter();
            $this->layout = 'default_trainer';
            $this->js_addon = '';
   }

   function subscribe_triplans()
   {
            $this->checkSession();
            $results['User'] = $this->Session->read('userobject');
            $session_userid = $results['User']['id'];
            $currency = $this->Unitcalc->currency_for_country( $results['User']['country'] );

            // maybe user has not added his country yet.
            if ( !$currency ) $currency = 'EUR';

            $this->set('paid_from', $this->Unitcalc->check_date($results['User']['paid_from']));
            $this->set('paid_to', $this->Unitcalc->check_date($results['User']['paid_to']));
            $this->set('pay_member', $results['User']['level']);
            $this->set('currency', $currency);
            $this->set('statusbox', 'statusbox');
   }

   function unsubscribe_triplans()
   {
            $this->checkSession();

            $results['User'] = $this->Session->read('userobject');
            $session_userid = $results['User']['id'];

            $this->set('paid_from', $this->Unitcalc->check_date($results['User']['paid_from']));
            $this->set('paid_to', $this->Unitcalc->check_date($results['User']['paid_to']));
            $this->set('pay_member', $results['User']['level']);
            $statusbox = 'statusbox';

            if (!empty($this->data))
            {
                       $this->User->id = $session_userid;

                       $this->User->savefield('canceled', true, false);
                       if ( isset( $this->data['Payment']['cancelation_reason'] ) ) $this->User->savefield('cancellation_reason', $this->data['Payment']['cancelation_reason'], false);

                       $statusbox = 'statusbox ok';
                       $this->Session->setFlash(__('Registered cancellation request.', true));

                       // notification mail for admin
                       if ( is_array( $results ) )
                            $user = $results;
                       else
                            $user = array();
                       $array = array();
                       // do not translate
                       $error = 'User ' . $session_userid . ' ' . $results['User']['firstname'] . ' ' . $results['User']['lastname'] . ' canceled membership.';
                       $subject = 'TCT User canceled - bring her/him BACK';

                       $this->_sendNotification($user, $array, $error, $subject);

                       // sad but true - user canceled and now we send her/him to paypal
                       $this->redirect('https://www.paypal.com/cgi-bin/webscr?cmd=_subscr-find&alias=payment@tricoretraining.com');
            }
            $this->set('statusbox', $statusbox);
   }

	/**
	shows the chosen paymentplan by the user
	**/
   function initiate()
   {

            $error = '';
            $tid = '';

            $results['User'] = $this->Session->read('userobject');
            $session_userid = $results['User']['id'];

            // debugging paypal
            if ( 1 == 2 && $_SERVER['HTTP_HOST'] == 'localhost' ) 
            	$testing = 'sandbox.';
			else 
				$testing = '';

            $timeinterval = $this->params['named']['t'];
			
            if ( !$timeinterval ) $timeinterval = 1;
			
			$currency = $this->Unitcalc->currency_for_country($results['User']['country']);
			
			$price_array = $this->Unitcalc->get_prices( null, $currency, $results['User'] );
			$price_array_split = $price_array[$currency]['total'];
			$price_month_array_split = $price_array[$currency]['month'];

           	$price_array = array( '1' => $price_array_split[0], '3' => $price_array_split[1], '6' => $price_array_split[2], '12' => $price_array_split[3] );
            
            // check address in user profile - otherwise redirect to edit profile
            // user has to give us an address for invoice
            if ( !$results['User']['address'] || !$results['User']['zip'] || !$results['User']['city'] || !$results['User']['country'] )
            {
                 $error = 'address';
            } 
			
            $today_ts = time();
            $today = date( 'Y-m-d', $today_ts );
            // calculate how many days the trial period is still active
            // user's paymentplan starts after this period
            $days_to_end = $this->Unitcalc->diff_dates( $today, $results['User']['paid_to'] );

            if ( $days_to_end <= 0 )
            {
               $results['User']['paid_new_from'] = $today;
               $results['User']['paid_new_to'] = date( 'Y-m-d', $today_ts + ( $timeinterval * 31 * 24 * 3600 ) );
               $results['User']['days_to_end'] = 0;
            } else
            {
               $results['User']['paid_new_from'] = $results['User']['paid_to'];
               $results['User']['paid_new_to'] = $this->Unitcalc->date_plus_days( $results['User']['paid_to'], $timeinterval * 31 );
               $results['User']['days_to_end'] = $days_to_end;
            }

            // paypal does not allow trial periods longer than 90 days
            if ( $days_to_end > 90 )
               $error = 'trial';

            $this->loadModel('User');
			$this->User->id = $session_userid;
			$this->data = $this->User->read();

            if ( $error == '' )
            {
               // write all payment information in a transaction
               $this->loadModel('Transaction');
               $tid = $this->Transactionhandler->handle_transaction( $this->Transaction, '', 'create', 'pay_timeinterval', $timeinterval );
               $this->Transactionhandler->handle_transaction( $this->Transaction, $tid, 'add', 'pay_currency', $this->Unitcalc->currency_for_country($results['User']['country']) );
               $this->Transactionhandler->handle_transaction( $this->Transaction, $tid, 'add', 'pay_price', $price_array[$timeinterval]);
               $this->Transactionhandler->handle_transaction( $this->Transaction, $tid, 'add', 'pay_paid_from', $results['User']['paid_from']);
               $this->Transactionhandler->handle_transaction( $this->Transaction, $tid, 'add', 'pay_paid_to', $results['User']['paid_to']);
               $this->Transactionhandler->handle_transaction( $this->Transaction, $tid, 'add', 'pay_paid_new_from', $results['User']['paid_new_from']);
               $this->Transactionhandler->handle_transaction( $this->Transaction, $tid, 'add', 'pay_paid_new_to', $results['User']['paid_new_to']);
               $this->Transactionhandler->handle_transaction( $this->Transaction, $tid, 'add', 'pay_member', $results['User']['level']);
               $this->Transactionhandler->handle_transaction( $this->Transaction, $tid, 'add', 'pay_userid', $session_userid);

               $this->Session->write('pay_transaction_id', $tid);
               $this->set('tid', $tid);
            }
	
			$countries = $this->Unitcalc->get_countries();
            $this->set('timeinterval', $timeinterval);
            $this->set('paid_from', $this->Unitcalc->check_date($results['User']['paid_from']));
            $this->set('paid_to', $this->Unitcalc->check_date($results['User']['paid_to']));
            $this->set('paid_new_from', $this->Unitcalc->check_date($results['User']['paid_new_from']));
            $this->set('paid_new_to', $this->Unitcalc->check_date($results['User']['paid_new_to']));
            $this->set('paid_from_now', $this->Unitcalc->check_date(date('Y-m-d', time())));
            $this->set('level', $results['User']['level']);
            $this->set('testing', $testing);
            $this->set('currency_code', $this->Unitcalc->currency_for_country($results['User']['country']));
            $this->set('price', $price_array[$timeinterval] );
            $this->set('days_to_end', $results['User']['days_to_end'] );
            $this->set('error', $error);
			$this->set('countries', $countries);
			$this->set('userobject', $results['User']);
            //$this->set('invoice', $invoice);
   }

    /**
    we get a remote request from PAYPAL-service and have to handle it
    **/

   function notify()
   {
			// don't check session because paypal is not logged in
			//$this->checkSession();

            // Paypal notifies us through a POST-request
            // $_GET for testing
            if ( $_POST ) 
            	$params = $_POST;
            else 
            	$params = $_GET;

			// just for monitoring purpose
			$logurl = '';
			foreach ( $params as $key => $val )
			{
			           $logurl .= $key . '=' . urlencode($val) . '&';
			}
			
			$posturl = '?cmd=_notify-validate&' . $logurl;
			$logtext = date('Y-m-d H:i:s', time()) . '|' . $params['custom'] . '|' . $_SERVER['REMOTE_ADDR'] . '|' . $posturl . '|' . $_SERVER['REQUEST_URI'] . "\n\n";
			if ( $_SERVER['HTTP_HOST'] != 'localhost' ) mail( 'klaus@tricoretraining.com', 'TCT: paypal.com Request', $logtext, 'From: server@tricoretraining.com' );

			if ( isset( $this->params['named']['lang'] ) )
			{
					$this->code = $this->params['named']['lang']; 				
			} else
			{
					$this->code = 'eng';
			}	 
			//$this->Session->write('Config.language', $this->code);
			Configure::write('Config.language',$this->code);
			
            
            $this->set('js_addon','');
            $error = '';
            $logurl = '';
            $payment_successful = false;

            // have to do this - because checkSession is uncommented
            $this->loadModel('User');

			/*
			 *
			 * http://localhost/trainer/payments/notify/lang:ger/?
			 * cmd=_notify-validate&
			 * mc_gross=0.10&
			 * protection_eligibility=Ineligible&
			 * address_status=unconfirmed&
			 * payer_id=M2H23WE8JBUVE&
			 * address_street=Reisenbauerring+4/2/7&
			 * payment_date=00:18:05+Feb+19,+2011+PST&
			 * payment_status=Completed&
			 * charset=windows-1252&
			 * address_zip=2351&
			 * first_name=Elisabeth&
			 * mc_fee=0.10&
			 * address_country_code=AT&
			 * address_name=Elisabeth+Schremser&
			 * notify_version=3.0&
			 * subscr_id=I-FXMWPPUPB6XL&
			 * custom=3b7abce59212be7f106b925e594645a9&
			 * payer_status=unverified&
			 * business=payment%40tricoretraining.com&
			 * address_country=Austria&
			 * address_city=Wiener+Neudorf&
			 * verify_sign=An5ns1Kso7MWUdW4ErQKJJJ4qi4-ANMPOHq7XE8iQs-5Be4W1wPgg2Do&
			 * payer_email=tri-lisi%40schremser.com&
			 * txn_id=9G0374107E637632S&
			 * payment_type=instant&
			 * last_name=Schremser&
			 * address_state=&
			 * receiver_email=payment%40tricoretraining.com&
			 * payment_fee=&
			 * receiver_id=TGHR6X4FUYYZW&
			 * txn_type=subscr_payment&
			 * item_name=TriCoreTrainingsplan-1m&
			 * mc_currency=EUR&
			 * item_number=tctplan-1m&
			 * residence_country=AT&
			 * transaction_subject=&
			 * payment_gross=
			 *  
			 * 
			 * copy full request of PAYPAL to this documentation
			 * // TODO (B) check whether all types of requests are handled here
			 * txn_type=subscr_payment
			 * txn_type=subscr_signup
			 * txn_type=subscr_cancel
			 * 
			 */
			 
            // this is the payment_transaction_id
            if ( isset( $params['custom'] ) ) 
            	$this->payment_tid = $params['custom'];
            else 
            	$this->payment_tid = '';

            if ( !isset( $this->payment_tid ) || $this->payment_tid == '' )
            {
                      $error = __('No Transaction-ID defined - something is wrong - sorry.') . ' ' . __('Contact our support', true) . ' - <a href="mailto:support@tricoretraining.com">support@tricoretraining.com</a>.';
                      $transactions = array();
            } else
            {
                      // load data from transaction
                      $this->loadModel('Transaction');
                      $transactions = $this->Transactionhandler->handle_transaction( $this->Transaction, $this->payment_tid, 'read' );

                      $p_userid = $transactions['pay_userid'];

                      $results_user = $this->User->findById($p_userid);
                      if ( !is_array( $results_user ) )
                      {
                                 $error .= __('UserID',true) . ' ' . $p_userid . ' ' . __('was not found in database',true) . '.';
                      }
            }

            if ( isset( $params['payment_status'] ) && $this->payment_tid && is_array( $results_user ) )
            {
               // payment of paypal is not confirmed
               if ( $params['payment_status'] != 'Completed' )
               {
                      $error .= __('Your payment is not completed yet',true) . '.';
               } else
               {
                      $payment_successful = true;

                      // TESTING
                      //$posturl = 'https://www.sandbox.paypal.com/cgi-bin/webscr';
                      $posturl = 'https://www.paypal.com/cgi-bin/webscr';

                      // send back the confirmation request to paypal
                      foreach ( $params as $key => $val )
                      {
                              $logurl .= $key . '=' . urlencode($val) . '&';
                      }

                      $posturl = $posturl . '?cmd=_notify-validate&' . $logurl;

                      if ( $_GET['testing'] == 'true' )
                          $return = 'VERIFIED';
                      else
                          $return = implode( "", file( $posturl ) );

					  if ( $_SERVER['HTTP_HOST'] != 'localhost' ) mail( 'klaus@tricoretraining.com', 'TCT: paypal.com Answer', $return . "-" . $p_userid . "\n\n" . $logtext, 'From: server@tricoretraining.com' );

                      if ( $return != 'VERIFIED' || $params['txn_type'] != 'subscr_payment')
                      {
                                  $error .= __('Verification by PAYPAL failed',true) . '.<br /><br /> ' . $posturl . ' ';
                      } else
                      {
                                  $sql = "SELECT MAX(invoice) AS minv FROM payments";
                                  $invoice_results = $this->Payment->query( $sql );

                                  if ( is_array( $invoice_results ) && count( $invoice_results ) > 0 )
                                  {
                                       $invoice_new = $invoice_results[0][0]['minv'] + 1;
                                       $transactions['pay_invoice'] = $invoice_new;
                                  } else
                                  {
                                       $invoice_new = 201010000;
                                  }

                                  $this->data['Payment']['user_id'] = $transactions['pay_userid'];
                                  $this->data['Payment']['invoice'] = $invoice_new;
                                  $this->data['Payment']['timeinterval'] = $transactions['pay_timeinterval'];
                                  $this->data['Payment']['price'] = $transactions['pay_price'];
                                  $this->data['Payment']['currency'] = $transactions['pay_currency'];
                                  $this->data['Payment']['payment_transaction_id'] = $this->payment_tid;
                                  // PAYPAL gave us a positive verification
                                  $this->data['Payment']['payment_confirmed'] = 1;
                                  
                                  // to change !!!
                                  if ( $results_user['User']['level'] == 'freemember' ) 
                                  {
                                  		$this->data['Payment']['paid_from'] = $transactions['pay_paid_new_from'];
                                  		$this->data['Payment']['paid_to'] = $transactions['pay_paid_new_to'];
								  } else
								  {
								  		if ( strtotime( $results_user['User']['paid_to'] ) < time() ) 
								  				$paid_f_new = date( 'Y-m-d', time() );
										else  
												$paid_f_new = $results_user['User']['paid_to'];
												
                                  		$this->data['Payment']['paid_from'] = $transactions['pay_paid_new_from'] = $paid_f_new;
                                  		$this->data['Payment']['paid_to'] = $transactions['pay_paid_new_to'] = date( 'Y-m-d', strtotime($results_user['User']['paid_to'])+31*24*3600*$transactions['pay_timeinterval'] );
										
								  }

                                  if ($this->Payment->save( $this->data, array(
                                              'validate' => true,
                                              'fieldList' => array( 'user_id', 'invoice', 'timeinterval', 'price', 'currency',
                                              'payment_transaction_id', 'payment_confirmed', 'paid_from', 'paid_to'
                                  ))))
                                  {
                                              // change user-model - set new level and period of training
                                              // save single fields
                                              $this->User->id = $transactions['pay_userid'];
                                              
                                              $this->User->savefield('paid_from', $this->data['Payment']['paid_from'], false);
                                              $this->User->savefield('paid_to', $this->data['Payment']['paid_to'], false);

                                              $this->User->savefield('level', 'paymember', false);

                                              $this->_sendInvoice($transactions, 'invoice');
											  
											  // check recommendations / inviter
											  $inviter = $results_user['User']['inviter'];
											  
											  if ( isset( $inviter ) && $inviter != '' && !preg_match( '/@/', $inviter ) )
											  {
											  		// these inviters receive money
											  		if ( preg_match( '/money:/', $inviter ) )
													{

																$admin_user = $this->User->findByEmail( 'klaus@tricoretraining.com' );
																$inviter_user = $this->User->findById( $inviter );

																$subject = __('TriCoreTraining', true) . ' - ' . __('affiliate gets money!', true);
																$template = 'standardmail';
																$content = $results_user['User']['firstname'] . ' ' . $results_user['User']['lastname'] . ' (' . $results_user['User']['id'] . ') ' . __('bought a PREMIUM membership. Thank you.', true);
																$content .= ' ';
																$content .= $inviter_user['User']['firstname'] . ' ' . $inviter_user['User']['lastname'] . ' (' . $inviter_user['User']['id'] . ') ' . __('receives money.', true);
																
																$this->_sendMail( $inviter_user, $subject, $template, $content, $results_user['User']['yourlanguage'], $admin_user['User'] );
													} else
													{
															$inviter_user = $this->User->findById( $inviter );
															$paid_to = $this->Unitcalc->date_plus_days( $inviter_user['User']['paid_to'], 90);
															$this->User->savefield('paid_to', $paid_to, false);

															if ( is_array( $inviter_user ) )
															{
																$subject = __('TriCoreTraining', true) . ' - ' . __('your friend subscribed to a PREMIUM membership!', true);
																$template = 'standardmail';
																$content = __('great', true) . '. ' . $results_user['User']['firstname'] . ' ' . $results_user['User']['lastname'] . ' ' . __('bought a PREMIUM membership.', true);
																$content .= '<br /><br />' . __('You receive 3 month PREMIUM membership as a "Thank you" for FREE.', true);
																
																$this->_sendMail( $inviter_user, $subject, $template, $content, $results_user['User']['yourlanguage'], '' );
																
																$admin_user = $this->User->findByEmail( 'klaus@tricoretraining.com' );

																$subject = __('TriCoreTraining', true) . ' - ' . __('affiliate gets money!', true);
																$template = 'standardmail';
																$content = $results_user['User']['firstname'] . ' ' . $results_user['User']['lastname'] . ' (' . $results_user['User']['id'] . ') ' . __('bought a PREMIUM membership. Thank you.', true);
																$content .= ' ';
																$content .= $inviter_user['User']['firstname'] . ' ' . $inviter_user['User']['lastname'] . ' (' . $inviter_user['User']['id'] . ') ' . __('receives more months.', true);
																
																$this->_sendMail( $inviter_user, $subject, $template, $content, $results_user['User']['yourlanguage'], $admin_user['User'] );
															}

													}
											  }

                                              $this->Session->setFlash(__('Received notification', true) . '. ' . __('Invoice sent', true) . '. ' . __('Thank you', true) . '.');
                                              //$this->redirect(array('action' => '', $this->User->id));
                                  } else
                                  {
                                  		$error	 .= __('Saving of payment status failed',true) . '.';
                                  }
                      }
               }
            } elseif ( $error )
            {
                 // something is wrong
                 if ( is_array( $results_user ) ) $user = $results_user;
                 else $user = array();

                 if ( is_array( $transactions ) ) $array = $transactions;
                 else $transactions = array();

                 // do not translate 
                 $subject = 'TCT Invoice Error - something wrong/not finished in notify/paypal';

                 $this->_sendNotification($user, $array, $error, $subject);
                 $notification_sent = true;

            } else
            {
                 if ( is_array( $transactions ) )
				 {
	                 // only for information purposes - do not create a new invoice
	                 $this->_sendInvoice($transactions, 'info');
				 }
                 $this->Session->setFlash(__('Received notification', true) . '. ' . __('No invoice', true) . '. ' . __('Thank you', true) . '.');
                 //$this->redirect(array('action' => '', $this->User->id));
            }

            $this->set('error', $error);

            if ( $error && !isset( $notification_sent ) )
            {
                 // something is wrong // probably no transaction-id and therefore no user :(
                 if ( is_array( $results_user ) ) $user = $results_user;
                 else $user = array();

                 if ( is_array( $transactions ) ) $array = $transactions;
                 else $transactions = array();

                 $subject = 'TCT Invoice Error - something wrong in notify/paypal';

                 $this->_sendNotification($user, $array, $error, $subject);
            }
   }

   function show_payments()
   {
			// don't check session because paypal is not logged in
			if ( isset( $this->params['named']['lang'] ) )
			{
					$this->code = $this->params['named']['lang']; 				
			} else
			{
					$this->code = 'eng';
			}	 
			$this->Session->write('Config.language', $this->code);

            $this->checkSession();
            $this->set('js_addon','');
            $error = '';
            $action = '';

            if ( isset( $this->params['named']['i'] ) ) $action = $this->params['named']['i'];

            if ( $action == 's' )
            {
               $error = __('Thank you for subscribing for a membership. You receive your invoice as soon as your subscription period starts. ',true);

            } elseif ( $action == 'c' )
            {
               $error = __('You canceled the payment transaction. If this was not intended, do the payment process again. If something else
               is not ok for you', true) . ', ' . '<a href="mailto:support@tricoretraining.com">' . __('contact our support', true) . '</a>';
            }

            $session_userid = $this->Session->read('session_userid');

            if ( $error != "" ) { $this->Session->setFlash($error); }

            $this->paginate = array(
                  'conditions' => array('Payment.user_id = ' => $session_userid, 'Payment.payment_confirmed = ' => 1),
                  'limit' => 15,
                  'order' => array('Payment.invoice' => 'desc')
            );

			$payments = $this->paginate('Payment');
					
            $this->set('payments', $payments);
   }

   function show_invoice($id = null)
   {
            $this->checkSession();
            $this->set('js_addon','');

            $results['User'] = $this->Session->read('userobject');
            $session_userid = $results['User']['id'];

            $error = '';
            $show_invoice = 'yes';

            $this->Payment->id = $id;
            $this->data = $this->Payment->read();
           
            $this->set('error', '');

            $this->set('show_invoice', $show_invoice);
            $this->set('data', $this->data['Payment']);
   }

   function _sendInvoice($pay, $mailtype)
   {
            $User = $this->User->read( null, $pay['pay_userid']);

            $this->set('user', $User);
            $this->set('pay', $pay);

            $this->set('timeinterval', $pay['pay_timeinterval']);
            $this->set('currency', $pay['pay_currency']);
            $this->set('price', $pay['pay_price']);

            if ( $mailtype == 'invoice' )
                           $this->set('invoice', $pay['pay_invoice']);

            $this->set('paid_from', $this->Unitcalc->check_date($pay['pay_paid_from'], 'show', $User['User']['unitdate']));
            $this->set('paid_to', $this->Unitcalc->check_date($pay['pay_paid_to'], 'show', $User['User']['unitdate']));
            $this->set('paid_new_from', $this->Unitcalc->check_date($pay['pay_paid_new_from'], 'show', $User['User']['unitdate']));
            $this->set('paid_new_to', $this->Unitcalc->check_date($pay['pay_paid_new_to'], 'show', $User['User']['unitdate']));
			$this->set('created', $this->Unitcalc->check_date(date('Y-m-d', time()), 'show', $User['User']['unitdate']));
            // that's not possible
            //$this->set('userobject', $this->Session->read('userobject'));

            $this->Email->to = $User['User']['email'];

            if ( $mailtype == 'invoice' )
                           $this->Email->subject = __('TriCoreTraining Invoice',true);
            else
                           $this->Email->subject = __('TriCoreTraining Subscription Info',true);

            $this->Email->replyTo = Configure::read('App.mailFrom');
            $this->Email->from = Configure::read('App.mailFrom');

            if ( $mailtype == 'invoice' )
                    $this->Email->template = 'invoicemail'; // note no '.ctp'
            else
                    $this->Email->template = 'invoiceinfomail'; // note no '.ctp'

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
                                      'host' => $mailHost,
                                      'username'=>$mailUser,
                                      'password'=>$mailPassword,
                                      'client' => 'smtp_helo_hostname'
                                      );
            /* Set delivery method */
            $this->Email->delivery = 'smtp';
            /* Do not pass any args to send() */
            $this->Email->send();

            //pr($this->Email);  
            /* Check for SMTP errors. */
            $this->set('smtperrors', $this->Email->smtpError);
   }

	// ugly duplicated
   function _sendNotification($user, $array, $error, $subject)
   {
         //$this->layout = 'newsletter';
     
         if ( isset( $error ) ) $this->set('error', $error);
         if ( is_array( $array ) ) $this->set('array', $array);
         if ( is_array( $user ) ) $this->set('user', $user);

         $this->Email->to = Configure::read('App.mailAdmin');
         $this->Email->subject = $subject;
         $this->Email->replyTo = Configure::read('App.mailFrom');
         $this->Email->from = Configure::read('App.mailFrom');
         $this->Email->template = 'notification'; // note no '.ctp'
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
              'host' => $mailHost,
              'username'=>$mailUser,
              'password'=>$mailPassword,
              'client' => 'smtp_helo_hostname'
              );
         /* Set delivery method */
         $this->Email->delivery = 'smtp';
         /* Do not pass any args to send() */
         $this->Email->send();

         /* Check for SMTP errors. */
         $this->set('smtperrors', $this->Email->smtpError);

   }

	function _sendMail($user, $subject, $template, $content = '', $language = 'eng', $to_user = '' )
	{
		$debug = false;

   	  	if ( $language ) 
	  		Configure::write('Config.language',$language);
    	
    	if ( isset( $user['User'] ) ) $user = $user['User'];
    
	    if ( !isset($to_user['email']) ) $to_user['email'] = $user['email'];
	    if ( !isset($to_user['email']) ) $to_user['email'] = $user['User']['email'];
	    if ( !isset($to_user['name']) ) $to_user['name'] = $user['firstname'];
	    if ( !isset($to_user['name']) && isset( $user['User'] ) ) $to_user['name'] = $user['User']['firstname'];

		$this->Email->to = $to_user['email'];
		$this->Email->replyTo = Configure::read('App.mailFrom');
		$this->Email->from = Configure::read('App.mailFrom');
		$this->Email->subject = $subject;
    	if ( !isset( $template ) ) $template = 'standardmail';
		
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