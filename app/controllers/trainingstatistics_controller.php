<?php

class TrainingstatisticsController extends AppController {
   var $name = 'Trainingstatistics';

   var $helpers = array('Html', 'Form', 'Javascript', 'Time', 'Session', 'Ofc', 'Unitcalc', 'Xls');
   var $components = array('Email', 'Cookie', 'RequestHandler', 'Session', 'Unitcalc');

   var $paginate = array(
       'Trainingstatistic' => array(
                'limit' => 15,
                'order' => array(
                        'Trainingstatistic.date' => 'asc'
                )
       )
   );

   function beforeFilter()
   {
            parent::beforeFilter();
            $this->layout = 'default_trainer_2rows';
   }

   // list all trainings
   function list_trainings()
   {
            $this->checkSession();
            $this->layout = 'default_trainer';
            $statusbox = 'statusbox';
            $session_userid = $this->Session->read('session_userid');

            $this->paginate = array(
                      'conditions' => array('Trainingstatistic.user_id = ' => $session_userid),
                      'limit' => 15,
                      'order' => array('Trainingstatistic.date' => 'desc')
            );

            $this->set('trainingstatistics', $this->paginate('Trainingstatistic'));
            $this->set('statusbox', $statusbox);
   }

  function import_workout()
  {
    $this->pageTitle = __('Import workouts',true);
    $this->checkSession();
    $statusbox = 'statusbox_none';

    $session_userid = $this->Session->read('session_userid');
    $this->User->id = $session_userid;

    $this->set('unitmetric', $this->Unitcalc->get_unit_metric() );

    if (!empty($this->data))
    {
      $this->set('UserID', $this->User->id);

      $csv_file = $this->data['Trainingstatistic']['import_csv_upload'];
      if ( $csv_file['tmp_name'] )
      {
        $userid = $this->User->id;
        pr($csv_file);
      }
    }

    $this->set('statusbox', $statusbox);
  }

   function edit_training($id = null)
   {
            $this->checkSession();
            $this->layout = 'default_trainer';
            $this->set('js_addon','');
            $unit = $this->Unitcalc->get_unit_metric();
            $statusbox = '';

            $session_userid = $this->Session->read('session_userid');
            $results['User'] = $this->Session->read('userobject');
            
            if ( empty($this->data) )
            {
                     $statusbox = 'statusbox';
                     // security check - don't view workouts of other users
                     if ( $id )
                     {
                       $result = $this->Trainingstatistic->find ('all', 
                          array('conditions' => 
                              array( 'and' => 
                                  array( 'id' => $id, 'user_id' => $session_userid ) 
                              ) 
                          )
                       );
                       if ( isset( $result[0] ) )
                          $this->data = $result[0];
                       else
                       {
                          $this->Session->setFlash(__('Sorry. This is not your entry!', true));
                          $this->set('errorbox', $statusbox);
                          $this->redirect(array('controller' => 'Trainingstatistics', 'action' => 'list_trainings'));
                       }
                     }
                     
                     if ( isset( $this->data['Trainingstatistic']['duration'] ) )
                          $this->data['Trainingstatistic']['duration'] = $this->Unitcalc->seconds_to_time( $this->data['Trainingstatistic']['duration'] );

                     if ( isset( $this->data['Trainingstatistic']['distance'] ) )
                     {
                          $distance = $this->Unitcalc->check_distance( $this->data['Trainingstatistic']['distance'], 'show' );
                          $this->data['Trainingstatistic']['distance'] = $distance['amount'];
                     }
            } else
            {
                     $statusbox = 'statusbox';

                     // check for metric / unit
                     if ( $this->data['Trainingstatistic']['distance'] )
                        $this->data['Trainingstatistic']['distance'] = $this->Unitcalc->check_distance( $this->Unitcalc->check_decimal( $this->data['Trainingstatistic']['distance'] ), 'save', 'single' );
                     if ( $this->data['Trainingstatistic']['duration'] )
                        $this->data['Trainingstatistic']['duration'] = $this->Unitcalc->time_to_seconds( $this->data['Trainingstatistic']['duration'] );

                     if ( $this->data['Trainingstatistic']['duration'] && $this->data['Trainingstatistic']['distance'] && $this->data['Trainingstatistic']['avg_pulse'] ) 
                     {
                        $time_in_zones = "";
                        $this->data['Trainingstatistic']['trimp'] = round(
                            $this->Unitcalc->calc_trimp( 
                                $this->data['Trainingstatistic']['duration']/60, 
                                $this->data['Trainingstatistic']['avg_pulse'], 
                                $time_in_zones, 
                                $results['User']['lactatethreshold'],
                                $this->data['Trainingstatistic']['sportstype'] 
                            )
                        );
                     
                        $this->data['Trainingstatistic']['avg_speed'] = round( ( $this->data['Trainingstatistic']['distance'] / ( $this->data['Trainingstatistic']['duration'] / 3600 ) ), 2); 

                        if ( $results['User']['gender'] && $results['User']['weight'] && $results['User']['birthday'] )
                        {
                          $avgHR = $this->data['Trainingstatistic']['avg_pulse'];
                          $duration = $this->data['Trainingstatistic']['duration'];
                          $age = $this->Unitcalc->how_old($results['User']['birthday']);
                          $weight = $results['User']['weight'];

                          // calculate kcal for workout
                          if ( $results['User']['gender'] == 'm' )
                          {
                              $this->data['Trainingstatistic']['kcal'] = 
                                round(( -55.0969 + 0.6309 * $avgHR + 0.1988 * $weight + 0.2017 * $age ) / 4.1845
                                * $duration/60);
                          } else
                          {
                              $this->data['Trainingstatistic']['kcal'] = 
                                round((-20.4022 + 0.4472 * $avgHR + 0.1263 * $weight + 0.074 * $age ) / 4.1845
                                * $duration/60);
                          }
                        }
                        /**
                        http://www.triathlontrainingblog.com/calculators/calories-burned-calculator-based-on-average-heart-rate/
                        
                        Based on the following formulas:
                        Using VO2max
                           Men: C/min = (-59.3954 + (-36.3781 + 0.271 x age + 0.394 x weight + 0.404 x VO2max + 0.634 x HR))/4.184
                           Women: C/min = (-59.3954 + (0.274 x age + 0.103 x weight + 0.380 x VO2max + 0.450 x HR)) / 4.184
                        
                        Without VO2max
                           Men: C/min = (-55.0969 + 0.6309 x HR + 0.1988 x weight + 0.2017 x age) / 4.184
                           Women: C/min = (-20.4022 + 0.4472 x HR + 0.1263 x weight + 0.074 x age) / 4.184
                        weight is in kg
                        */
                     }
 
                     $this->data['Trainingstatistic']['user_id'] = $session_userid;

                     // save workout for user 
                     if ($this->Trainingstatistic->save( $this->data, array('validate' => true)))
                     {
                          $this->User->id = $session_userid;
                          $this->User->savefield('weight', $weight, false);
                          
                          $this->Session->setFlash('Training saved.');
                          $this->set('statusbox', $statusbox);
                          $this->redirect(array('controller' => 'Trainingstatistics', 'action' => 'list_trainings'));
                     } else
                     {
                          $statusbox = 'errorbox';
                          $this->Session->setFlash(__('Some errors occured',true));
                     }

                     if ( isset( $this->data['Trainingstatistic']['duration'] ) )
                          $this->data['Trainingstatistic']['duration'] = $this->Unitcalc->seconds_to_time( $this->data['Trainingstatistic']['duration'] );

                     if ( isset( $this->data['Trainingstatistic']['distance'] ) )
                     {
                          $distance = $this->Unitcalc->check_distance( $this->data['Trainingstatistic']['distance'], 'show' );
                          $this->data['Trainingstatistic']['distance'] = $distance['amount'];
                     }
            }

            $this->set('unit', $unit);
            $this->set('UserID', $this->User->id);
            $this->set('statusbox', $statusbox);
            $this->set('data', $this->data['Trainingstatistic']);
   }

   // how fit am I?
   function statistics_trimp()
   {
            $this->checkSession();
            $this->set('js_addon','');
            $unit = $this->Unitcalc->get_unit_metric();
            $statusbox = '';

            $results['User'] = $this->Session->read('userobject');
            $session_userid = $results['User']['id'];

            // set today
            $this->compdata['Competition']['competitiondate']['month'] = date('m', time());
            $this->compdata['Competition']['competitiondate']['year'] = date('Y', time());

            $season = $this->Unitcalc->get_season( $results, $this->compdata );
            if ( empty( $this->data['Trainingstatistic'] ) )
            {
               $start = $season['start'];
               $end   = $season['end'];
               
               $end = date( 'Y-m-d', time() );
               $this->data['Trainingstatistic']['fromdate'] = $start;
               $this->data['Trainingstatistic']['todate'] = $end;
               $statusbox = 'okbox';
            } else
            {
               $start = $this->data['Trainingstatistic']['fromdate'];
               $end   = $this->data['Trainingstatistic']['todate'];
               $start = $start['year'] . '-' . $start['month'] . '-' . $start['day'];
               $end = $end['year'] . '-' . $end['month'] . '-' . $end['day'];
            }

            if ( empty( $this->data['Trainingstatistic']['sportstype'] ) ) 
                    $this->data['Trainingstatistic']['sportstype'] = '';
            $sportstype = $this->data['Trainingstatistic']['sportstype'];

            $this->set('start', $start);
            $this->set('end', $end);
            $this->set('sportstype', $sportstype);
            $this->set('length_unit', $unit['length']);
            $this->set('statusbox', $statusbox);
   }

   // JSON for "how fit am I"
   function statistics_trimp_json()
   {
            $this->checkSession();
            $this->layout = "ajaxrequests";
       	    $this->RequestHandler->setContent('js', null);
            Configure::write('debug', 1);

            $session_userid = $this->Session->read('session_userid');
            $results['User'] = $this->Session->read('userobject');

            $this->set('js_addon','');
            $unit = $this->Unitcalc->get_unit_metric();
            $statusbox = '';

            $sportstype = $this->params['named']['stype'];
            $graphtype = $this->params['named']['gtype'];
            $start = $this->params['named']['start'];
            $end = $this->params['named']['end'];

            // some date calculations
            // we need 45 days (CTL) and 7 days (ATL) of data more than requested
            if ( $graphtype == 'chronic' )
               $start_calc = $this->Unitcalc->date_plus_days( $start, "-45" );
            elseif ( $graphtype == 'acute' )
               $start_calc = $this->Unitcalc->date_plus_days( $start, "-7" );

            $startday = split( '-', $start_calc );
            $endday = split( '-', $end );
            $startday_ts = mktime( 0, 0, 0, $startday[1], $startday[2], $startday[0] );
            $endday_ts = mktime( 0, 0, 0, $endday[1], $endday[2], $endday[0] );
            if ( $endday_ts > time() ) { $endday_ts = time(); $end = date( "Y-m-d", time() ); }
            $diff_dates = $this->Unitcalc->diff_dates( $start_calc, $end );

            // real training data (tracks)
            $sql = "SELECT duration, trimp, date FROM Trainingstatistics WHERE
                   user_id = $session_userid AND ";
            if ( $sportstype ) $sql .= "sportstype = '" . $sportstype . "' AND ";
            $sql .= "( date BETWEEN '" . $start_calc . "' AND '" . $end . "' ) ORDER BY date ASC";
            
            $trainingdata = $this->Trainingstatistic->query( $sql );

            // go through all trainings in trainingsstatistics
            for ( $i = 0; $i < count( $trainingdata ); $i++ )
            {
                  $dt = $trainingdata[$i]['Trainingstatistics'];
                  $date_string = split( ' ', $dt['date'] );
                  $day = $date_string[0];

                  // cumulate all trimp per day
                  if ( isset( $trimp_done[$day] ) )
                  {
                       $trimp_done[$day] += ( $dt['trimp'] );
                  } else
                  {
                       $trimp_done[$day] = ( $dt['trimp'] );
                  }
            }

            $sql = "SELECT duration, week AS date, trimp, athlete_id AS user_id,
                sport AS sportstype, week AS date FROM scheduledtrainings WHERE " . 
                "athlete_id = $session_userid AND ";
            //  "user_id = $session_userid AND ";
            if ( $sportstype ) $sql .= "sport = '" . $sportstype . "' AND ";
            //if ( $sportstype ) $sql .= "type = '" . $sportstype . "' AND ";
            //$sql .= "( date BETWEEN '" . $start_calc . "' AND '" . $end . "' ) ORDER BY date ASC";
            $sql .= "( week BETWEEN '" . $start_calc . "' AND '" . $end . "' ) ORDER BY date ASC";
                        
            $scheduled_trainingdata = $this->Trainingstatistic->query( $sql );
            
            // go through all planned trainings
            for ( $i = 0; $i < count( $scheduled_trainingdata ); $i++ )
            {
                  $dt = $scheduled_trainingdata[$i]['scheduledtrainings'];
                  $date_string = split( ' ', $dt['date'] );
                  $day = $date_string[0];

                  // cumulate all trimp per day
                  if ( isset( $trimp_planned[$day] ) )
                  {
                       $trimp_planned[$day] += ( $dt['trimp'] );
                  } else
                  {
                       $trimp_planned[$day] = ( $dt['trimp'] );
                  }
            }

            // TODO (B) limit period of difference to x days?
            //if ( $diff_dates > 60 ) $diff_dates = 60;

            $max_unit = 0;
            for ( $i = 0; $i < $diff_dates; $i++ )
            {
                // go through all days in this period
                $rightday_ts = $endday_ts - ( 86400 * $i );
                $rightday = date( 'Y-m-d', $rightday_ts );

                if ( !isset( $trimp_done[$rightday] ) ) $trimp_done[$rightday] = 0;
                //else $trimp_done[$rightday] = $trimp_done[$rightday];

                if ( !isset( $trimp_planned[$rightday] ) ) $trimp_planned[$rightday] = 0;
                //else $trimp_planned[$rightday] = $trimp_planned[$rightday];

                $trimp_dates[$i] = $rightday;

                if ( $graphtype == 'chronic' )
                {
                  // CTL
                  if ( $i <= 45 ) $startpoint = 0;
                  else $startpoint = $i - 45;

                } elseif ( $graphtype == 'acute' )
                {
                  // ATL
                  if ( $i <= 7 ) $startpoint = 0;
                  else $startpoint = $i - 7;
                }

                // calculate all trimp for 45 or 7 days back in the past per day
                for ( $j = $startpoint; $j <= $i; $j++ )
                {
                    if ( !isset( $trimp_tl_done[$j] ) ) $trimp_tl_done[$j] = 0;
                    $trimp_tl_done[$j] += $trimp_done[$rightday];
                    
                    // here we insert the planned trimp of the trainingplan
                    if ( !isset( $trimp_tl_planned[$j] ) ) $trimp_tl_planned[$j] = 0;
                    $trimp_tl_planned[$j] += $trimp_planned[$rightday];
                    
                    if ( $trimp_tl_planned[$j] > $max_unit ) $max_unit = $trimp_tl_planned[$j];
                    if ( $trimp_tl_done[$j] > $max_unit ) $max_unit = $trimp_tl_done[$j];
                       
                }
            }
            // for the graph we need the days in reverse order
            $trimp_tl_done = array_reverse($trimp_tl_done);
            $trimp_tl_planned = array_reverse($trimp_tl_planned);
            $trimp_dates = array_reverse($trimp_dates);

            $this->set('start', $start);
            $this->set('end', $end);
            $this->set('max_unit', $max_unit);
            $this->set('userobject', $results['User']);
            $this->set('trimp_tl_done', $trimp_tl_done);
            $this->set('trimp_tl_planned', $trimp_tl_planned);

            $this->set('trimp_dates', $trimp_dates);
            $this->set('graphtype', $graphtype);
            //$this->set('length_unit', $unit['length']);
   }

   // How fast am I?
   function statistics_formcurve()
   {
            $this->checkSession();
            $this->set('js_addon','');
            $unit = $this->Unitcalc->get_unit_metric();
            $statusbox = '';
            $results['User'] = $this->Session->read('userobject');
            $session_userid = $this->Session->read('session_userid');

            $this->compdata['Competition']['competitiondate']['month'] = date('m', time());
            $this->compdata['Competition']['competitiondate']['year'] = date('Y', time());

            $season = $this->Unitcalc->get_season( $results, $this->compdata );

            if ( empty( $this->data['Trainingstatistic'] ) )
            {
               $start = $season['start'];
               $end   = $season['end'];
               $end = date( 'Y-m-d', time() );
               
               $this->data['Trainingstatistic']['fromdate'] = $start;
               $this->data['Trainingstatistic']['todate'] = $end;
            } else
            {
               $start = $this->data['Trainingstatistic']['fromdate'];
               $end   = $this->data['Trainingstatistic']['todate'];
               $start = $start['year'] . '-' . $start['month'] . '-' . $start['day'];
               $end = $end['year'] . '-' . $end['month'] . '-' . $end['day'];
            }

            if ( empty( $this->data['Trainingstatistic']['sportstype'] ) ) $this->data['Trainingstatistic']['sportstype'] = '';

            // select all test-workouts grouped by sportstype
            $sql = "SELECT name, distance, sportstype, count(*) as ccount FROM Trainingstatistics WHERE testworkout = 1 " .
                 "AND user_id = $session_userid AND name != '' AND ";
            $sql .= "( date BETWEEN '" . $start . "' AND '" . $end . "' ) GROUP BY name, distance, sportstype HAVING ccount > 1 ORDER BY name, distance";
            $testworkoutsfilter = $this->Trainingstatistic->query( $sql );

            if ( !empty( $this->data['Trainingstatistic']['search'] ) ) $searchfilter = $this->data['Trainingstatistic']['search'];
            else $searchfilter = '';

            $this->set('start', $start);
            $this->set('end', $end);
            $this->set('sportstype', $this->data['Trainingstatistic']['sportstype']);
            $this->set('searchfilter', $searchfilter);
            $this->set('testworkoutsfilter', $testworkoutsfilter);
            $this->set('length_unit', $unit['length']);
            $this->set('statusbox', $statusbox);

   }

   // json for graph
   function statistics_formcurve_json()
   {
            $this->checkSession();
     
            $this->layout = "ajaxrequests";
       	    $this->RequestHandler->setContent('js', null);
            Configure::write('debug', 1);

            $this->set('js_addon','');
            $unit = $this->Unitcalc->get_unit_metric();
            $statusbox = '';

            $results['User'] = $this->Session->read('userobject');
            $session_userid = $this->Session->read('session_userid');

            $sportstype = $this->params['named']['type'];
            $searchfilter = $this->params['named']['searchfilter'];
            $start = $this->params['named']['start'];
            $end = $this->params['named']['end'];

            $this->data['Trainingstatistic']['sportstype'] = $sportstype;

            $startday = split( '-', $start );
            $endday = split( '-', $end );
            $startday_ts = mktime( 0, 0, 0, $startday[1], $startday[2], $startday[0] );
            $endday_ts = mktime( 0, 0, 0, $endday[1], $endday[2], $endday[0] );
            if ( $endday_ts > time() ) { $endday_ts = time(); $end = date( "Y-m-d", time() ); }

            $diff_dates = $this->Unitcalc->diff_dates( $start, $end );

            // allow only 90 days
            // TODO (B) is this limitation a good solution?
            /**
            if ( $diff_dates > 90 ) 
            { 
                 $startday_ts += ( ( $diff_dates - 90 ) * 86400 );
                 $start = date( 'Y-m-d', $startday_ts );
                 $diff_dates = 90;
            }
            **/

            // to filter test-workouts I have to create a key to filter
            $searchsplit = explode( "|||", $searchfilter );
            $pulse['min'] = $pulse['max'] = 0;

            // TODO (B) select different avg_pulse_zones
            // select all entries for this special test-workout - filtered by the name and the sportstype
            $sql = "SELECT date, distance, duration, avg_pulse FROM Trainingstatistics WHERE user_id = $session_userid ";
              //AND sportstype = '" . $sportstype . "'
            $sql .= "AND ( date BETWEEN '" . $start . "' AND '" . $end . "' ) AND name = '" . $searchsplit[0] .
              "' AND distance = '" . $searchsplit[1] . "'";

            $trainings = $this->Trainingstatistic->query( $sql );

            for ( $i = 0; $i < count( $trainings ); $i++ )
            {
                  $dt = $trainings[$i]['Trainingstatistics'];
                  // find out what the maximum pulse is - for the height of the graph
                  if ( $dt['avg_pulse'] > $pulse['max'] ) $pulse['max'] = $dt['avg_pulse'];
                  if ( $dt['avg_pulse'] < $pulse['min'] || $pulse['min'] == 0 ) $pulse['min'] = $dt['avg_pulse'];
            }
            // what is the average pulse
            $total_avg_pulse = round( ( ( $pulse['max'] + $pulse['min'] ) / 2 ), 0 );

            $max_perunit = 0;

            for ( $i = 0; $i < count( $trainings ); $i++ )
            {
                  // we make all entries of the testworkouts relative to each other 
                  // and transform them to minutes per miles/km
                  $dt = $trainings[$i]['Trainingstatistics'];

                  // calculate average pulse minus total average pulse
                  $diff_pulse = ( $dt['avg_pulse'] - $total_avg_pulse ); // 190 - 160 = 30 / basic value
                  $change_value = ( $diff_pulse / $dt['avg_pulse'] ) + 1;
                  $dt['old_duration'] = $dt['duration'];
                  $duration_interim = ( $dt['duration'] * $change_value );
                  $dt['duration'] = $newduration = round( $duration_interim, 0 );
                  $correct_distance = $this->Unitcalc->check_distance( $dt['distance'] );
                  $distanceperunit_interim =  $newduration / $correct_distance['amount'] / 60;
                  $dt['distanceperunit'] = round( $distanceperunit_interim, 2);
                  if ( $distanceperunit_interim > $max_perunit ) $max_perunit = $distanceperunit_interim;
                  // depends on minutes per km / mi
/**
                  $dt = $trainings[$i]['Trainingstatistics'];
                  // calculate average pulse minus total average pulse
                  $diff_pulse = ( $dt['avg_pulse'] - $total_avg_pulse ); // 190 - 160 = 30 / basic value
                  $change_value = ( $diff_pulse / $dt['avg_pulse'] ) + 1;
                  $trainings[$i]['Trainingstatistics']['old_duration'] = $dt['duration'];
                  $duration_interim = ( $dt['duration'] * $change_value );
                  $trainings[$i]['Trainingstatistics']['duration'] = $newduration = round( $duration_interim, 0 );
                  $correct_distance = $this->Unitcalc->check_distance( $dt['distance'] );
                  $distanceperunit_interim =  $newduration / $correct_distance['amount'] / 60;
                  $trainings[$i]['Trainingstatistics']['distanceperunit'] = round( $distanceperunit_interim, 2);
                  if ( $distanceperunit_interim > $max_perunit ) $max_perunit = $distanceperunit_interim;
                  // depends on minutes per km / mi
**/
                  $newdate = split( ' ', $dt['date'] );
                  $newdate2 = $newdate[0];
                  // date, distance, duration, avg_pulse
                  $traindate2[$newdate2] = $dt;
            }

            $initiator = 0;

            for ( $i = 0; $i < $diff_dates; $i++ )
            {
                     $rdate = date( 'Y-m-d', ( $startday_ts + $i * 86400 ) );
                     if ( !isset( $traindate2[$rdate]['distanceperunit'] ) ) $traindate[$rdate]['distanceperunit'] = $initiator;
                     else $traindate[$rdate]['distanceperunit'] = $traindate2[$rdate]['distanceperunit'];
                     $traindate[$rdate]['date'] = $rdate;

                     $initiator = $traindate[$rdate]['distanceperunit'];
            }

            $max_perunit = round( $max_perunit, 0 ) + 1;

            $this->set('start', $start);
            $this->set('end', $end);
            $this->set('startday_ts', $startday_ts);
            $this->set('endday_ts', $endday_ts);
            $this->set('max_perunit', $max_perunit);
            $this->set('trainings', $traindate);
            $this->set('unit', $unit);

   }

   /** 
   Can I finish my important competition?
   **/

   function statistics_competition()
   {
            $this->checkSession();

            $this->set('js_addon','');
            $unit = $this->Unitcalc->get_unit_metric();
            $statusbox = '';
            $results['User'] = $this->Session->read('userobject');
            $session_userid = $this->Session->read('session_userid');

            $total_trimp = 0;
            $total_trimp_tp = 0;

            // today - to get the right season
            $this->compdata['Competition']['competitiondate']['month'] = date('m', time());
            $this->compdata['Competition']['competitiondate']['year'] = date('Y', time());

            $season = $this->Unitcalc->get_season( $results, $this->compdata );
            $start = $season['start'];
            $end   = $season['end'];
            $end = date( 'Y-m-d', time() );

/**
            if ( empty( $this->data['Trainingstatistic'] ) )
            {
               $start = $season['start'];
               $end   = $season['end'];
            } else
            {
               $start = $start['year'] . '-' . $start['month'] . '-' . $start['day'];
               $end = $end['year'] . '-' . $end['month'] . '-' . $end['day'];
            }
**/
            $sportstype = $this->data['Trainingstatistic']['sportstype'];
            $sql = "SELECT * FROM Trainingstatistics WHERE user_id = $session_userid AND ";
            if ( $sportstype ) $sql .= "sportstype = '" . $sportstype . "' AND ";
            $sql .= "(date BETWEEN '" . $start . "' AND '" . $end . "')";
            //echo $sql . "<br>";

            $trainings = $this->Trainingstatistic->query( $sql );
            $sumdata['collected_sportstypes'] = array();
            $sumdata['duration'] = array();
            $sumdata['distance'] = array();
            $sumdata['trimp'] = array();

            // go through all trainings of period defined
            for ( $i = 0; $i < count( $trainings ); $i++ )
            {
                  $dt = $trainings[$i]['Trainingstatistics'];
                  $sportstype_set = $dt['sportstype'];
                  // reset array per sportstype
                  if ( !in_array( $sportstype, $sumdata['collected_sportstypes'] ) )
                  {
                       $sumdata['collected_sportstypes'][] = $sportstype_set;
                       $sumdata['duration'][$sportstype_set] = 0;
                       $sumdata['distance'][$sportstype_set] = 0;
                       $sumdata['trimp'][$sportstype_set] = 0;
                  }

                  // cummulate values per sportstype
                  $sumdata['duration'][$sportstype_set] += $dt['duration'];
                  //$sumdata['distance'][$sportstype] += $dt['distance'];

                  if ( $dt['trimp'] > 0 )
                  {
                       $sumdata['trimp'][$sportstype_set] += ( $dt['trimp'] );
                       $total_trimp += ( $dt['trimp'] );
                  }
            }

            /**
            planned trainings
            **/
            // TODO (B) we have to load the correct fields from table
            $sql = "SELECT duration, week AS date, trimp, athlete_id AS user_id,
                sport AS sportstype, week AS date FROM scheduledtrainings WHERE " . 
                "athlete_id = $session_userid AND ";
                //"user_id = $session_userid AND ";
            if ( $sportstype ) $sql .= "sport = '" . $sportstype . "' AND "; 
            //$sql .= "( date BETWEEN '" . $start_calc . "' AND '" . $end . "' ) ORDER BY date ASC";
            $sql .= "( week BETWEEN '" . $start . "' AND '" . $end . "' ) ORDER BY date ASC";
            //echo $sql . "<br>";
            
            $Trainingplans = $this->Trainingstatistic->query( $sql );
            //$Trainingplans = $this->Trainingplan->query( $sql );

            $sumdata_tp['collected_sportstypes'] = array();
            $sumdata_tp['duration'] = array();
            $sumdata_tp['distance'] = array();
            $sumdata_tp['trimp'] = array();

            for ( $i = 0; $i < count( $Trainingplans ); $i++ )
            {
                  $dt = $Trainingplans[$i]['scheduledtrainings'];
                  $sportstype_set = $dt['sportstype'];
                  if ( !in_array( $sportstype, $sumdata_tp['collected_sportstypes'] ) )
                  {
                       $sumdata_tp['collected_sportstypes'][] = $sportstype_set;
                       $sumdata_tp['duration'][$sportstype_set] = 0;
                       $sumdata_tp['distance'][$sportstype_set] = 0;
                       $sumdata_tp['trimp'][$sportstype_set] = 0;
                  }

                  $sumdata_tp['duration'][$sportstype_set] += $dt['duration'];
                  //$sumdata_tp['distance'][$sportstype_set] += $dt['distance'];
                 
                  //$dt['trimp'] *= 150;
                  if ( $dt['trimp'] )
                  {
                       $sumdata_tp['trimp'][$sportstype_set] += ( $dt['trimp'] );
                       $total_trimp_tp += ( $dt['trimp'] );
                  }
            }

            if ( $sportstype ) 
            {
                    if ( isset( $sumdata['trimp'][$sportstype] ) ) 
                        $total_trimp = $sumdata['trimp'][$sportstype];
                    else
                        $total_trimp = 0;
                    
                    if ( isset( $sumdata_tp['trimp'][$sportstype] ) ) 
                        $total_trimp_tp = $sumdata_tp['trimp'][$sportstype];
                    else
                        $total_trimp_tp = 0;
            }
 
            if ( $total_trimp_tp > 0 )
               $trafficlight = ( $total_trimp / $total_trimp_tp );
            else
               $trafficlight = 0;

            $trafficlight_percent = round ( ( $trafficlight * 100 ), 1 );

            // define colors for traffic light
            if ( $trafficlight >= 0.8 && $trafficlight <= 1.1 ) $color = "green";
            elseif ( ( $trafficlight >= 0.6 && $trafficlight < 0.8 ) || ( $trafficlight > 1.1 & $trafficlight <= 1.2 ) ) $color = "orange";
            else $color = "red";

            $this->set('start', $start);
            $this->set('end', $end);
            $this->set('sumdata', $sumdata);
            $this->set('total_trimp', $total_trimp);
            $this->set('total_trimp_tp', $total_trimp_tp);
            $this->set('color', $color);
            $this->set('trafficlight_percent', $trafficlight_percent);
            $this->set('length_unit', $unit['length']);
            $this->set('statusbox', $statusbox);
   }

   /**
   How much have I lost?
   **/
   function statistics_howmuchhaveilost()
   {
            $this->checkSession();

            $this->set('js_addon','');
            $unit = $this->Unitcalc->get_unit_metric();
            $statusbox = '';

            $results['User'] = $this->Session->read('userobject');
            $session_userid = $results['User']['id'];

            $this->compdata['Competition']['competitiondate']['month'] = date('m', time());
            $this->compdata['Competition']['competitiondate']['year'] = date('Y', time());

            $season = $this->Unitcalc->get_season( $results, $this->compdata );

            if ( empty( $this->data['Trainingstatistic'] ) )
            {
               $start = $season['start'];
               //$end   = $season['end'];
               $end = date( 'Y-m-d', time() ); 
               $this->data['Trainingstatistic']['fromdate'] = $start;
               $this->data['Trainingstatistic']['todate'] = $end;
            } else
            {
               $start = $this->data['Trainingstatistic']['fromdate'];
               $end   = $this->data['Trainingstatistic']['todate'];
               $start = $start['year'] . '-' . $start['month'] . '-' . $start['day'];
               $end = $end['year'] . '-' . $end['month'] . '-' . $end['day'];
            }

            // select trainingsdata
            $sql = "SELECT * FROM Trainingstatistics WHERE user_id = $session_userid AND date BETWEEN '" .
                $start . "' AND '" . $end . "'";
            $trainings = $this->Trainingstatistic->query( $sql );

            $this->set('start', $start);
            $this->set('end', $end);
            $this->set('trainings', $trainings);
            //$this->set('length_unit', $unit['length']);
            $this->set('statusbox', $statusbox);

   }

   function statistics_howmuchhaveilost_json()
   {
          $this->checkSession();

          $this->layout = "ajaxrequests";
     	    $this->RequestHandler->setContent('js', null);
          Configure::write('debug', 1);

          $this->set('js_addon','');
          $unit = $this->Unitcalc->get_unit_metric();
          $statusbox = '';

          $results['User'] = $this->Session->read('userobject');
          $session_userid = $results['User']['id'];
          $targetweight = $results['User']['targetweight'];
          $targetweightdate = $results['User']['targetweightdate'];
          
          // type of graph
          $type = $this->params['named']['type'];

          $start = $this->params['named']['start'];
          $end = $this->params['named']['end'];
          if ( $targetweightdate && $targetweight ) $end = $targetweightdate; 
          $start_ts = strtotime($start);
          $end_ts = strtotime($end);
         
          $sql = "SELECT round(avg(weight),1) as avgweight, 
                  date_format(min(date), '%Y-%m-%d') as 'weekday',
                  date_format(date, '%Y%u') as 'week' FROM Trainingstatistics WHERE 
                  user_id = $session_userid AND weight != '' AND
                  date BETWEEN '" . $start . "' AND '" . $end . "' ";
          $sql .= "GROUP BY week ORDER BY week ASC";
          $trainings = $this->Trainingstatistic->query( $sql );
          
          $lastentry = count($trainings);
          $firsttraining = $trainings[0][0];
          $start_ts = strtotime( $firsttraining['weekday'] );
          
          $weeks_between_dates = round(($end_ts - $start_ts)/(86400*7),0)+1;
          $week_ts = $start_ts;
          
          if ( $targetweightdate && $targetweight )
          {
                $train_array = $trainings[$lastentry-1][0];
                $diff_time = strtotime( $targetweightdate ) - strtotime( $train_array['weekday'] );

                // weeks between last trainingstatistics entry and target weight date
                $diff_week = round( $diff_time / ( 86400 * 7 ) );
                // diff between last weight entry and target weight
                $diff_weight = $targetweight - $train_array['avgweight'];
                // how much do you have to loose to reach your weight goal
                $diff_per_week = ($diff_weight / $diff_week);

                $lastweight = $train_array['avgweight'];
                $lastweightdate = $train_array['weekday'];
          }
             
          for ( $i = 0; $i < $weeks_between_dates; $i ++)
          {
              $nweek[$i] = date('W', $week_ts);
              $nyear[$i] = date('o', $week_ts);
              $week_ts += (86400*7);
              //echo $nyear[$i] . '-' . $nweek[$i] . '<br />';
              $weeks[$i] = $nyear[$i]. $nweek[$i]; 
          }

          for ( $i = 0; $i < count( $trainings ); $i++ )
          {
               $week = $trainings[$i][0]['week'];
               $train[$week]['avgweight'] = $trainings[$i][0]['avgweight'];
          }

          $avg_weight_lastweek = 'null'; 
          // go through all weeks - in case you have weeks without trainings you have to set them to 0
          for( $i = 0; $i < ( $weeks_between_dates ); $i++ )
          {
               $yearweek = $nyear[$i] . '' . $nweek[$i]; 
               //echo $yearweek . '<br />';
               if ( $i > ( $weeks_between_dates - $diff_week ) ) 
               {
                   $train[$yearweek]['avgweight'] = 'null';
               } else
               {
                  if ( empty($train[$yearweek]['avgweight']) || $train[$yearweek]['avgweight'] == 0 )
                  {
                      $train[$yearweek]['avgweight'] = $avg_weight_lastweek;
                  } else
                  {
                      $avg_weight_lastweek = $train[$yearweek]['avgweight'];
                  }
                }
          }
          ksort($train);
          
          //pr($train);
          $this->set('start', $start);
          $this->set('end', $end);
          $this->set('diffweek', $diff_week);
          $this->set('diffweight', $diff_weight);
          $this->set('diff_per_week', $diff_per_week);
          $this->set('lastweight', $lastweight);
          $this->set('targetweight', $targetweight);
          $this->set('maxweeks', $weeks_between_dates);
          $this->set('stype', $type);
          $this->set('weeks', $weeks);
          $this->set('trainings2', $train);
          $this->set('weight_unit', $unit['weight']);
   }

   /**
   What have I done?
   **/
   function statistics_whathaveidone()
   {
            $this->checkSession();

            if ( $this->data['Trainingstatistic']['sportstype'] ) 
                $post_sportstype = $this->data['Trainingstatistic']['sportstype'];
            else 
                $post_sportstype = '';

            // http://www.dnamique.com/cakephp-export-data-to-excel-the-easy-way/
            $export = false;
            if ( isset( $this->params['form']['excel'] ) ) {
               $export = true;
               $this->layout = "xls";
               Configure::write('debug', 1);
            }

            $this->set('js_addon','');
            $unit = $this->Unitcalc->get_unit_metric();
            $statusbox = '';

            $results['User'] = $this->Session->read('userobject');
            $session_userid = $results['User']['id'];

            $this->compdata['Competition']['competitiondate']['month'] = date('m', time());
            $this->compdata['Competition']['competitiondate']['year'] = date('Y', time());

            $season = $this->Unitcalc->get_season( $results, $this->compdata );

            if ( empty( $this->data['Trainingstatistic'] ) )
            {
               $start = $season['start'];
               //$end   = $season['end'];
               $end = date( 'Y-m-d', time() ); 
               $this->data['Trainingstatistic']['fromdate'] = $start;
               $this->data['Trainingstatistic']['todate'] = $end;
            } else
            {
               $start = $this->data['Trainingstatistic']['fromdate']; 
               $end   = $this->data['Trainingstatistic']['todate'];
               $start = $start['year'] . '-' . $start['month'] . '-' . $start['day'];
               $end = $end['year'] . '-' . $end['month'] . '-' . $end['day'];
            }

            // select trainingsdata
            $sql = "SELECT * FROM Trainingstatistics WHERE user_id = $session_userid AND date BETWEEN '" .
                $start . "' AND '" . $end . "'";
            $trainings = $this->Trainingstatistic->query( $sql );

            $sumdata['collected_sportstypes'] = array();
            $sumdata['duration'] = array();
            $sumdata['distance'] = array();
            $sumdata['trimp'] = array();

            // collect them, accumulate per sportstype
            for ( $i = 0; $i < count( $trainings ); $i++ )
            {
                  $dt = $trainings[$i]['Trainingstatistics'];
                  $sportstype = strtoupper($dt['sportstype']);
                  if ( !in_array( $sportstype, $sumdata['collected_sportstypes'] ) )
                  {
                       $sumdata['collected_sportstypes'][] = strtoupper($sportstype);
                       $sumdata['duration'][$sportstype] = 0;
                       $sumdata['distance'][$sportstype] = 0;
                       $sumdata['trimp'][$sportstype] = 0;
                  }

                  $sumdata['duration'][$sportstype] += ( $dt['duration'] );
                  $sumdata['distance'][$sportstype] += $dt['distance'];
                  $sumdata['trimp'][$sportstype] += $dt['trimp'];
            }

            $this->set('start', $start);
            $this->set('end', $end);
            $this->set('export', $export);
            $this->set('sumdata', $sumdata);
            $this->set('trainings', $trainings);
            $this->set('length_unit', $unit['length']);
            $this->set('statusbox', $statusbox);
            $this->set('post_sportstype', $post_sportstype);

   }

   function statistics_whathaveidone_json()
   {
            $this->checkSession();

            /** http://stuartmultisport.com/TrImp.aspx **/
            $this->layout = "ajaxrequests";
            $this->RequestHandler->setContent('js', null);
            Configure::write('debug', 1);

            $this->set('js_addon','');
            $unit = $this->Unitcalc->get_unit_metric();
            $statusbox = '';

            $results['User'] = $this->Session->read('userobject');
            $session_userid = $results['User']['id'];
            // type of graph
            $type = $this->params['named']['type'];

            // sportstype RUN, BIKE, SWIM
            $sportstype = $this->params['named']['sportstype'];
            $start = $this->params['named']['start'];
            $end = $this->params['named']['end'];

            $start_ts = strtotime($start);
            $end_ts = strtotime($end);

            // get for given timestamp the week (number) and year
            $start_year = date('o', $start_ts);
            $start_week = date('W', $start_ts);
            $end_year = date('o', $end_ts);
            $end_week = date('W', $end_ts);

            // what if the period defined goes until to the next year
            if ( $end_year > $start_year ) $end_week = $end_week + ( 53 * ( $end_year - $start_year ) );

            $weeks_between_dates = $end_week - $start_week;

            if ( $type == 'distance' || $type == 'duration' || $type == 'weight' )
            {
               $maxdistance = 0;
               $maxduration = 0;
               $weekbefore = '';
               $minweek = '';
               $maxweek = '';

               $sql = "SELECT count(*) as 'count', sum(distance) as sumdistance, sum(duration) as sumduration,
                      date_format(min(date), '%Y-%M-%d') as 'week commencing',
                      date_format(date, '%Y%u') as 'week' from Trainingstatistics where user_id = $session_userid AND
                      date BETWEEN '" . $start . "' AND '" . $end . "' ";
               if ( $sportstype ) $sql .= " AND sportstype = '" . $sportstype . "' ";
               $sql .= "group by week order by week asc";

               $trainings = $this->Trainingstatistic->query( $sql );

               $lastentry = count($trainings);
               $minweek = $trainings[0][0]['week'];
               $maxweek = $trainings[$lastentry-1][0]['week'];

               for ( $i = 0; $i < count( $trainings ); $i++ )
               {
                   $week = $trainings[$i][0]['week'];
                   $trainings2[$week]['sumdistance'] = round( $trainings[$i][0]['sumdistance'], 2 );
                   $trainings2[$week]['sumduration'] = round( ( $trainings[$i][0]['sumduration'] / 3600 ), 2 );
                   $trainings2[$week]['sumtrainings'] = $trainings[$i][0]['count'];

                   // make graph a little bit higher with max values
                   if ( $trainings[$i][0]['sumdistance'] > $maxdistance ) $maxdistance = $trainings[$i][0]['sumdistance'] * 1.2;
                   if ( ( $trainings[$i][0]['sumduration'] / 3600 ) > $maxduration ) $maxduration = ( $trainings[$i][0]['sumduration'] / 3600 ) * 1.2;
               }

               // go through all weeks - in case you have weeks without trainings you have to set them to 0
               for( $i = 0; $i < $weeks_between_dates; $i++ )
               {
                   if ( $start_week < 10 ) $start_week = '0' . $start_week;
                   $yearweek = $start_year . $start_week;
                   $weeks[$i] = $yearweek;

                   if ( empty($trainings2[$yearweek]['sumdistance']) )
                   {
                      $trainings2[$yearweek]['sumdistance'] = 0;
                      $trainings2[$yearweek]['sumduration'] = 0;
                      $trainings2[$yearweek]['sumtrainings'] = 0;
                   }

                   if ( $start_week == 53 ) { $start_year++; $start_week = 1; }
                   else { $start_week ++; }
               }
            }

            $this->set('start', $start);
            $this->set('end', $end);
            $this->set('maxweeks', $weeks_between_dates);
            $this->set('weeks', $weeks);
            $this->set('trainings2', $trainings2);
            $this->set('stype', $type);
            $this->set('maxdistance', $maxdistance);
            $this->set('maxduration', $maxduration);
            $this->set('length_unit', $unit['length']);
   }

   function delete($id)
   {
            $this->checkSession();

            $this->Trainingstatistic->delete($id);
            $this->Session->setFlash(__('Workout deleted.',true));
            $this->redirect(array('action'=>'list_trainings'));
   }
}

?>