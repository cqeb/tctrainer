<?php

class TrainingstatisticsController extends AppController {
   var $name = 'Trainingstatistics';

   var $helpers = array('Html', 'Form', 'Javascript', 'Time', 'Session', 'Ofc', 'Unitcalc', 'Xls', 'Statistics');
   var $components = array('Email', 'Cookie', 'RequestHandler', 'Session', 'Unitcalc', 'Statisticshandler', 'Transactionhandler', 'Provider');

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

            $trainingstatistics = $this->paginate('Trainingstatistic');
            
            $this->set('trainingstatistics', $trainingstatistics);
            $this->set('statusbox', $statusbox);
  }

  function import_workout()
  {
	    $this->set("title_for_layout", __('Import workouts',true));
	    $this->checkSession();
	    $statusbox = 'statusbox';
	
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
                
                $app_backslash = Configure::read('App.Dirbackslash');

                $importfile = Configure::read('App.uploadDir') . 'imports/' . $return['filename'];
                
	          if ( $_SERVER['HTTP_HOST'] == 'localhost' )
              {
                  if ( isset( $app_backslash ) && $app_backslash == true ) 
                        $importfile = str_replace( '/', '\\', $importfile);
                  //$importfile = str_replace( 'files\\', 'app\\webroot\\files\\', $importfile);                  
              } else
              {
                  //$importfile = str_replace( 'files/', 'app/webroot/files/', $importfile);                  
              }
	  
	          $importdata = file( $importfile );
	
	        } else
	        {
                //pr($this->data['Trainingstatistic']['hiddenimportfile']);
	          $importdata = unserialize(urldecode($this->data['Trainingstatistic']['hiddenimportfile']));
	        }
	
              if ( count($importdata) < 2 ) {
                  if ( is_array( $importdata ) ) {
                      $importdata = implode("",$importdata);
                      $importdata = explode("\r",$importdata);
                  }
              }
              if ( count($importdata) < 2 ) {
                  if ( is_array( $importdata ) ) {
                      $importdata = implode("",$importdata);
                      $importdata = explode("\r\n",$importdata);
                  }
              }
              
	        if ( !isset( $importdata ) || ( count($importdata) < 2 ) )  
	        {
	            $this->Session->write('flash',__('No import data found!', true));
	            $this->set('statusbox', $statusbox);
	            $this->redirect(array('controller' => 'trainingstatistics', 'action' => 'list_trainings'));
	            die();
	        }
	
	        $check_sport = array( 'RUN', 'BIKE', 'SWIM' );
	
	        foreach ( $importdata as $key => $value )
	        {
	
	              if ( $key > 0 ) 
	              {
	                $import_error = '';
	                if ( !$this->Unitcalc->is_utf8($value) ) $value = utf8_encode( $value );
	
	                $idl = split( ";", $value ); // importdatalines
					if ( isset( $idl[0] ) ) $importdate = $importdate_orig = $idl[0];
					else $importdate = '';
					
					if ( isset( $idl[1] ) ) $importsport = $importsport_orig = $idl[1];
					else $importsport = '';
					
					if ( isset( $idl[2] ) ) $importdistance = $importdistance_orig = $idl[2];
					else $importdistance = '';
					
					if ( isset( $idl[3] ) ) $importduration = $importduration_orig = $idl[3];
					else $importduration = '';
					
					if ( isset( $idl[4] ) ) $importheartrate = $idl[4];
					else $importheartrate = '';
					
					/*
					if ( isset( $idl[5] ) ) $importtestworkout = $idl[5];
					else $importtestworkout = '';
					*/
					
					if ( isset( $idl[5] ) ) $importname = $importname_orig = $idl[5];
					else $importname = '';
					
					if ( isset( $idl[6] ) ) $importweight = $idl[6];
					else $importweight = '';
					
					if ( isset( $idl[7] ) ) $importcomment = $idl[7];
					else $importcomment = '';
					
					if ( isset( $idl[8] ) ) $importcompetition = $idl[8];
					else $importcompetition = '';
	
					if ( isset( $idl[9] ) ) $importlocation = $idl[9];
					else $importlocation = '';
					
					if ( isset( $idl[10] ) ) $importworkoutlink = $idl[10];
					else $importworkoutlink = '';
	
	                if ( strtotime( $importdate ) )
	                { 
	                      $importdate = $this->Unitcalc->check_date( $importdate, 'save' );
	                      if ( !is_numeric( strtotime( $importdate ) ) ) 
	                      {
	                          $import_error = '<br />' . __('Date', true) . ' ' . __('is not valid!', true);
	                          $importdate = '';
	                      }
	                } else
	                { 
	                      $import_error = '<br />' . __('Date', true) . ' ' . __('is not valid!', true);
	                      $importdate = '';
	                }
	
	                if ( isset( $importsport ) && in_array( strtoupper($importsport), $check_sport ))
	                {
	                      $importsport =  strtoupper($importsport);
	                } else
	                {
	                      if ( isset( $importsport ) ) $missingsport = ' (' . $importsport . ')';
	                      else $missingsport = '';
	                                        
	                      $import_error .= '<br />' . __('Sport', true) . ' ' . __('is not valid!', true) . $missingsport;
	                      $importsport = '';
	                }
	                
	                if ( isset( $importdistance ) ) 
	                      $importdistance = str_replace( ',', '.', $importdistance );
	                if ( isset( $importdistance ) && is_numeric( $importdistance ) )
	                { 
	                      $importdistance = $this->Unitcalc->check_distance( $importdistance, 'save', 'single' );
	                } else
	                {
	                      $import_error .= '<br />' . __('Distance', true) . ' ' . __('is not valid!', true);
	                      $importdistance = '';
	                }
	                
	                if ( isset( $importduration ) ) 
	                {
	                    $importdurationarray = split( ':', $importduration );
	                
	                    if ( is_numeric($importdurationarray[0]) && is_numeric($importdurationarray[1]) && is_numeric($importdurationarray[2]) )
	                    {
	                          $importduration = $this->Unitcalc->time_to_seconds($importduration);
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
	
	                if ( isset( $importheartrate ) && is_numeric($importheartrate) )
	                {
	                      //$importheartrate = $importdatalines[5];
	                } else
	                {
	                      $import_error .= '<br />' . __('Avg. heart rate', true) . ' ' . __('is not valid!', true);
	                      $importheartrate = '';
	                }
	                
	                /*
					if ( isset( $importtestworkout ) && strtoupper($importtestworkout) == 'YES' ) 
	                      $importtestworkout = 1;
	                else
	                      $importtestworkout = 0;
					*/
	                      
	                if ( isset( $importcompetition ) && strtoupper($importcompetition) == 'YES' ) 
	                      $importcompetition = 1;
	                else
	                      $importcompetition = 0;
	                
	                if ( isset( $importcomment ) ) 
	                      $importcomment = str_replace( '"', '', $importcomment );
	                else 
	                      $importcomment = '';
	                
	                if ( isset( $importlocation ) && strlen( $importlocation ) > 1 ) 
	                      $importlocation = $importlocation;
	                else 
	                      $importlocation = '';
	                
	                if ( isset( $importweight ) ) 
	                		$importweight = str_replace( ',', '.', $importweight );
	
	                if ( isset( $importweight ) && is_numeric( $importweight ) )
	                { 
	                      $importweight = $this->Unitcalc->check_weight( $importweight, 'save', 'single' );
	                } elseif ( isset( $importweight ) && $importweight == '' )
	                {
	                      $importweight = '';
	                } else 
	                {
	                      $import_error .= '<br />' . __('Weight', true) . ' ' . __('is not valid!', true);
	                      $importweight = '';     
	                }
	
	                if ( isset( $import_error ) && $import_error == '' ) 
	                {
	                  	$sql = "SELECT * FROM trainingstatistics WHERE user_id = $session_userid AND " .
	                      "date = '" . $importdate . "' AND sportstype = '" . $importsport . "' AND " .
	                      "duration = " . $importduration;
	                  	$checktrainingdata = $this->Trainingstatistic->query( $sql );
	                  	if ( count($checktrainingdata) > 0 ) 
	                  		$import_error .= '<br />' . __('Workout already existing!', true);
	                }
	                                                      
	if ( isset( $import_error ) && $import_error == '' ) 
	{
	  
		  $newimportfilearray[] = $value; 
	  
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
		
		      $sql = "INSERT INTO trainingstatistics (id, user_id, name, date, sportstype, distance, 
		        duration, avg_pulse, avg_speed, trimp, kcal, location, weight, comment, 
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
		        //$importtestworkout . "', '" .
		        $importcompetition . "', '" .
		        $importworkoutlink . "', '" .
		        date( 'Y-m-d H:i:s', time() ) . "', '" .
		        date( 'Y-m-d H:i:s', time() ) . "')";
		
		      $sqlreturn = $this->Trainingstatistic->query( $sql );
		
		  }
	     
	}
	
	$yesno[0] = __('No', true);
	$yesno[1] = __('Yes', true);
	
	if ( isset( $import_error ) && $import_error == '' )
	{ 
		  $outputfile .= '<tr>' . 
			  '<td>' . $importdate_orig . '</td>' .
			  '<td>' . $importname_orig . '</td>' . 
			  '<td>' . __($importsport_orig, true) . '</td>' . 
			  '<td>' . $importdistance_orig . '</td>' . 
			  '<td>' . $importduration_orig . '</td>' . 
			  '<td style="color:green;font-weight:bold;">' . __('ok', true) . '</td>' .
			  '</tr>';
	} else
	{
		  $outputfile .= '<tr>' .
		    '<td>' . substr( $importdate_orig, 0, 10 ) . '</td>' . 
		    '<td colspan="4" style="color:red;"><b>' . __('Error', true) . '!</b>' . $import_error . '</td>' .
		    '<td style="color:red;font-weight:bold;">' . __('not ok', true) . '</td>' .
		    '</tr>';
	}
	
	              }  
	        }
	
	        if ( isset( $this->data['Trainingstatistic']['hiddenimportfile'] ) )
	        {
	            $this->Session->write('flash',__('Import of workouts finished!', true));
	            $this->set('statusbox', $statusbox);
	            $this->redirect(array('controller' => 'trainingstatistics', 'action' => 'list_trainings'));
	        }  
	
            //pr(urldecode(urlencode(serialize($newimportfilearray))));
                                                                      
	        $this->data['Trainingstatistic']['hiddenimportfile'] = urlencode(serialize($newimportfilearray));
	        
	        $this->set('importdata', $importdata);
	        $this->set('newimportfile', urlencode(serialize($newimportfile)));
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
    $type_accepted_files = array("application/vnd.ms-excel","text/csv");
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
            $return['filename'] = $new_name;
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

function edit_training($id = null) {
		$this->checkSession();
	  	$this->layout = 'default_trainer';
	  	$this->set('js_addon','');
	  	$unit = $this->Unitcalc->get_unit_metric();
	  	$statusbox = '';
	
	  	$session_userid = $this->Session->read('session_userid');
	  	$results['User'] = $this->Session->read('userobject');

	  	if ( empty($this->data) ) {
	  		$statusbox = 'statusbox';
	  		// security check - don't view workouts of other users
	  		if ( $id ) {
	  			$result = $this->Trainingstatistic->find ('all',
	  			array('conditions' =>
	  			array( 'and' =>
	  			array( 'id' => $id, 'user_id' => $session_userid )
	  			)));
	  			if ( isset( $result[0] ) ) {
	  				$this->data = $result[0];
	  			} else {
	  				$this->Session->write('flash',__('Sorry. This is not your entry!', true));
	  				$this->set('statusbox', $statusbox);
	  				$this->redirect(array('controller' => 'trainingstatistics', 'action' => 'list_trainings'));
	  			}
	  		}
	
	  		if ( isset( $this->data['Trainingstatistic']['duration'] ) )
	  		$this->data['Trainingstatistic']['duration'] = $this->Unitcalc->seconds_to_time( $this->data['Trainingstatistic']['duration'] );
	
	  		if ( isset( $this->data['Trainingstatistic']['distance'] ) )
	  		{
	  			$distance = $this->Unitcalc->check_distance( $this->data['Trainingstatistic']['distance'], 'show' );
	  			$this->data['Trainingstatistic']['distance'] = $distance['amount'];
	  		}
	
	  		if ( isset( $this->data['Trainingstatistic']['weight'] ) )
	  		$this->data['Trainingstatistic']['weight'] = round( $this->Unitcalc->check_weight( $results['User']['weight'], 'show', 'single' ), 1);
	
	  	} else {
	  		$statusbox = 'statusbox';
	
	  		// check for metric / unit
	  		if ( isset( $this->data['Trainingstatistic']['distance'] ) ) {
	  			$remove_array = array( ' ', 'km', 'mi' );
	  			$this->data['Trainingstatistic']['distance'] = 
	  				str_replace( $remove_array, '', $this->data['Trainingstatistic']['distance'] );
	  			$this->data['Trainingstatistic']['distance'] = 
	  				$this->Unitcalc->check_distance( $this->Unitcalc->check_decimal( $this->data['Trainingstatistic']['distance'] ), 'save', 'single' );
	  		}

	  		if ( isset( $this->data['Trainingstatistic']['duration'] ) ) {  			$remove_array = array( ' ' );
	  			$this->data['Trainingstatistic']['duration'] = str_replace( $remove_array, '', $this->data['Trainingstatistic']['duration'] );
	  			if ( preg_match( "/,/", $this->data['Trainingstatistic']['duration'] ) || preg_match( "/\./", $this->data['Trainingstatistic']['duration'] ) ) {
	  				$replace_array = array( ',', '.' );
	  				$this->data['Trainingstatistic']['duration'] = str_replace( $replace_array, ':', $this->data['Trainingstatistic']['duration'] );
	  				$this->data['Trainingstatistic']['duration'] = $this->data['Trainingstatistic']['duration'] . ':00';
	  			}
	
	  			if ( count( split( ':', $this->data['Trainingstatistic']['duration'] ) ) == 2 )
	  			$this->data['Trainingstatistic']['duration'] = '00:' . $this->data['Trainingstatistic']['duration'];
	  			$this->data['Trainingstatistic']['duration'] = $this->Unitcalc->time_to_seconds( $this->data['Trainingstatistic']['duration'] );
	  		}
	
	  		if ( $this->data['Trainingstatistic']['avg_pulse'] < 1 ) {
	  			if ( $this->data['Trainingstatistic']['sportstype'] == 'SWIM' ) {
	  				$factor = 0.85;
	  			} else {
	  				$factor = 0.89;
	  			}
	  			$this->data['Trainingstatistic']['avg_pulse'] = round( $results['User']['lactatethreshold'] * $factor );
	  		}
	
	  		if ( ( isset( $this->data['Trainingstatistic']['duration'] ) && $this->data['Trainingstatistic']['duration'] > 0 ) && $this->data['Trainingstatistic']['distance'] && $this->data['Trainingstatistic']['avg_pulse'] ) {
	  			$time_in_zones = "";
	  			$this->data['Trainingstatistic']['trimp'] = round(
	  				$this->Unitcalc->calc_trimp(
		  				$this->data['Trainingstatistic']['duration']/60,
		  				$this->data['Trainingstatistic']['avg_pulse'],
		  				$time_in_zones,
		  				$results['User']['lactatethreshold'],
		  				$this->data['Trainingstatistic']['sportstype']
	  			));
	  			 
	  			$this->data['Trainingstatistic']['avg_speed'] = round( ( $this->data['Trainingstatistic']['distance'] / ( $this->data['Trainingstatistic']['duration'] / 3600 ) ), 2);
	
	  			if ( $results['User']['gender'] && $results['User']['weight'] && $results['User']['birthday'] ) {
	  				$data['avg_pulse'] = $this->data['Trainingstatistic']['avg_pulse'];
	  				$data['duration'] = $this->data['Trainingstatistic']['duration'];
	  				$data['birthday'] = $results['User']['birthday'];
	  				$data['weight'] = $results['User']['weight'];
	  				$data['gender'] = $results['User']['gender'];
	
	  				// calculate kcal for workout
	  				$this->data['Trainingstatistic']['kcal'] =
	  				$this->Unitcalc->calc_kcal( $data );
	  			}
	
	  			
	  		}
	
	  		$this->data['Trainingstatistic']['user_id'] = $session_userid;
	
	  		$tdate = $this->data['Trainingstatistic']['date'];
	  		$tdate = $tdate['year'] . '-' . $tdate['month'] . '-' . $tdate['day'];
	
	  		if ( isset( $this->data['Trainingstatistic']['weight'] ) && $this->data['Trainingstatistic']['weight'] > 0 && ( strtotime( $tdate ) > ( time() - ( 86400 * 7 ) ) ) ) {
	  			$this->data['Trainingstatistic']['weight'] = str_replace( ',', '.', $this->data['Trainingstatistic']['weight'] );
	  			$saveweight = $this->Unitcalc->check_weight( $this->data['Trainingstatistic']['weight'], 'save', 'single' );
	  		} else {
	  			$saveweight = $results['User']['weight'];
	  		}
	
	  		$this->data['Trainingstatistic']['weight'] = $saveweight;
	
	  		// save workout for user
	  		if ($this->Trainingstatistic->save( $this->data, array('validate' => true))) {
	  			$this->User->id = $session_userid;
	  			if ( isset( $saveweight ) && $saveweight > 0 ) {
	  				$this->User->savefield('weight', $saveweight, false);
	  			}
	  			$this->Session->write('flash',__('Training saved.',true));
	  			$this->set('statusbox', $statusbox);
	  			$this->redirect(array('controller' => 'trainingstatistics', 'action' => 'list_trainings'));
	  		} else {
	  			$statusbox = 'statusbox error';
	  			$this->Session->write('flash',__('Some errors occured',true));
	  		}
	
	  		if ( isset( $this->data['Trainingstatistic']['duration'] ) ) {
	  			$this->data['Trainingstatistic']['duration'] = $this->Unitcalc->seconds_to_time( $this->data['Trainingstatistic']['duration'] );
	  		}
	
	  		if ( isset( $this->data['Trainingstatistic']['distance'] ) ) {
	  			$distance = $this->Unitcalc->check_distance( $this->data['Trainingstatistic']['distance'], 'show' );
	  			$this->data['Trainingstatistic']['distance'] = $distance['amount'];
	  		}
	
	  		if ( isset( $this->data['Trainingstatistic']['weight'] ) ) {
	  			$this->data['Trainingstatistic']['weight'] = round( $this->Unitcalc->check_weight($this->data['Trainingstatistic']['weight'], 'show', 'single' ), 1);
	  		}
	  	}
	
	  	// build course name autocomplete data
	  	$courseNames = $this->Trainingstatistic->query("SELECT name, count(name) count
	  		FROM trainingstatistics
	  		WHERE name != ''
	  		AND user_id = " . $session_userid . "
	  		GROUP BY name
	  		ORDER BY count DESC, name ASC");
		$cnames = array();
		
	  	while (list($k,$v) = each($courseNames)) {
	  		$cnames[] = '"' . str_replace(
	  			'"', '\"',
	  			$v['trainingstatistics']['name']) . '"';
	  	}
	  	if ( is_array( $cnames ) ) 
	  		$courseNamesAutocomplete = '[' . implode(',', $cnames) . ']';
	  	
	  	// build workout type selectors
	  	$sports = array('Swim', 'Bike', 'Run');
	  	$types = array('E', 'S', 'M', 'F', 'T', 'C');
	  	$workouts = array();
	  	while (list($k, $sport) = each($sports)) {
	  		reset($types);
	  		while (list($l, $type) = each($types)) {
	  			$label = true;
	  			$i = 0;
	  			while ($label) {
		  			$i++;
		  			$t = $type . $i;
		  			$workouts[$sport][''] = __('Pick workout type', true);
	  				switch ($sport) {
		  				case 'Swim':
		  					$label = SwimWorkout::getTypeLabel($t);
		  					break;
		  				case 'Bike':
		  					$label = BikeWorkout::getTypeLabel($t);
		  					break;
		  				case 'Run':
		  					$label = RunWorkout::getTypeLabel($t);
		  					break;
		  			}
		  			
		  			// now add the workout
		  			if ($label) {
		  				$workouts[$sport][$t] = $label;
		  			}
	  			} 
	  		}
	  	}
	  	
	  	// prefill data from get variables
	  	if ($this->data['Trainingstatistic'] === null && isset( $_GET['sportstype']) ) {
	  		$this->data['Trainingstatistic'] = array(
	  			'avg_pulse' => $_GET['avghr'],
	  			'sportstype' => $_GET['sportstype'],
	  			'workouttype' => $_GET['workouttype'],
	  			'duration' => $_GET['duration']
	  		// sportstype workouttype distance duration
	  		);
	  	}

	  	// set template variables
	  	$this->set('bikezones', $this->Provider->getAthlete()->getZones('BIKE'));
	  	$this->set('runzones', $this->Provider->getAthlete()->getZones('RUN'));
	  	$this->set('workouts', $workouts);
	  	$this->set('user', $results['User']);
	  	$this->set('unit', $unit);
	  	$this->set('courseNamesAutocomplete', $courseNamesAutocomplete);
	  	$this->set('statusbox', $statusbox);
	  	$this->set('data', $this->data['Trainingstatistic']);
	}

   // how fit am I?
   function statistics_trimp()
   {
            $this->checkSession();
            $this->set('js_addon','');
            $unit = $this->Unitcalc->get_unit_metric();
            $statusbox = 'statusbox ok';

            $results['User'] = $this->Session->read('userobject');
            $session_userid = $results['User']['id'];

			// automatic default date chooser
			$choosedates = $this->Statisticshandler->choose_daterange( $results, $this->data, 'trimp_date' );

			// set form-fields of search form
			$this->data['Trainingstatistic']['fromdate'] = $start = $choosedates['start'];
			$this->data['Trainingstatistic']['todate'] = $end = $choosedates['end'];

			// if no sport is set, set "All"
            if ( !isset( $this->data['Trainingstatistic']['sportstype'] ) && $this->Session->read( 'trimp_sportstype' ) )
			{ 
                    $this->data['Trainingstatistic']['sportstype'] = $this->Session->read( 'trimp_sportstype' );
			} elseif ( empty( $this->data['Trainingstatistic']['sportstype'] ) )
			{
                    $this->data['Trainingstatistic']['sportstype'] = '';
			} 

            $sportstype = $this->data['Trainingstatistic']['sportstype'];

			$trainingdata_ownuser = $this->Statisticshandler->get_trimps( $this->Trainingstatistic, $session_userid, $sportstype, $start, $end );

			// in case we don't have data we set startdate to the date of first data
			if ( isset( $trainingdata_ownuser[0] ) && ( strtotime( $start ) < strtotime( $trainingdata_ownuser[0]['trainingstatistics']['date'] ) ) )
			{
					$start = $this->data['Trainingstatistic']['fromdate'] = $trainingdata_ownuser[0]['trainingstatistics']['date'];
			}

			// save dates chosen in session 
			$this->Session->write( 'trimp_date_from', $start );
			$this->Session->write( 'trimp_date_to', $end );
			$this->Session->write( 'trimp_sportstype', $sportstype );
						
            $this->set('start', $start);
            $this->set('end', $end);
            $this->set('sportstype', $sportstype);
            $this->set('length_unit', $unit['length']);
            $this->set('statusbox', $statusbox);
			$this->set('trainingdatas', $trainingdata_ownuser);
   }

   // JSON for "how fit am I"
   function statistics_trimp_json()
   {
            $this->checkSession();
            $this->layout = "ajaxrequests";
       	    $this->RequestHandler->setContent('js', null);
            if ( $_SERVER['HTTP_HOST'] == 'localhost' ) Configure::write('debug', 1);
			else Configure::write('debug', 0);

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
            // we need 42 days (CTL) and 7 days (ATL) of data more than requested
            // http://www.flammerouge.je/content/3_factsheets/constant/trainstress.htm
            // TSS/d
            if ( $graphtype == 'chronic' )
			{
			   $timeperiod = 42;
			   $graphtitle = 'CTL';
            } elseif ( $graphtype == 'acute' )
			{
			   $timeperiod = 6;
			   $graphtitle = 'ATL';
			}

			$competitor_userid = 8;
			$ownuser = $this->Statisticshandler->get_trimps_json( $timeperiod, $sportstype, $graphtype, $start, $end, $session_userid, $this->Trainingstatistic );
			// not yet finished
			//$competitoruser = $this->Statisticshandler->get_trimps_json( $timeperiod, $sportstype, $graphtype, $start, $end, $competitor_userid, $this->Trainingstatistic );
			$competitoruser = array();
			
            $this->set('start', $ownuser['start']);
            $this->set('end', $ownuser['end']);
            $this->set('max_unit', $ownuser['max_unit']);
            $this->set('userobject', $results['User']);
            $this->set('trimp_tl_done', $ownuser['trimp_tl_done']);
            $this->set('trimp_tl_planned', $ownuser['trimp_tl_planned']);
			//$this->set('trimp_tl_competitor', $competitoruser['trimp_tl_done']);
            $this->set('trimp_dates', $ownuser['trimp_dates']);
			$this->set('timeperiod', $timeperiod);
			$this->set('graphtitle', $graphtitle);
            $this->set('graphtype', $graphtype);
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

			// automatic default date chooser
			$choosedates = $this->Statisticshandler->choose_daterange( $results, $this->data, 'formcurve_date' );

			// set form-fields of search form
			$this->data['Trainingstatistic']['fromdate'] = $start = $choosedates['start'];
			$this->data['Trainingstatistic']['todate'] = $end = $choosedates['end'];

            if ( !empty( $this->data['Trainingstatistic']['search'] ) ) 
                $searchfilter = $this->data['Trainingstatistic']['search'];
			elseif ( $this->Session->read( 'formcurve_search' ) )
				$searchfilter = $this->Session->read( 'formcurve_search' );
			else
                $searchfilter = '';

			$testworkoutsfilter = $this->Statisticshandler->get_formcurve( $this->Trainingstatistic, $session_userid, "", $start, $end );

			// save dates chosen in session 
			$this->Session->write( 'formcurve_date_from', $start );
			$this->Session->write( 'formcurve_date_to', $end );
			$this->Session->write( 'formcurve_search', $searchfilter );

            $this->set('start', $start);
            $this->set('end', $end);
            //$this->set('sportstype', $this->data['Trainingstatistic']['sportstype']);
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
            if ( $_SERVER['HTTP_HOST'] == 'localhost' ) Configure::write('debug', 1);
			else Configure::write('debug', 0);

            $this->set('js_addon','');
            $unit = $this->Unitcalc->get_unit_metric();
            $statusbox = '';

            $results['User'] = $this->Session->read('userobject');
            $session_userid = $this->Session->read('session_userid');

            $searchfilter = base64_decode( $this->params['named']['searchfilter'] );
            $start = $this->params['named']['start'];
            $end = $this->params['named']['end'];

			$formcurve = $this->Statisticshandler->get_formcurve_json( $searchfilter, $start, $end, $session_userid, $this->Trainingstatistic, $unit );

            $this->set('start', $formcurve['start']);
            $this->set('end', $formcurve['end']);
            $this->set('max_perunit', $formcurve['max_perunit']);
            $this->set('trainings', $formcurve['trainings']);
            $this->set('unit', $formcurve['unit']);

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

			// automatic default date chooser
			$choosedates = $this->Statisticshandler->choose_daterange( $results, $this->data, 'competition_date' );

			// set form-fields of search form
			$this->data['Trainingstatistic']['fromdate'] = $start = $choosedates['start'];
			$this->data['Trainingstatistic']['todate'] = $end = $choosedates['end'];

			$return = $this->Statisticshandler->get_competition( $this->Trainingstatistic, $session_userid, "", $start, $end, $this->data );

            $this->set('start', $return['start']);
            $this->set('end', $return['end']);
            $this->set('sumdata', $return['sumdata']);
            $this->set('total_trimp', $return['total_trimp']);
            $this->set('total_trimp_tp', $return['total_trimp_tp']);
            $this->set('color', $return['color']);
            $this->set('trafficlight_percent', $return['trafficlight_percent']);
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

			// automatic default date chooser
			$choosedates = $this->Statisticshandler->choose_daterange( $results, $this->data, 'weight_date' );

			// set form-fields of search form
			$this->data['Trainingstatistic']['fromdate'] = $start = $choosedates['start'];
			$this->data['Trainingstatistic']['todate'] = $end = $choosedates['end'];

            // select trainingsdata
            $sql = "SELECT * FROM trainingstatistics WHERE user_id = $session_userid AND date BETWEEN '" .
                $start . "' AND '" . $end . "' AND weight > 0";
            $trainings = $this->Trainingstatistic->query( $sql );

			// save dates chosen in session 
			$this->Session->write( 'weight_date_from', $start );
			$this->Session->write( 'weight_date_to', $end );

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
			if ( $_SERVER['HTTP_HOST'] == 'localhost' ) Configure::write('debug', 1);
			else Configure::write('debug', 0);
			
			$this->set('js_addon','');
			$unit = $this->Unitcalc->get_unit_metric();
			$statusbox = '';
			
			$results['User'] = $this->Session->read('userobject');
			$session_userid = $results['User']['id'];
			  
			// type of graph
			$type = $this->params['named']['type'];
			$start = $this->params['named']['start'];
			$end = $this->params['named']['end'];

			$return = $this->Statisticshandler->get_weight_json( $start, $end, $results, $session_userid, $this->Trainingstatistic, $unit );

			if ( $return['lastentry'] > 0 )
			{
				$this->set('start', $return['start']);
				$this->set('end', $return['end']);
				if ( isset( $return['diff_week'] ) ) $this->set('diffweek', $return['diff_week']);
				if ( isset( $return['diff_weight_show'] ) ) $this->set('diffweight', $return['diff_weight_show']);
				if ( isset( $return['diff_per_week_show'] ) ) $this->set('diff_per_week', $return['diff_per_week_show']);
				if ( isset( $return['lastweight_show'] ) ) $this->set('lastweight', $return['lastweight_show']);
				if ( isset( $return['targetweight_show'] ) ) $this->set('targetweight', $return['targetweight_show']);
				$this->set('maxweeks', $return['weeks_between_dates']);
				$this->set('minweight', $return['minweight']);
				$this->set('maxweight', $return['maxweight']);
				$this->set('step', 5);
				$this->set('weeks', $return['weeks']);
				$this->set('trainings2', $return['train']);
				$this->set('weight_unit', $unit['weight']);
			}
   }

   /**
   What have I done?
   **/
   function statistics_whathaveidone()
   {
            $this->checkSession();
            $this->set('js_addon','');
            $unit = $this->Unitcalc->get_unit_metric();
            $statusbox = '';

            $results['User'] = $this->Session->read('userobject');
            $session_userid = $results['User']['id'];

			// automatic default date chooser
			$choosedates = $this->Statisticshandler->choose_daterange( $results, $this->data, 'formcurve_date' );

			// set form-fields of search form
			$this->data['Trainingstatistic']['fromdate'] = $start = $choosedates['start'];
			$this->data['Trainingstatistic']['todate'] = $end = $choosedates['end'];

            if ( isset( $this->data['Trainingstatistic']['sportstype'] ) ) 
                $post_sportstype = $this->data['Trainingstatistic']['sportstype'];
			elseif ( $this->Session->read( 'statistics_sportstype' )  )
				$post_sportstype = $this->Session->read( 'statistics_sportstype' );
			else
                $post_sportstype = '';

            // http://www.dnamique.com/cakephp-export-data-to-excel-the-easy-way/
            $export = false;
            if ( isset( $this->params['form']['excel'] ) ) 
            {
               $export = true;
               $this->layout = "xls";
               Configure::write('debug', 0);
            }

			$return = $this->Statisticshandler->get_statistics( $this->Trainingstatistic, $session_userid, $post_sportstype, $start, $end );
			
			// save dates chosen in session 
			$this->Session->write( 'statistics_date_from', $start );
			$this->Session->write( 'statistics_date_to', $end );
			$this->Session->write( 'statistics_sportstype', $post_sportstype );

            $this->set('start', $return['start']);
            $this->set('end', $return['end']);
            $this->set('export', $export);
            $this->set('sumdata', $return['sumdata']);
            $this->set('trainings', $return['trainings']);
            $this->set('length_unit', $unit['length']);
            $this->set('statusbox', $statusbox);
            $this->set('post_sportstype', $post_sportstype);

   }

   function statistics_whathaveidone_json()
   {
            $this->checkSession();
            $this->layout = "ajaxrequests";
            $this->RequestHandler->setContent('js', null);
            if ( $_SERVER['HTTP_HOST'] == 'localhost' ) Configure::write('debug', 1);
			else Configure::write('debug', 0);

            $this->set('js_addon','');
            $unit = $this->Unitcalc->get_unit_metric();
            $statusbox = '';

            $results['User'] = $this->Session->read('userobject');
            $session_userid = $results['User']['id'];

			$start = $this->params['named']['start'];
			$end = $this->params['named']['end'];

			$return = $this->Statisticshandler->get_statistics_json( $start, $end, $results, $session_userid, $this->Trainingstatistic, $unit, $this->params );
			//$return_competitor = $this->Statisticshandler->get_statistics_json( $start, $end, $results, 8, $this->Trainingstatistic, $unit, $this->params );
			
            $this->set('start', $return['start']);
            $this->set('end', $return['end']);
            $this->set('maxweeks', $return['weeks_between_dates']);
            $this->set('weeks', $return['weeks']);
            $this->set('trainings2', $return['trainings2']);
			//$this->set('trainings2_competitor', $return_competitor['trainings2']);
            $this->set('stype', $return['type']);
            $this->set('maxdistance', $return['maxdistance']*1.1);
            $this->set('maxduration', $return['maxduration']*1.1);
            $this->set('length_unit', $unit['length']);
   }

   function url_redirect($id = null, $userid = null)
   {
        $this->checkSession();
		
		$transaction_id = '';
		$p['smtype'] = $this->params['named']['type'];
		$p['distance'] = $this->params['named']['distance'];
		$p['distance_unit'] = $this->params['named']['distance_unit'];
		$p['duration'] = $this->params['named']['duration'];
		$p['sport'] = $this->params['named']['sport'];
		$p['userid'] = $this->Session->read('session_userid');
	
		// information is saved in transactions
		$this->loadModel('Transaction');

		$save_p = serialize( $p );
		$transaction_id = $this->Transactionhandler->handle_transaction( $this->Transaction, null, 'create', 'sm_recommend', $save_p );
		 
		if ( $p['smtype'] == 'facebook' )
		{
			$socialmedia_url = 'http://www.facebook.com/sharer.php?u=http://tricoretraining.com' .  
				'/trainer/starts/index/u:' . $transaction_id;
		} elseif ( $p['smtype'] == 'twitter' )
		{
			$twittertext =
			__('I did a', true) . ' ' . $p['distance'] . ' ' . $p['distance_unit'] . ' ' . 
			__($p['sport'] . ' workout', true) . ' ' . __('in',true) . ' ' . $p['duration'] . 
			' ' . __('hour(s)',true) . ' ' . __('with', true) . ' ' . 
			'http://tricoretraining.com/?u=' . $transaction_id; 
			
			$socialmedia_url = 'http://twitter.com/?status=' . urldecode( substr( $twittertext, 0, 140 ) );
		}

		$this->redirect( $socialmedia_url );
		
		$this->autoRender = false;
		
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
                  $this->Session->write('flash',__('Sorry. This is not your entry!', true));
                  $this->set('statusbox', 'statusbox error');
                  $this->redirect(array('controller' => 'trainingstatistics', 'action' => 'list_trainings'));
               }
            }

            $this->Trainingstatistic->delete($id);
            
            $this->set('statusbox', 'statusbox');
            $this->Session->write('flash',__('Workout deleted.',true));
            $this->redirect(array('action'=>'list_trainings'));
	}

    function garmin_import()
    {                                                       
           $debug = true;                                            
           $this->layout = "ajaxrequests";
           if ( $debug == true ) echo "before check" . "<br>";
           //$this->checkSession();
           
           $session_userid = $this->Session->read('session_userid');
           if ( $debug == true ) echo "userid: " . $session_userid . "<br>";
           $mainpath = $_SERVER['DOCUMENT_ROOT'] . '/trainer/app/webroot/garmin/';
           
           include( $mainpath . 'xml2array.php' );
           $key = serialize( $_POST );
           $key_md5 = md5( $key );
                                                       
           $filename = $mainpath . 'cache/course.' . $key_md5 . '.txt';
           
           $logfile  = $mainpath . 'cache/garminlog.txt';
           
           $logcontent = '----------------------------------------------------------------<br>';
           unset( $tdata ); 
           
           if ( isset( $_POST ) ) 
           {
                if ( isset( $_POST['activities'] ) ) 
                {
                    $somecontent = xml2array( $_POST['activities'] );
                    // Problem if there are more laps
                    $tarray = $somecontent['TrainingCenterDatabase']['Activities']['Activity']['Lap'];
                    if ( $debug == true ) 
                    {
                            print_r( $tarray );
                            echo "<br><br>";
                            echo $tarray['TotalTimeSeconds'] . ' Sec.<br>';
                            echo $tarray['DistanceMeters'] . ' m.<br>';
                            echo $tarray['AverageHeartRateBpm'] . '<br>';
                            echo $somecontent['TrainingCenterDatabase']['Activities']['Activity']['Id'] . '<br>';
                    }
                    $tdata['time'] = round( $tarray['TotalTimeSeconds']/60, 1);
                    $tdata['distance'] = round( $tarray['DistanceMeters']/1000, 1);
                    $tdata['hr'] = $tarray['AverageHeartRateBpm']['Value'];
                    $tdata['date'] = date('Y-m-d H:i', strtotime($somecontent['TrainingCenterDatabase']['Activities']['Activity']['Id'])) . "<br>";
                    print_r( $tdata );
                    $logcontent .= "Object in POST - ok (" . $key_md5 . ")<br>\n";
                } else {

                    $somecontent = "";
                    $logcontent .= "Object NOT in POST - not ok<br>\n";
                }
           }
           
           if ( $somecontent != '' ) 
           {
           
                // In our example we're opening $filename in append mode.
                // The file pointer is at the bottom of the file hence
                // that's where $somecontent will go when we fwrite() it.
                if (!$handle = fopen($filename, 'w')) 
                {
                    $logcontent .= "Cannot open file ($filename) ## <br>\n";
                    exit;
                }
           
                // Write $somecontent to our opened file.
                if (fwrite($handle, $somecontent) === FALSE) 
                {
                    $logcontent .= "Can not write to file ($filename) ## <br>\r\n";
                    exit;
                }
           
                $logcontent .= "Success, wrote content to file ($filename) ## <br>\r\n";
           
                fclose($handle);
           
           }                                                       
                                                                  
           if (!$loghandle = fopen($logfile, 'a')) 
           {
                echo "Cannot open logcontent ## <br>\r\n";
                exit;
           }
           
           if (fwrite($loghandle, $logcontent) === FALSE) 
           {
                echo "Cannot write to logcontent ## <br>\r\n";
                exit;
           }
           
           fclose($loghandle);
           
           
           /**
            
            user_id
            name
            date (date)
            sportstype
            workouttype
            distance
            duration
            avg_pulse
            avg_speed
            trimp
            kcal
            location
            weight
            
           // security check - don't view workouts of other users
           if ( isset( $tdata ) )
           {
                $result = $this->Trainingstatistic->find ('all', 
                                                     array('conditions' => 
                                                           array( 'and' => 
                                                                 array( 'id' => $id, 'user_id' => $session_userid ) 
                                                                 ) 
                                                           )
                                                     );
           
                if ( isset( $result[0] ) )
                {
                        $this->data = $result[0];
                } else
                {
                        $this->Session->write('flash',__('Sorry. This is not your entry!', true));
                        $this->set('statusbox', 'statusbox error');
                        $this->redirect(array('controller' => 'trainingstatistics', 'action' => 'list_trainings'));
                }
           }
           **/
           
           $this->set('logcontent', $logcontent);
           //$this->redirect(array('action'=>'list_trainings'));                                                       
        
    }
}

?>