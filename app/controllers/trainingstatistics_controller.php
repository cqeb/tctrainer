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

    $newimportfile = '';
    $newimportfilearray[] = '';
    $outputfile = '';
    $import_error = '';
    
    $session_userid = $this->Session->read('session_userid');
    $results['User'] = $this->Session->read('userobject');
    $this->User->id = $session_userid;

    $this->set('unitmetric', $this->Unitcalc->get_unit_metric() );

    if ( !empty($this->data) )
    {
      $this->set('UserID', $this->User->id);

      if ( isset( $this->data['Trainingstatistic']['import_csv_upload'] ) )
      {
            $csv_file = $this->data['Trainingstatistic']['import_csv_upload'];

      } elseif ( isset( $this->data['Trainingstatistic']['hiddenimportfile'] ) )
      {
            $csv_file_data = $this->data['Trainingstatistic']['hiddenimportfile'];
      }
      
      if ( isset( $csv_file['tmp_name'] ) || $this->data['Trainingstatistic']['hiddenimportfile'] )
      {

        $userid = $this->User->id;

        if ( isset( $csv_file['tmp_name'] ) )
        {
          $return = $this->_save_file($csv_file, $userid, "file", "import");
          //if (!$return['error']) echo $return['destination'];

          $importfile = $_SERVER['DOCUMENT_ROOT'] . $return['destination'];
          $importfile = str_replace( '/', '\\', $importfile);
          $importfile = str_replace( 'files\\', 'app\\webroot\\files\\', $importfile);
  
          $importdata = file( $importfile );

        } else
        {
          $importdata = unserialize($this->data['Trainingstatistic']['hiddenimportfile']);
        }

        if ( !isset( $importdata ) || ( count($importdata) < 2 ) )  
        {
            $this->Session->setFlash(__('No import data found!', true));
            $this->set('errorbox', $statusbox);
            $this->redirect(array('controller' => 'Trainingstatistics', 'action' => 'list_trainings'));
            die();
        }

        $check_sport = array( 'RUN', 'BIKE', 'SWIM' );

        foreach ( $importdata as $key => $value )
        {

              if ( $key > 0 ) 
              {
                $import_error = '';
                if ( !$this->Unitcalc->is_utf8($value) ) $value = utf8_encode( $value );

                //echo $value . '<br />';
                $importdatalines = split( ";", $value );

                if ( strtotime( $importdatalines[0] ) )
                { 
                      $importdate = $this->Unitcalc->check_date( $importdatalines[0], 'save' );
                } else
                { 
                      $import_error = '<br />' . __('Date', true) . ' ' . __('is not valid!', true);
                      $importdate = '';
                }

/**
                if ( isset( $importdatalines[1] ) )
                {
                      $importtimearray = split( ":", $importdatalines[1] );
                      if ( is_numeric( $importtimearray[0] ) && is_numeric( $importtimearray[1] ) )
                             $importtime = $importdatalines[1];
                      else $importtime = '00:00';
                } else 
                      $importtime = '00:00';
**/
                
                if ( isset( $importdatalines[1] ) ) 
                      $importname = $importdatalines[1];
                else 
                      $importname = '';
                   
                if ( isset( $importdatalines[2] ) && in_array( strtoupper($importdatalines[2]), $check_sport ))
                {
                      $importsport =  strtoupper($importdatalines[2]);
                } else
                {
                      if ( isset( $importdatalines[2] ) ) $missingsport = ' (' . $importdatalines[2] . ')';
                      else $missingsport = '';
                                        
                      $import_error .= '<br />' . __('Sport', true) . ' ' . __('is not valid!', true) . $missingsport;
                      $importsport = '';
                }
                
                if ( isset( $importdatalines[3] ) ) 
                      $importdatalines[3] = str_replace( ',', '.', $importdatalines[3] );
                if ( isset( $importdatalines[3] ) && is_numeric( $importdatalines[3] ) )
                { 
                      $importdistance = $this->Unitcalc->check_distance( $importdatalines[3], 'save', 'single' );
                } else
                {
                      $import_error .= '<br />' . __('Distance', true) . ' ' . __('is not valid!', true);
                      $importdistance = '';
                }
                
                if ( isset( $importdatalines[4] ) ) 
                {
                    //echo $importdatalines[4];
                    $importdurationarray = split( ':', $importdatalines[4] );
                    //pr($importdurationarray);
                
                    if ( is_numeric($importdurationarray[0]) && is_numeric($importdurationarray[1]) && is_numeric($importdurationarray[2]) )
                    {
                          $importduration = $this->Unitcalc->time_to_seconds($importdatalines[4]);
                    } else
                    {
                          $import_error .= '<br />' . __('Duration', true) . ' ' . __('is not valid!', true);
                          $importduration = '';
                    }
                } else
                {
                    $import_error .= '<br />' . __('Duration', true) . ' ' . __('is not valid!', true);
                    $importduration = '';
                }                

                if ( isset( $importdatalines[5] ) && is_numeric($importdatalines[5]) )
                {
                      $importheartrate = $importdatalines[5];
                } else
                {
                      $import_error .= '<br />' . __('Avg. heart rate', true) . ' ' . __('is not valid!', true);
                      $importheartrate = '';
                }
                
                if ( isset( $importdatalines[6] ) && strtoupper($importdatalines[6]) == 'YES' ) 
                      $importworkout = 1;
                else
                      $importworkout = 0;
                      
                if ( isset( $importdatalines[7] ) && strtoupper($importdatalines[7]) == 'YES' ) 
                      $importcompetition = 1;
                else
                      $importcompetition = 0;
                
                if ( isset( $importdatalines[8] ) ) 
                      $importcomment = str_replace( '"', '', $importdatalines[8] );
                else 
                      $importcomment = '';
                
                if ( isset( $importdatalines[9] ) ) 
                      $importlocation = $importdatalines[9];
                else 
                      $importlocation = '';
                
                if ( isset( $importdatalines[10] ) ) $importdatalines[10] = str_replace( ',', '.', $importdatalines[10] );
                if ( isset($importdatalines[10]) && is_numeric( $importdatalines[10] ) )
                { 
                      $importweight = $this->Unitcalc->check_weight( $importdatalines[10], 'save', 'single' );
                } elseif ( isset( $importdatalines[10] ) && $importdatalines[10] == '' )
                {
                      $importweight = '';
                } else 
                {
                      $import_error .= '<br />' . __('Weight', true) . ' ' . __('is not valid!', true);
                      $importweight = '';     
                }

                if ( isset( $importdatalines[11] ) ) 
                      $importurl = $importdatalines[11];
                else 
                      $importurl = '';
                
                if ( isset( $import_error ) && $import_error == '' ) 
                {
                  $sql = "SELECT * FROM Trainingstatistics WHERE user_id = $session_userid AND " .
                      "date = '" . $importdate . "' AND sportstype = '" . $importsport . "' AND " .
                      "duration = " . $importduration;
                  //echo $sql . '<br />';    
                  $checktrainingdata = $this->Trainingstatistic->query( $sql );
                  //pr($checktrainingdata);
                  if ( count($checktrainingdata) > 0 ) $import_error .= '<br />' . __('Workout already existing!', true);
                }
                                                      
if ( isset( $import_error ) && $import_error == '' ) 
{
  
  $newimportfilearray[] = 
  $importdatalines[0] . ';' .
  $importdatalines[1] . ';' .
  $importdatalines[2] . ';' .
  $importdatalines[3] . ';' .
  $importdatalines[4] . ';' .
  $importdatalines[5] . ';' .
  $importdatalines[6] . ';' .
  $importdatalines[7] . ';' .
  $importdatalines[8] . ';' .
  $importdatalines[9] . ';' .
  $importdatalines[10] . ';' .
  $importdatalines[11] . ';';
  
  if ( isset( $this->data['Trainingstatistic']['hiddenimportfile'] ) )
  {
    
      $data['avg_pulse'] = $importheartrate;
      $data['duration'] = $importduration;
      $data['birthday'] = $results['User']['birthday'];
      $data['weight'] = $importweight;
      $data['gender'] = $results['User']['gender'];
      
      // calculate kcal for workout    
      $kcal = $this->Unitcalc->calc_kcal( $data );
      
      $time_in_zones = "";
      $trimp = round(
          $this->Unitcalc->calc_trimp( 
            $importduration/60, 
            $importheartrate, 
            $time_in_zones, 
            $results['User']['lactatethreshold'],
            $importsport 
            )
      );

      $avg_speed = round( ( $importdistance / ( $importduration / 3600 ) ), 2); 

      $sql = "INSERT INTO Trainingstatistics (id, user_id, name, date, sportstype, distance, 
        duration, avg_pulse, avg_speed, trimp, kcal, location, weight, comment, testworkout, 
        competition, workout_link, created, modified) VALUES (" .
        "null, " . 
        $session_userid . ",'" . 
        $importname . "', '" . 
        $importdate . "', '" .
        $importsport . "', '" .
        $importdistance . "', '" .
        $importduration . "', '" .
        $importheartrate . "', '" .
        $avg_speed . "', '" .
        $trimp . "', '" .
        $kcal . "', '" .
        $importlocation . "', '" .
        $importweight . "', '" .
        $importcomment . "', '" .
        $importworkout . "', '" .
        $importcompetition . "', '" .
        $importurl . "', '" .
        date( 'Y-m-d H:i:s', time() ) . "', '" .
        date( 'Y-m-d H:i:s', time() ) . "')";

      $sqlreturn = $this->Trainingstatistic->query( $sql );

  }
     
/**
  $importdate . ';' .
//  $importtime . ';' . 
  $importname . ';' . 
  $importsport . ';' . 
  $importduration . ';' . 
  $importdistance . ';' . 
  $importheartrate . ';' .
  $importworkout . ';' . 
  $importcompetition . ';' . 
  $importcomment . ';' . 
  $importlocation . ';' . 
  $importweight . ';' . 
  $importurl;
**/

}

$yesno[0] = __('No', true);
$yesno[1] = __('Yes', true);

if ( isset( $import_error ) && $import_error == '' )
{ 
  $outputfile .= '<tr>' . 
  '<td>' . $importdatalines[0] . '</td>' .
  /**'<td>' . $importtime . '</td>' .**/ 
  '<td>' . $importdatalines[1] . '</td>' . 
  '<td>' . __($importdatalines[2], true) . '</td>' . 
  '<td>' . $importdatalines[3] . '</td>' . 
  '<td>' . $importdatalines[4] . '</td>' . 
/**
  '<td>' . $importheartrate . '</td>' .
  '<td>' . $yesno[$importworkout] . '</td>' . 
  '<td>' . $yesno[$importcompetition] . '</td>' . 
  '<td>' . $importcomment . '</td>' . 
  '<td>' . $importlocation . '</td>' . 
  '<td>' . $importweight . '</td>' . 
  '<td>' . $importurl . '</td>' . 
**/
  '<td style="color:green;font-weight:bold;">' . __('ok', true) . '</td>' .
  '</tr>';
} else
{
  $outputfile .= '<tr>' .
    '<td>' . substr( $importdatalines[0], 0, 10 ) . '</td>' . 
    '<td colspan="4" style="color:red;"><b>' . __('Error', true) . '!</b>' . $import_error . '</td>' .
    '<td style="color:red;font-weight:bold;">' . __('not ok', true) . '</td>' .
    '</tr>';
}

              }  
        }

        if ( $this->data['Trainingstatistic']['hiddenimportfile'] )
        {
            $this->Session->setFlash(__('Import of workouts finished!', true));
            $this->set('statusbox', $statusbox);
            $this->redirect(array('controller' => 'Trainingstatistics', 'action' => 'list_trainings'));
        }  

        $this->data['Trainingstatistic']['hiddenimportfile'] = serialize($newimportfilearray);
        
        $this->set('importdata', $importdata);
        $this->set('newimportfile', serialize($newimportfile));
        $this->set('outputfile', $outputfile);

      }
    }
    $this->set('statusbox', $statusbox);
  }

  /** protect method by adding _ in front of the name **/
  function _save_file($file, $userid, $type = "image", $addthis = "")
  {
    //$num_args = func_num_args();
    //$arg_list = func_get_args();
 
    $destination = Configure::read('App.uploadDir') . 'imports/';
    $weburl = Configure::read('App.serverUrl') . '/files/imports/';

    $unlinkElement = array();
    $type_accepted_images = array("image/jpeg", "image/gif", "image/png");
    $filesize_accepted_images = 200000;

    // none
    $type_accepted_files = array("application/vnd.ms-excel");
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
                     
                     if ( !isset( $this->data['Trainingstatistic']['weight'] ) )
                          $this->data['Trainingstatistic']['weight'] = $this->Unitcalc->check_weight( $results['User']['weight'], 'show', 'single' );
                     
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
                            $data['avg_pulse'] = $this->data['Trainingstatistic']['avg_pulse'];
                            $data['duration'] = $this->data['Trainingstatistic']['duration'];
                            $data['birthday'] = $results['User']['birthday'];
                            $data['weight'] = $results['User']['weight'];
                            $data['gender'] = $results['User']['gender'];
  
                            // calculate kcal for workout
                            $this->data['Trainingstatistic']['kcal'] = 
                                $this->Unitcalc->calc_kcal( $data );
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

                     if ( isset( $this->data['Trainingstatistic']['weight'] ) && $this->data['Trainingstatistic']['weight'] != '' )
                     { 
                          $saveweight = $this->Unitcalc->check_weight( $this->data['Trainingstatistic']['weight'], 'save', 'single' );
                          $saveweight = str_replace( ',', '.', $saveweight );
                     } else
                          $saveweight = $results['User']['weight'];

                     $this->data['Trainingstatistic']['weight'] = $saveweight;
                                            
                     // save workout for user 
                     if ($this->Trainingstatistic->save( $this->data, array('validate' => true)))
                     {
                          $this->User->id = $session_userid;
                          if ( isset( $saveweight ) && $saveweight > 0 ) $this->User->savefield('weight', $saveweight, false);
                          
                          $this->Session->setFlash(__('Training saved.',true));
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

                     if ( isset( $this->data['Trainingstatistic']['weight'] ) )
                     {
                          $this->data['Trainingstatistic']['weight'] = $this->Unitcalc->check_weight($this->data['Trainingstatistic']['weight'], 'show', 'single' );
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

            //pr($trainingdata);
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

            if ( isset( $max_unit ) && $max_unit < 1 ) $max_unit = 50;
            
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

            if ( empty( $this->data['Trainingstatistic']['sportstype'] ) ) 
                  $this->data['Trainingstatistic']['sportstype'] = '';

            // select all test-workouts grouped by sportstype
            $sql = "SELECT name, distance, sportstype, count(*) as ccount FROM Trainingstatistics WHERE testworkout = 1 " .
                 "AND user_id = $session_userid AND name != '' AND ";
            $sql .= "( date BETWEEN '" . $start . "' AND '" . $end . "' ) GROUP BY name, distance, sportstype HAVING ccount > 1 ORDER BY name, distance";
            $testworkoutsfilter = $this->Trainingstatistic->query( $sql );

            if ( !empty( $this->data['Trainingstatistic']['search'] ) ) 
                $searchfilter = $this->data['Trainingstatistic']['search'];
            else 
                $searchfilter = '';

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
          $diff_week = 0;
          
          // type of graph
          $type = $this->params['named']['type'];

          $start = $this->params['named']['start'];
          $end = $this->params['named']['end'];
          if ( $targetweightdate && $targetweight ) { $end = $targetweightdate; } 
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
          
          if ( $lastentry > 0 )
          {
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
          
            $this->set('start', $start);
            $this->set('end', $end);
            if ( isset( $diff_week ) ) $this->set('diffweek', $diff_week);
            if ( isset( $diff_weight ) ) $this->set('diffweight', $diff_weight);
            if ( isset( $diff_per_week ) ) $this->set('diff_per_week', $diff_per_week);
            if ( isset( $lastweight ) ) $this->set('lastweight', $lastweight);
            if ( isset( $targetweight ) ) $this->set('targetweight', $targetweight);
            $this->set('maxweeks', $weeks_between_dates);
            $this->set('weeks', $weeks);
            $this->set('trainings2', $train);
            $this->set('weight_unit', $unit['weight']);
          }
          $this->set('stype', $type);
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

            $session_userid = $this->Session->read('session_userid');

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
                  $this->set('statusbox', 'errorbox');
                  $this->redirect(array('controller' => 'Trainingstatistics', 'action' => 'list_trainings'));
               }
            }

            $this->Trainingstatistic->delete($id);
            
            $this->set('statusbox', 'statusbox');
            $this->Session->setFlash(__('Workout deleted.',true));
            $this->redirect(array('action'=>'list_trainings'));
   }
}

?>