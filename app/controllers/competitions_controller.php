<?php

/**
controller for managing all competitions
**/

class CompetitionsController extends AppController {
   var $name = 'Competitions';

   var $helpers = array('Html', 'Form', 'Javascript', 'Time', 'Session', 'Unitcalc'); 
   var $components = array('Email', 'Cookie', 'RequestHandler', 'Session', 'Unitcalc', 'Provider');

/**
list all competitions with paging
**/

   var $paginate = array(
       'Competition' => array(
                'limit' => 15,
                'order' => array(
                        'Competition.competitiondate' => 'asc'
                )
       )
   );

   function beforeFilter() 
   {
            parent::beforeFilter();
            $this->layout = 'default_trainer';
            $this->checkSession();
   }

   function list_competitions()
   {
            $statusbox = 'statusbox';
            $create_dummy = '';

            $session_userid = $this->Session->read('session_userid');
            $results['User'] = $this->Session->read('userobject');
            
            $sql = "SELECT * FROM competitions WHERE user_id = $session_userid AND " .
                "competitiondate > '" . date('Y-m-d', time()) . "' ORDER BY competitiondate ASC LIMIT 1";
            $checkcompetition = $this->Competition->query( $sql );
            
            // get season for this user
            $season = $this->Unitcalc->get_season( $results, $this->data );

            $sql = "SELECT count(*) AS countcomps FROM competitions WHERE user_id = $session_userid AND important = 1 AND competitiondate BETWEEN '" .
                    $season['start'] . "' AND '" . $season['end'] . "'";
            $Comps_important = $this->Competition->query( $sql );

            // if you have no important event, then a link to create a dummy event will be shown
            if ( $Comps_important[0][0]['countcomps'] == 0 )
            {
                 $create_dummy = 'true';
            }

            $this->paginate = array(
                  'conditions' => array('Competition.user_id = ' => $session_userid),
                  'limit' => 15,
                  'order' => array('Competition.competitiondate' => 'desc')
            );

            $competitions = $this->paginate('Competition');
			
            $this->set('competitions', $competitions);
            $this->set('checkcompetition', $checkcompetition);
            $this->set('statusbox', $statusbox);
            $this->set('create_dummy', $create_dummy);

   }

   function edit_competition($id = null) 
   {
            $this->set('js_addon','');
            $error = '';
            $statusbox = 'statusbox';

            $session_userid = $this->Session->read('session_userid');
            $results['User'] = $this->Session->read('userobject');
            $season = $this->Unitcalc->get_season( $results, $this->data );

            $unit = $this->Unitcalc->get_unit_metric();

            $session_userid = $this->Session->read('session_userid');
            $results['User'] = $this->Session->read('userobject');
            
            if ( empty($this->data) )
            {
                     // security check - don't view workouts of other users
                     if ( $id )
                     {
                       $result = $this->Competition->find ('all', 
                          array('conditions' => 
                              array( 'and' => 
                                  array( 'id' => $id, 'user_id' => $session_userid ) 
                              ) 
                          )
                       );
                       
                       if ( isset( $result[0] ) )
                       {
                          //$this->data = $result[0];
                       } else
                       {
                          $this->Session->setFlash(__('Sorry. This is not your entry!', true));
                          $this->set('statusbox', 'statusbox error');
                          $this->redirect(array('controller' => 'Competitions', 'action' => 'list_competitions'));
                       }
                     }
            }

            if (empty( $this->data ) && $id != 'dummy')
            {
               $this->data = $this->Competition->read();

               // re-format all amounts in correct format and metric
               // right now we don't use that - but for later implementation
               if ( isset( $this->data['Competition']['swim_time'] ) )
                    $this->data['Competition']['swim_time'] = $this->Unitcalc->seconds_to_time( $this->data['Competition']['swim_time'] );
               if ( isset( $this->data['Competition']['bike_time'] ) )
                    $this->data['Competition']['bike_time'] = $this->Unitcalc->seconds_to_time( $this->data['Competition']['bike_time'] );
               if ( isset( $this->data['Competition']['duathlon_run_time'] ) )
                    $this->data['Competition']['duathlon_run_time'] = $this->Unitcalc->seconds_to_time( $this->data['Competition']['duathlon_run_time'] );
               if ( isset( $this->data['Competition']['run_time'] ) )
                    $this->data['Competition']['run_time'] = $this->Unitcalc->seconds_to_time( $this->data['Competition']['run_time'] );
               if ( isset( $this->data['Competition']['swim_distance'] ) )
               {
                  $distance = $this->Unitcalc->check_distance( $this->data['Competition']['swim_distance'], 'show' );
                  $this->data['Competition']['swim_distance'] = $distance['amount'];
               }
               if ( isset( $this->data['Competition']['bike_distance'] ) )
               {
                  $distance = $this->Unitcalc->check_distance( $this->data['Competition']['bike_distance'], 'show');
                  $this->data['Competition']['bike_distance'] = $distance['amount'];
               }
               if ( isset( $this->data['Competition']['duathlon_run_distance'] ) )
               {
                  $distance = $this->Unitcalc->check_distance( $this->data['Competition']['duathlon_run_distance'], 'show' );
                  $this->data['Competition']['duathlon_run_distance'] = $distance['amount'];
               }
               if ( isset( $this->data['Competition']['run_distance'] ) )
               {
                  $distance = $this->Unitcalc->check_distance( $this->data['Competition']['run_distance'], 'show' );
                  $this->data['Competition']['run_distance'] = $distance['amount'];
               }

            } else
            {

               if ( $id != 'dummy' )
               {
                 // check for metric / unit
                 if ( isset( $this->data['Competition']['swim_distance'] ) )
                 {
                    $this->data['Competition']['swim_distance'] = $this->Unitcalc->check_distance( $this->Unitcalc->check_decimal( $this->data['Competition']['swim_distance'] ), 'save', 'single' );
                 }
                 if ( isset( $this->data['Competition']['bike_distance'] ) )
                 {
                    $this->data['Competition']['bike_distance'] = $this->Unitcalc->check_distance( $this->Unitcalc->check_decimal( $this->data['Competition']['bike_distance'] ), 'save', 'single' );
                 }
                 if ( isset( $this->data['Competition']['duathlon_run_distance'] ) )
                 {
                    $this->data['Competition']['duathlon_run_distance'] = $this->Unitcalc->check_distance( $this->Unitcalc->check_decimal( $this->data['Competition']['duathlon_run_distance']), 'save', 'single' );
                 }
                 if ( isset( $this->data['Competition']['run_distance'] ) )
                 {
                    $this->data['Competition']['run_distance'] = $this->Unitcalc->check_distance( $this->Unitcalc->check_decimal( $this->data['Competition']['run_distance'] ), 'save', 'single' );
                 }

                 if ( isset( $this->data['Competition']['swim_time'] ) )
                    $this->data['Competition']['swim_time'] = $this->Unitcalc->time_to_seconds( $this->data['Competition']['swim_time'] );
                 if ( isset( $this->data['Competition']['bike_time'] ) )
                    $this->data['Competition']['bike_time'] = $this->Unitcalc->time_to_seconds( $this->data['Competition']['bike_time'] );
                 if ( isset( $this->data['Competition']['duathlon_run_time'] ) )
                    $this->data['Competition']['duathlon_run_time'] = $this->Unitcalc->time_to_seconds( $this->data['Competition']['duathlon_run_time'] );
                 if ( isset( $this->data['Competition']['run_time'] ) )
                    $this->data['Competition']['run_time'] = $this->Unitcalc->time_to_seconds( $this->data['Competition']['run_time'] );
               }

               // create dummy event for user based on his personal profile
               if ( $id == 'dummy' )
               {
                    // get preferred type of sport of the user
                    if ( $results['User']['typeofsport'] )
                         $typeofsport = $results['User']['typeofsport'];

                    // is user rookie or not / different time (weeks) to the dummy event
                    if ( $results['User']['rookie'] == 1 )
                         $dummy_event = 12;
                    else
                         $dummy_event = 16;

                    $dummy_event_year = date( 'Y', time() );
                    $dummy_event_month = intval( date( 'm', time() ) ) + $dummy_event;

                    $dummy_event = $this->Unitcalc->month_in_year( $dummy_event_month, $dummy_event_year );
                    // try to find the transition phase - because there shouldn't be an event
                    $transition_start = $this->Unitcalc->month_in_year( $results['User']['coldestmonth'] - 2, $dummy_event_year+1 );
                    $transition_end = $this->Unitcalc->month_in_year( $results['User']['coldestmonth'] + 2, $dummy_event_year+1 );

                    $dummy_event_ts = mktime(0,0,0,$dummy_event['month'],01,$dummy_event['year']);
                    $transition_start_ts = mktime(0,0,0,$transition_start['month'], 01, $transition_start['year']);
                    $transition_end_ts = mktime(0,0,0, $transition_end['month'], 01, $transition_end['year']);

                    if ( $dummy_event_ts > $transition_start_ts && $dummy_event_ts < $transition_end_ts )
                         $dummy_event_date = $transition_end['year'] . '-' . $transition_end['month'] . '-01';
                    else
                         $dummy_event_date = $dummy_event['year'] . '-' . $dummy_event['month'] . '-01';

                    $this->data['Competition']['competitiondate'] = $dummy_event_date;
                    $this->data['Competition']['name'] = 'Dummy-Event';
                    $this->data['Competition']['sportstype'] = $typeofsport;
                    $this->data['Competition']['important'] = 1;
               }

               // SPECIAL ERRORCHECKING
               // get important events - check if there are only 3 in a season
               $sql = "SELECT * FROM competitions WHERE user_id = $session_userid AND important = 1 AND competitiondate BETWEEN '" .
                    $season['start'] . "' AND '" . $season['end'] . "'";
               $Comps_important = $this->Competition->query( $sql );
               if ( count( $Comps_important ) >= 2 && $this->data['Competition']['important'] == 1 )
                    $error = __('Sorry, only a maximum of 3 important events in a season are useful.', true);

               $sql = "SELECT * FROM competitions WHERE user_id = $session_userid AND competitiondate BETWEEN '" .
                    $season['start'] . "' AND '" . $season['end'] . "' AND competitiondate >= '" . date( 'Y-m-d', time() ) . "'";
               $Comps = $this->Competition->query( $sql );
               $error .= $this->check_competitions($Comps, $results);

               $this->data['Competition']['user_id'] = $session_userid;

               $sql = "SELECT * FROM competitions WHERE user_id = $session_userid AND name = '" . $this->data['Competition']['name'] .
                      "' AND competitiondate = '" . $this->data['Competition']['competitiondate'] . "'";
               $Comps_already = $this->Competition->query( $sql );
               if ( count( $Comps_already ) > 0 ) $error = __('Event already exists.',true);

               if ( $error == "" )
               {
                    $this->Provider->smartPurgeOnSave(
                    	$this->data["Competition"]["competitiondate"]["year"] . '-' . $this->data["Competition"]["competitiondate"]["month"] . '-' . $this->data["Competition"]["competitiondate"]["day"],
                    	$this->data["Competition"]["sportstype"]
                    );
               		if ($this->Competition->save( $this->data, array('validate' => true)))
                    {
                          $this->Session->setFlash(__('Competition saved.',true));
                          $this->redirect(array('action' => 'list_competitions', $this->User->id));
                    }
               } else
               {

                     $statusbox = 'statusbox error';
                     $this->Session->setFlash($error);
               }
            }

            $this->set('length_unit', $unit['length']);
            $this->set('UserID', $this->User->id);
            $this->set('statusbox', $statusbox);
            $this->set('sports', $this->Unitcalc->get_sports());
              
   }

   function check_competitions( $competitions, $userdata )
   {
            // TODO (B) finish this function
            $userdata = $userdata['User'];
            for ( $i = 0; $i < count( $competitions ); $i++ )
            {
                  /**
                  print_r( $competitions[$i]["competitions"] );
                  echo "<br /><br />";
                  print_r($userdata);
                  **/
                  // right now we do nothing here
            }
   }

   function delete($id) 
   {
            $this->Provider->smartPurgeOnDelete($id);
   			$this->Competition->delete($id);
            $this->Session->setFlash(__('The competition has been deleted.', true));
            $this->redirect(array('action'=>'list_competitions'));
   }

}

?>