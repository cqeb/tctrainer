<?php

/**
do the payment with PAYPAL
**/

class PaymentsController extends AppController {
   var $name = 'Payments';

   var $helpers = array('Html', 'Form', 'Javascript', 'Time', 'Session', 'Unitcalc'); // 'TabDisplay',
   var $components = array('Email', 'Cookie', 'RequestHandler', 'Session', 'Recaptcha', 'Unitcalc', 'Transactionhandler', 'Loghandler');

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
            //$this->js_addon = '';

            //$this->loadModel('User');
            //$session_userid = $this->Session->read('session_userid');
            //$results = $this->User->findById($session_userid);
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
                       $this->User->savefield('cancellation_reason', $this->data['Payment']['cancelation_reason'], false);

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

   function initiate()
   {
            /**
            shows the chosen paymentplan by the user
            **/

            //$this->layout = 'ajaxrequests';
            $this->checkSession();
            //$this->js_addon = '';
            $error = '';
            $tid = '';

            $results['User'] = $this->Session->read('userobject');
            $session_userid = $results['User']['id'];

            // debugging paypal
            $testing = 'sandbox.';
            $testing = '';

            $timeinterval = $this->params['named']['t'];
            if ( !$timeinterval ) $timeinterval = 1;

            if ( $_SERVER['HTTP_HOST'] == 'localhost' )
            {
            	$price_array = array( '1' => '0.10', '3' => '0.30', '6' => '0.60', '12' => '1.20' );
            } else
			{
	            if ( $this->Unitcalc->currency_for_country($results['User']['country']) == 'USD' )
	            {
	              $price_array = array( '1' => '14.90', '3' => '39.90', '6' => '74.90', '12' => '139.90' );
	            } else 
	            {
	              $price_array = array( '1' => '9.90', '3' => '26.90', '6' => '49.90', '12' => '94.90' );
	            }
			}
            
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
            //$this->set('invoice', $invoice);
   }

   function notify()
   {
            /**
            we get a remote request from PAYPAL-service and have to handle it
            **/

            // checkSession - won't work with paypal request
            //$this->checkSession();
            $this->set('js_addon','');
            $error = '';
            $logurl = '';
            $payment_successful = false;

            // have to do this - because checkSession is uncommented
            $this->loadModel('User');

            // Paypal notifies us through a POST-request
            // $_GET for testing
            if ( $_POST ) $params = $_POST;
            else $params = $_GET;

            // this is the payment_transaction_id
            if ( isset( $params['custom'] ) ) $this->payment_tid = $params['custom'];
            else $this->payment_tid = '';

            if ( !$this->payment_tid )
            {
                      $error = __('No Transaction-ID defined - something is wrong - sorry.') . ' ' . __('Contact our support', true) . ' - <a href="mailto:support@tricoretraining.com">support@tricoretraining.com</a>.';
                      $transactions = array();
            } else
            {
                      // load data from transaction
                      $this->loadModel('Transaction');
                      $transactions = $this->Transactionhandler->handle_transaction( $this->Transaction, $this->payment_tid, 'read' );

                      $session_userid = $transactions['pay_userid'];

                      $results_user = $this->User->findById($session_userid);
                      if ( !is_array( $results_user ) )
                      {
                                 $error .= __('UserID',true) . ' ' . $session_userid . ' ' . __('was not found in database',true) . '.';
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
                      //$return = $this->do_post_request($posturl, $params, $optional_headers = null);
                      //$logurl = implode( '&', $params );
                      if ( $_GET['testing'] == 'true' )
                          $return = 'VERIFIED';
                      else
                          $return = implode( "", file( $posturl ) );

                      if ( $return != 'VERIFIED' )
                      {
                                  $error .= __('Verification by PAYPAL failed',true) . '. ' . $posturl . ' ';
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
                                  // this days PAYPAL gave us a positive verification
                                  $this->data['Payment']['payment_confirmed'] = 1;
                                  $this->data['Payment']['paid_from'] = $transactions['pay_paid_new_from'];
                                  $this->data['Payment']['paid_to'] = $transactions['pay_paid_new_to'];

                                  if ($this->Payment->save( $this->data, array(
                                              'validate' => true,
                                              'fieldList' => array( 'user_id', 'invoice', 'timeinterval', 'price', 'currency',
                                              'payment_transaction_id', 'payment_confirmed', 'paid_from', 'paid_to'
                                  ))))
                                  {
                                              // change user-model - set new level and period of training
                                              // save single fields
                                              $this->User->id = $transactions['pay_userid'];
                                              $now_ts = date('Y-m-d', time());
                                              $this->User->savefield('paid_from', $now_ts, false);
                                              $this->User->savefield('paid_to', $transactions['pay_paid_new_to'], false);
                                              $this->User->savefield('level', 'paymember', false);

                                              $this->_sendInvoice($transactions, 'invoice');

                                              $this->Session->setFlash(__('Received notification', true) . '. ' . __('Invoice sent', true) . '. ' . __('Thank you', true) . '.');
                                              //$this->redirect(array('action' => '', $this->User->id));
                                  } else
                                  {
                                              $error .= __('Saving of payment status failed',true) . '.';
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
                 // only for information purposes - do not create a new invoice
                 $this->_sendInvoice($transactions, 'info');
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

            //$session_userid = $this->Session->read('session_userid');
            // check if user-session is valid
            /**
            $results_user = $this->User->findById($session_userid);
            
            if ( !is_array( $results_user ) )
            {
               $error = __('Your user-session is corrupted. Sorry. Please contact us, we will fix it - promised! support@tricoretraining.com',true);
               $show_invoice = 'no';
            }
            **/
            
            $this->set('error', '');

            $this->set('show_invoice', $show_invoice);
            $this->set('data', $this->data['Payment']);
   }

   function _sendInvoice($pay, $mailtype)
   {
            //$this->layout = 'newsletter';

            $User = $this->User->read( null, $pay['pay_userid']);

            $this->set('user', $User);
            $this->set('pay', $pay);

            $this->set('timeinterval', $pay['pay_timeinterval']);
            $this->set('currency', $pay['pay_currency']);
            $this->set('price', $pay['pay_price']);

            if ( $mailtype == 'invoice' )
                           $this->set('invoice', $pay['pay_invoice']);

            $this->set('paid_from', $this->Unitcalc->check_date($pay['pay_paid_from']));
            $this->set('paid_to', $this->Unitcalc->check_date($pay['pay_paid_to']));
            $this->set('paid_new_from', $this->Unitcalc->check_date($pay['pay_paid_new_from']));
            $this->set('paid_new_to', $this->Unitcalc->check_date($pay['pay_paid_new_to']));
            $this->set('userobject', $this->Session->read('userobject'));

            $this->Email->to = $User['User']['email'];

            if ( $mailtype == 'invoice' )
                           $this->Email->subject = __('TriCoreTraining (TCT) Invoice',true);
            else
                           $this->Email->subject = __('TriCoreTraining (TCT) Subscription Info',true);

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
}

?>