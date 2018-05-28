<?php

class StatisticshandlerComponent extends Object {
	
	var $helpers = array('Html', 'Form', 'Javascript', 'Time', 'Session', 'Unitcalc', 'Xls');
	var $components = array('Email', 'Cookie', 'RequestHandler', 'Session', 'Unitcalc');
	
	var $paginate = array(
	       'Trainingstatistic' => array(
	                'limit' => 15,
	                'order' => array(
	                        'Trainingstatistic.date' => 'asc'
	                )
	       )
	);

	function choose_daterange( $results, $data, $session_value )
	{

            $season = $this->Unitcalc->get_season( $results, null );
			
            if ( empty( $data['Trainingstatistic']['fromdate'] ) )
            {
               $return['start'] = $season['start'];
               //$return['end']   = $season['end'];
               $return['end'] = date( 'Y-m-d', time() );
			   
			         if ( $this->Session->read( $session_value . '_from' ) ) 
			   		      $return['start'] = $this->Session->read( $session_value . '_from' );
			         if ( $this->Session->read( $session_value . '_to' ) ) 
			   		      $return['end'] = $this->Session->read( $session_value . '_to' );
					
            } else
            {
               $start_array = $data['Trainingstatistic']['fromdate'];
               $end_array   = $data['Trainingstatistic']['todate'];
               $return['start'] = $start_array['year'] . '-' . $start_array['month'] . '-' . $start_array['day'];
               $return['end'] = $end_array['year'] . '-' . $end_array['month'] . '-' . $end_array['day'];
            }

			     return $return;
	}

	function get_trimps( $Trainingstatistic, $userid, $sportstype, $start, $end )
	{
		// get all data from this time period for this user
        // where duration > 0 
        $sql = "SELECT duration, trimp, date FROM trainingstatistics WHERE
               user_id = $userid AND ";
        if ( $sportstype ) $sql .= "sportstype = '" . $sportstype . "' AND ";
        $sql .= "( date BETWEEN '" . $start . "' AND '" . $end . "' ) ";
        $sql .= "AND duration > 0 ";
        $sql .= "ORDER BY date ASC";
        $trainingdata = $Trainingstatistic->query( $sql );

  		return $trainingdata;
	}

	function get_trimps_json( $timeperiod, $sportstype, $graphtype, $start, $end, $userid, $Trainingstatistic )
	{
            // http://www.flammerouge.je/factsheets/trainstress.htm
            $start_calc = $this->Unitcalc->date_plus_days( $start, $timeperiod*(-1) );

			      $startday_ts = strtotime( $start_calc );
			      $endday_ts = strtotime( $end );						

            if ( $endday_ts > time() ) 
            {
            	 $endday_ts = time(); 
            	 $end = date( "Y-m-d", time() ); 
			      }
            
            $diff_dates = $this->Unitcalc->diff_dates( $start_calc, $end );

            // real training data (tracked workouts)
            $sql = "SELECT duration, trimp, date FROM trainingstatistics WHERE
                   user_id = $userid AND ";
            if ( $sportstype ) $sql .= "sportstype = '" . $sportstype . "' AND ";
            $sql .= "( date BETWEEN '" . $start_calc . "' AND '" . $end . "' ) ";
            $sql .= "ORDER BY date ASC";
            $trainingdata = $Trainingstatistic->query( $sql );

            // go through all trainings in trainingsstatistics
            for ( $i = 0; $i < count( $trainingdata ); $i++ )
            {
                  $dt = $trainingdata[$i]['trainingstatistics'];
                  $date_string = preg_split( '/ /', $dt['date'] );

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

            /*
			* track scheduled / planned workouts
		    */
            $sql = "SELECT duration, week AS date, trimp, athlete_id AS user_id,
                sport AS sportstype, week AS date FROM scheduledtrainings WHERE " . 
                "athlete_id = $userid AND ";
            if ( $sportstype ) $sql .= "sport = '" . $sportstype . "' AND ";
            $sql .= "( week BETWEEN '" . $start_calc . "' AND '" . $end . "' ) ORDER BY date ASC";

            $scheduled_trainingdata = $Trainingstatistic->query( $sql );

            // go through all planned trainings
            for ( $i = 0; $i < count( $scheduled_trainingdata ); $i++ )
            {
                  $dt = $scheduled_trainingdata[$i]['scheduledtrainings'];
                  $date_string = preg_split( '/ /', $dt['date'] );
                  // week day in trainingplan - always Monday :(
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

            foreach ( $trimp_planned as $date => $trimp ) {
                $startday = strtotime($date);
                $trimp_per_day = round($trimp / 7);
                for ( $k = 0; $k < 7; $k++ ) {
                    $weekday = $startday + (86400 * $k);
                    $weekday = date( 'Y-m-d', $weekday);
                    $trimp_planned[$weekday] = $trimp_per_day;
                }
            }

            // TODO limit period of difference to x days?
            //if ( $diff_dates > 60 ) $diff_dates = 60;
            $max_unit = 0;

            for ( $i = 0; $i < $diff_dates; $i++ )
            {
                // go through all days in this period from now to past
                // go each day back
                $rightday_ts = $endday_ts - ( 86400 * $i );
                $rightday = date( 'Y-m-d', $rightday_ts );

                // if day is not available, set with 0
                if ( !isset( $trimp_done[$rightday] ) ) $trimp_done[$rightday] = 0;
                //else $trimp_done[$rightday] = $trimp_done[$rightday];

                if ( !isset( $trimp_planned[$rightday] ) ) $trimp_planned[$rightday] = 0;
                //else $trimp_planned[$rightday] = $trimp_planned[$rightday];

                // save date for this day where we went back
                $trimp_dates[$i] = $rightday;

                if ( $graphtype == 'chronic' )
                {
                  // CTL
                  // item in clause is smaller then period (42)
                  if ( $i <= $timeperiod ) 
                      $startpoint = 0;
                  else 
                      $startpoint = $i - $timeperiod;

                  //echo $i . ' - ' . $startpoint . "<br>";
                } elseif ( $graphtype == 'acute' )
                {
                  // ATL
                  if ( $i <= $timeperiod ) 
                      $startpoint = 0;
                  else 
                      $startpoint = $i - $timeperiod;
                }

                // calculate all trimp for CTL or ATL timeperiod back in the past per day
                for ( $j = $startpoint; $j <= $i; $j++ )
                {
                    // here we insert the trained trimps of the logbook
                    if ( !isset( $trimp_tl_done[$j] ) ) 
                          $trimp_tl_done[$j] = 0;
                    
                    $trimp_tl_done[$j] += $trimp_done[$rightday];

                    if ( $trimp_tl_done[$j] > $max_unit ) 
                          $max_unit = $trimp_tl_done[$j];

                    // here we insert the planned trimps of the trainingplan
                    if ( !isset( $trimp_tl_planned[$j] ) ) 
                          $trimp_tl_planned[$j] = 0;

                    $trimp_tl_planned[$j] += $trimp_planned[$rightday];
                    
                    if ( $trimp_tl_planned[$j] > $max_unit ) 
                          $max_unit = $trimp_tl_planned[$j];
                }
            }

            // removed this temporarily
            /*
            for ( $e = 0; $e < count( $trimp_tl_done ); $e++ )
            {
                $trimp_tl_done[$e] = round($trimp_tl_done[$e] / $timeperiod);
                $trimp_tl_planned[$e] = round($trimp_tl_planned[$e] / $timeperiod);
            }

            if ( isset( $max_unit ) )
                $max_unit = round( ( $max_unit * 1.1 ) / $timeperiod );
            else
                $max_unit = 50;
                //if ( isset( $max_unit ) && $max_unit < 1 ) $max_unit = 50;
            */

            $max_unit = round( $max_unit * 1.1 );
            //echo "max_unit: " . $max_unit . "<br>";

            if ( isset( $_GET['debug'] ) ) {
              for ( $i = 0; $i < count( $trimp_tl_done ); $i++ )
              {
                  echo $trimp_dates[$i] . "<br>";
                  echo "trimp_tl_done: " . $trimp_tl_done[$i] . "<br>";
                  echo "trimp_tl_planned: " . $trimp_tl_planned[$i] . "<br>";

              }
            }

            // for the graph we need the days in reverse order
            $trimp_tl_done = array_reverse($trimp_tl_done);
            $trimp_tl_planned = array_reverse($trimp_tl_planned);
            $trimp_dates = array_reverse($trimp_dates);

      		$return['start'] = $start;			
            $return['end'] = $end;
      		$return['max_unit'] = $max_unit;
            $return['trimp_tl_done'] = $trimp_tl_done;
            $return['trimp_tl_planned'] = $trimp_tl_planned;
            $return['trimp_dates'] = $trimp_dates;

      		if ( isset( $_GET['debug'] ) ) 
                return false;
            else 
                return $return;		
	}

	function get_formcurve( $Trainingstatistic, $userid, $sportstype, $start, $end )
	{
            // select all test-workouts grouped by sportstype
            /*
            $sql = "SELECT name, distance, sportstype, count(*) as ccount FROM trainingstatistics WHERE " .
                 "user_id = $userid AND name != '' AND ( date BETWEEN '" . $start . "' AND '" . $end . "' ) " . 
                 "GROUP BY name, distance, sportstype HAVING ccount > 1 ORDER BY name, distance";
            */
            $sql = "SELECT name, sportstype, count(*) as ccount FROM trainingstatistics WHERE " .
                 "user_id = $userid AND name != '' AND ( date BETWEEN '" . $start . "' AND '" . $end . "' ) " . 
                 "GROUP BY name, sportstype HAVING ccount > 1 ORDER BY name";
            
            $testworkoutsfilter = $Trainingstatistic->query( $sql );
			
			return $testworkoutsfilter;
	}		
	
	function get_formcurve_json( $searchfilter, $start, $end, $userid, $Trainingstatistic, $unit )
	{
			$startday_ts = strtotime( $start );
			$endday_ts = strtotime( $end );						
            
            if ( $endday_ts > time() ) 
            {
                $endday_ts = time(); 
                $end = date( "Y-m-d", time() ); 
			}
            
            // to filter test-workouts I have to create a key to filter
            $searchsplit = explode( "|||", $searchfilter );
            $pulse['min'] = $pulse['max'] = 0;

            // TODO select different avg_pulse_zones
            // select all entries for this special test-workout - filtered by the name and the sportstype
            /*
            $sql = "SELECT date, distance, duration, avg_pulse FROM trainingstatistics WHERE user_id = $userid " .
                "AND ( date BETWEEN '" . $start . "' AND '" . $end . "' ) AND name = '" . $searchsplit[0] .
                    "' AND distance = '" . $searchsplit[1] . "' ORDER BY date";
            */
            $sql = "SELECT date, distance, duration, avg_pulse FROM trainingstatistics WHERE user_id = $userid " .
                "AND ( date BETWEEN '" . $start . "' AND '" . $end . "' ) AND name = '" . $searchsplit[0] .
                    "' ORDER BY date";
            
            $trainings = $Trainingstatistic->query( $sql );

            for ( $i = 0; $i < count( $trainings ); $i++ )
            {
                    $dt = $trainings[$i]['trainingstatistics'];
                    if ( $i == 0 ) { $start = $dt['date']; $startday_ts = strtotime( $dt['date'] ); }

                    // find out what the maximum pulse is - for the height of the graph
                    if ( $dt['avg_pulse'] > $pulse['max'] ) $pulse['max'] = $dt['avg_pulse'];
                    if ( $dt['avg_pulse'] < $pulse['min'] || $pulse['min'] == 0 ) $pulse['min'] = $dt['avg_pulse'];
            }

            $diff_dates = $this->Unitcalc->diff_dates( $start, $end );

            // what is the average pulse
            $total_avg_pulse = round( ( ( $pulse['max'] + $pulse['min'] ) / 2 ), 0 );
            $max_perunit = 0;

            for ( $i = 0; $i < count( $trainings ); $i++ )
            {
                    // we make all entries of the testworkouts relative to each other 
                    // and transform them to minutes per miles/km
                    $dt = $trainings[$i]['trainingstatistics'];

                    // calculate current average pulse minus total average pulse
                    $diff_pulse = ( $dt['avg_pulse'] - $total_avg_pulse ); // 190 - 160 = 30 / basic value

                    $change_value = ( $diff_pulse / $dt['avg_pulse'] ) + 1;

                    $dt['old_duration'] = $dt['duration'];
                    $duration_interim = ( $dt['duration'] * $change_value );
            
                    $dt['duration'] = $newduration = round( $duration_interim, 0 );

                    $correct_distance = $this->Unitcalc->check_distance( $dt['distance'] );
                    $distanceperunit_interim =  $newduration / $correct_distance['amount'] / 60;
                    $dt['distanceperunit'] = round( $distanceperunit_interim, 2);
            
                    if ( $distanceperunit_interim > $max_perunit ) $max_perunit = round( $distanceperunit_interim, 1);
                    // depends on minutes per km / mi
                    $newdate = preg_split( '/ /', $dt['date'] );
                    $newdate2 = $newdate[0];

                    // date, distance, duration, avg_pulse
                    $traindate2[$newdate2] = $dt;
            }

            $initiator = 0;

            for ( $i = 0; $i < $diff_dates; $i++ )
            {
                    $rdate = date( 'Y-m-d', ( $startday_ts + $i * 86400 ) );

                    // set last value if no testworkout is in the array for this date					 
                    if ( !isset( $traindate2[$rdate]['distanceperunit'] ) )
                    { 
                        $traindate[$rdate]['distanceperunit'] = $initiator;
                    } else 
                        $traindate[$rdate]['distanceperunit'] = $initiator = $traindate2[$rdate]['distanceperunit'];
                            
                    $traindate[$rdate]['date'] = $rdate;
            }

            $max_perunit = round( $max_perunit, 0 ) + 1;

            $return['start'] = $start;
            $return['end'] = $end;
            $return['max_perunit'] = $max_perunit;
			$return['trainings'] = $traindate;
			$return['unit'] = $unit;

			return $return;
	}

	function get_weight_json( $start, $end, $results, $userid, $Trainingstatistic, $unit )
	{
		    $end_orig = $end;
            $targetweight = $results['User']['targetweight'];
            $targetweightdate = $results['User']['targetweightdate'];
            $diff_week = 0;
            
            if ( isset( $targetweightdate ) && isset( $targetweight ) && $end_orig == date('Y-m-d', time()) ) 
            { 
                $end = $targetweightdate; 
            }

            $start_ts = strtotime($start);
            $end_ts = strtotime($end);
     
            $sql = "SELECT round(avg(weight),1) as avgweight, 
                    date_format(min(date), '%Y-%m-%d') as 'weekday',
                    date_format(date, '%Y%u') as 'week' FROM trainingstatistics WHERE 
                    user_id = $userid AND weight != '' AND
                    date BETWEEN '" . $start . "' AND '" . $end . "' GROUP BY week ORDER BY week ASC";
            $trainings = $Trainingstatistic->query( $sql );
            
            $lastentry = count($trainings);
            
            if ( $lastentry > 0 )
            {
                $firsttraining = $trainings[0][0];
                $start_ts = strtotime( $firsttraining['weekday'] );

                $weeks_between_dates = round(($end_ts - $start_ts)/(86400*7),0)+1;
                $week_ts = $start_ts;

                if ( isset( $targetweightdate ) && isset( $targetweight ) ) // && $end_orig == date( 'Y-m-d', time() ) )
                {
                        $train_array = $trainings[$lastentry-1][0];
                        
                        $diff_time = strtotime( $targetweightdate ) - strtotime( $train_array['weekday'] );

                        // weeks between last trainingstatistics entry and target weight date
                        $diff_week = round( $diff_time / ( 86400 * 7 ) );
                        // diff between last weight entry and target weight
                        $diff_weight = $targetweight - $train_array['avgweight'];

                        $diff_weight_show = $this->Unitcalc->check_weight( $diff_weight, 'show', 'single' );
                    
                        // how much do you have to lose to reach your weight goal
                        $diff_per_week = ($diff_weight / $diff_week);
                            $diff_per_week_show = $this->Unitcalc->check_weight( $diff_per_week, 'show', 'single' );
                    
                        $lastweight = $train_array['avgweight'];
                            $lastweight_show = $this->Unitcalc->check_weight( $lastweight, 'show', 'single' );
                    
                        $lastweightdate = $train_array['weekday'];
                }
                    
                for ( $i = 0; $i < $weeks_between_dates; $i ++)
                {
                        $nweek[$i] = date('W', $week_ts);
                        $nyear[$i] = date('o', $week_ts);
                        $weeks[$i] = $nyear[$i]. $nweek[$i]; 
                        $weeks_ts[$i] = $week_ts;
                        $week_ts += (86400*7);
                }

			    $maxweight = 0;

                for ( $i = 0; $i < count( $trainings ); $i++ )
                {
                    $week = $trainings[$i][0]['week'];
                    $train[$week]['avgweight'] = $trainings[$i][0]['avgweight'];
                    if ( $train[$week]['avgweight'] > $maxweight ) 
                    $maxweight = $this->Unitcalc->check_weight( $train[$week]['avgweight'], 'show', 'single' );
                }

        	    $targetweight_show = $this->Unitcalc->check_weight( $results['User']['targetweight'], 'show', 'single' );
                if ( $targetweight_show > $maxweight ) 
                    $maxweight = $targetweight_show;
		  
                $avg_weight_lastweek = 'null';
		 
                // go through all weeks - in case you have weeks without trainings you have to set them to 0
                for( $i = 0; $i < ( $weeks_between_dates ); $i++ )
                {
                    $yearweek = $nyear[$i] . '' . $nweek[$i];

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
                            $avg_weight_lastweek = $this->Unitcalc->check_weight( $train[$yearweek]['avgweight'], 'show', 'single' );
                                        $train[$yearweek]['avgweight'] = $this->Unitcalc->check_weight( $train[$yearweek]['avgweight'], 'show', 'single' );
                        }
                    }
                }
                ksort($train);
	          
                if ( $maxweight == 0 ) 
                    $maxweight = $this->Unitcalc->check_weight( '150', 'show', 'single' );
                $maxweight = round( $maxweight ) + 10; 
                $minweight = round( $this->Unitcalc->check_weight( '40', 'show', 'single' ) );
			}

            // merge all values for a return array
            $return['lastentry'] = $lastentry;
			$return['start'] = $start;
			$return['end'] = $end;
			$return['diff_week'] = $diff_week;
			if ( isset( $diff_weight_show ) ) $return['diff_weight_show'] = $diff_weight_show;
			if ( isset( $diff_per_week_show ) ) $return['diff_per_week_show'] = $diff_per_week_show;
			if ( isset( $lastweight_show ) ) $return['lastweight_show'] = $lastweight_show;
			$return['targetweight_show'] = $targetweight_show;
			$return['weeks_between_dates'] = $weeks_between_dates;
			$return['minweight'] = $minweight;
			$return['maxweight'] = $maxweight;
			$return['weeks'] = $weeks;
            $return['weeks_ts'] = $weeks_ts;
			$return['train']= $train;

			return $return;			
	}

	function get_statistics( $Trainingstatistic, $userid, $sportstype, $start, $end )
	{
            // select trainingsdata
            $sql = "SELECT * FROM trainingstatistics WHERE user_id = $userid AND date BETWEEN '" .
                $start . "' AND '" . $end . "' ORDER BY date";
            $trainings = $Trainingstatistic->query( $sql );

            $sumdata['collected_sportstypes'] = array();
            $sumdata['duration'] = array();
            $sumdata['distance'] = array();
            $sumdata['trimp'] = array();

			$last_entry = count( $trainings ) - 1;
			
			if ( $last_entry > 0 )
			{
				$start = $trainings[0]['trainingstatistics']['date'];
				$end = $trainings[$last_entry]['trainingstatistics']['date'];
	
                // collect them, accumulate per sportstype
                for ( $i = 0; $i < count( $trainings ); $i++ )
                {
                    $dt = $trainings[$i]['trainingstatistics'];
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
                $return['sumdata'] = $sumdata;
                $return['trainings'] = $trainings;
                $return['start'] = $start;
                $return['end'] = $end;
			} else
			{
				$return['sumdata'] = $sumdata;
				$return['trainings'] = $trainings;
				$return['start'] = $start;
				$return['end'] = $end;
			}			
			return $return;
	}

	function get_statistics_json( $start, $end, $results, $userid, $Trainingstatistic, $unit, $params )
	{
            // type of graph
            $type = $params['named']['type'];
            // sportstype RUN, BIKE, SWIM
            $sportstype = $params['named']['sportstype'];
            $start = $params['named']['start'];
            $end = $params['named']['end'];

            $start_ts = strtotime($start);
            $end_ts = strtotime($end);

            // get for given timestamp the week (number) and year
            $start_year = date('o', $start_ts);
            $start_week = date('W', $start_ts);

            if ( $start_week == 53 ) { $start_week = "01"; $start_year += 1; }
        
            $end_year = date('o', $end_ts);
            $end_week = date('W', $end_ts);
        
            if ( $end_week == 53 ) { $end_week = 1; $end_year += 1; }

            // what if the period defined goes until next year
            // we need that for calculations!
            if ( $end_year > $start_year ) 
                $end_week = $end_week + ( 52 * ( $end_year - $start_year ) );

            $weeks_between_dates = $end_week - $start_week;

            if ( $type == 'distance' || $type == 'duration' )
            {
                $maxdistance = 0;
                $maxduration = 0;
                $weekbefore = '';
                $minweek = '';
                $maxweek = '';

                $sql = "SELECT count(*) as 'count', sum(distance) as sumdistance, sum(duration) as sumduration, " .
                        "date_format(min(date), '%Y-%M-%d') as 'week commencing', " .
                        "date_format(date, '%Y%u') as 'week' FROM trainingstatistics where user_id = $userid AND
                        date BETWEEN '" . $start . "' AND '" . $end . "' ";
                if ( $sportstype ) $sql .= " AND sportstype = '" . $sportstype . "' ";
                $sql .= "group by week order by week asc";


                $trainings = $Trainingstatistic->query( $sql );
                $lastentry = count($trainings);
                $minweek = $trainings[0][0]['week'];
                $maxweek = $trainings[$lastentry-1][0]['week'];

                for ( $i = 0; $i < count( $trainings ); $i++ )
                {
                        $week = $trainings[$i][0]['week'];
                    
                        // there's a week yyyy00 :(
                        // we go automatically to week 01
                        if ( substr( $week, 4, 2 ) == '00' ) 
                        {
                                $week = substr( $week, 0, 4 ) . '01';
                                //echo "$week" . "<br>";
                            //$previous_week = $trainings[$j][0]['week'];
                        //$trainings2[$previous_week]['sumdistance'] += round( $this->Unitcalc->check_distance( $trainings[$i][0]['sumdistance'], 'show', 'single' ), 2 );
                        //$trainings2[$previous_week]['sumduration'] += round( ( $trainings[$i][0]['sumduration'] / 3600 ), 2 );
                        //$trainings2[$previous_week]['sumtrainings'] += $trainings[$i][0]['count'];
                        }

                        //unset($previous_week);
                        $trainings2[$week]['sumdistance'] = round( $this->Unitcalc->check_distance( $trainings[$i][0]['sumdistance'], 'show', 'single' ), 2 );
                        $trainings2[$week]['sumduration'] = round( ( $trainings[$i][0]['sumduration'] / 3600 ), 2 );
                        $trainings2[$week]['sumtrainings'] = $trainings[$i][0]['count'];
            
                        // make graph a little bit higher with max values
                            
                        // special case :)
                        if ( isset( $previous_week ) )
                        {
                            if ( $trainings2[$previous_week]['sumdistance'] > $maxdistance ) $maxdistance = $trainings2[$previous_week]['sumdistance'] * 1.1;
                            if ( $trainings2[$previous_week]['sumduration'] > $maxduration ) $maxduration = $trainings2[$previous_week]['sumduration'] * 1.1;
                        } else 
                        {
                            if ( isset( $trainings2 ) && $trainings2[$week]['sumdistance'] > $maxdistance ) $maxdistance = $trainings2[$week]['sumdistance'] * 1.1;
                            if ( isset( $trainings2 ) && $trainings2[$week]['sumduration'] > $maxduration ) $maxduration = $trainings2[$week]['sumduration'] * 1.1;
                        }				   
                }

  		        $maxduration = round( $maxduration );

                // go through all weeks - in case you have weeks without trainings you have to set them to 0
                for( $i = 0; $i <= $weeks_between_dates; $i++ )
                {
                    if ( isset( $start_week ) && $start_week < 10 && substr( $start_week, 0, 1 ) != '0' ) 
                        $start_week = '0' . $start_week;

                    $yearweek = $start_year . $start_week;
                    $weeks[$i] = $yearweek;
                    $weeks2[$i] = $start_year . '-' . $start_week;

                    if ( empty($trainings2[$yearweek]['sumdistance']) )
                    {
                        $trainings2[$yearweek]['sumdistance'] = 0;
                        $trainings2[$yearweek]['sumduration'] = 0;
                        $trainings2[$yearweek]['sumtrainings'] = 0;
                    }

                    if ( $start_week == 52 ) { $start_year++; $start_week = 1; }
                    else { $start_week ++; }
                }
            }
            ksort($trainings2);
			
            $return['trainings2'] = $trainings2;
            $return['start'] = $start;
            $return['end'] = $end;
            $return['weeks_between_dates'] = $weeks_between_dates;
            $return['weeks'] = $weeks;
            $return['weeks2'] = $weeks2;
            $return['type'] = $type;
            $return['maxdistance'] = $maxdistance;
            $return['maxduration'] = $maxduration;
			
            return $return;		
	}

	function get_competition( $Trainingstatistic, $userid, $sportstype, $start, $end, $data )
	{
            if ( isset( $data['Trainingstatistic']['sportstype'] ) ) 
                $sportstype = $data['Trainingstatistic']['sportstype'];

            $total_trimp = 0;
            $total_trimp_tp = 0;

            $sql = "SELECT min(week) as mindate FROM scheduledtrainings WHERE " . 
                "athlete_id = $userid AND ";
            if ( $sportstype ) $sql .= "sport = '" . $sportstype . "' AND "; 
            $sql .= "( week BETWEEN '" . $start . "' AND '" . $end . "' ) ORDER BY mindate ASC";
            $start_tp = $Trainingstatistic->query( $sql );

  			// if your training plans start later than tracking - you have to re-set the start date
  			if ( count( $start_tp ) > 0 )
  			{
  				$maxstart = $start_tp[0][0]['mindate'];
  				if ( strtotime( $maxstart ) > strtotime( $start ) )
  					$start = $maxstart;
  			}

            /**
            * planned trainings
            **/
  			$sql = "SELECT s.duration AS duration, m.date AS week, s.athlete_id AS user_id, s.sport AS sportstype,
  			m.time AS time, m.usertime AS usertime, IF (s.trimp IS NULL, IF (m.usertime > 0, m.usertime * 1.1, m.time * 1.1), trimp) trimp
  			FROM mesocyclephases m LEFT JOIN scheduledtrainings s ON s.athlete_id = m.athlete_id AND s.week = m.date
  			WHERE m.athlete_id = " . $userid . " AND ";
            if ( $sportstype ) $sql .= "sport = '" . $sportstype . "' AND "; 
            $sql .= "( week BETWEEN '" . $start . "' AND '" . $end . "' ) ORDER BY date ASC";

/*
            $sql = "SELECT duration, week AS date, trimp, athlete_id AS user_id,
                sport AS sportstype, week AS date FROM scheduledtrainings WHERE " . 
                "athlete_id = $userid AND ";
            if ( $sportstype ) $sql .= "sport = '" . $sportstype . "' AND "; 
            $sql .= "( week BETWEEN '" . $start . "' AND '" . $end . "' ) ORDER BY date ASC";
*/
            $Trainingplans = $Trainingstatistic->query( $sql );

	        // in case there are less trainings in tp then set new start date
            if ( isset( $Trainingplans[0]['m']['week'] ) )
                $start = $Trainingplans[0]['m']['week'];

            $sumdata_tp['collected_sportstypes'] = array();
            $sumdata_tp['duration'] = array();
            $sumdata_tp['distance'] = array();
            $sumdata_tp['trimp'] = array();

            for ( $i = 0; $i < count( $Trainingplans ); $i++ )
            {
                if ( isset( $Trainingplans[$i]['scheduledtrainings'] ) )
                    $dt = $Trainingplans[$i]['scheduledtrainings'];
                else
                    {
                    $dt = $Trainingplans[$i];
                    $dt['trimp'] = $dt[0]['trimp'];
                    $dt['duration'] = $dt['s']['duration'];
                    $dt['sportstype'] = $dt['s']['sportstype'];
                    }				  
            
                $sportstype_set = $dt['sportstype'];

                if ( !in_array( $sportstype, $sumdata_tp['collected_sportstypes'] ) )
                {
                    $sumdata_tp['collected_sportstypes'][] = $sportstype_set;
                    $sumdata_tp['duration'][$sportstype_set] = 0;
                    $sumdata_tp['distance'][$sportstype_set] = 0;
                    $sumdata_tp['trimp'][$sportstype_set] = 0;
                }

                $sumdata_tp['duration'][$sportstype_set] += $dt['duration'];
            
                if ( $dt['trimp'] )
                {
                    $sumdata_tp['trimp'][$sportstype_set] += ( $dt['trimp'] );
                    $total_trimp_tp += ( $dt['trimp'] );
                }
            }

            $sql = "SELECT * FROM trainingstatistics WHERE user_id = $userid AND ";
            if ( $sportstype ) $sql .= "sportstype = '" . $sportstype . "' AND ";
            $sql .= "(date BETWEEN '" . $start . "' AND '" . $end . "') ORDER BY date";

            $trainings = $Trainingstatistic->query( $sql );

            $sumdata['collected_sportstypes'] = array();
            $sumdata['duration'] = array();
            $sumdata['distance'] = array();
            $sumdata['trimp'] = array();

            // go through all trainings of period defined
            for ( $i = 0; $i < count( $trainings ); $i++ )
            {
                $dt = $trainings[$i]['trainingstatistics'];
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

                if ( $dt['trimp'] > 0 )
                {
                    $sumdata['trimp'][$sportstype_set] += ( $dt['trimp'] );
                    $total_trimp += ( $dt['trimp'] );
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
            if ( $trafficlight >= 0.8 && $trafficlight <= 1.1 ) 
                $color = "green";
            elseif ( ( $trafficlight >= 0.6 && $trafficlight < 0.8 ) || ( $trafficlight > 1.1 & $trafficlight <= 1.2 ) ) 
                $color = "orange";
            else 
                $color = "red";

            $return['start'] = $start;
            $return['end'] = $end;
            $return['sumdata'] = $sumdata;
            $return['total_trimp'] = $total_trimp;
            $return['total_trimp_tp'] = $total_trimp_tp;
            $return['color'] = $color;
            $return['trafficlight_percent'] = $trafficlight_percent;
        
            return $return;
    }

    /**
    *
    */
    function get_reward( $Trainingstatistic, $userP ) {
            $last_workout_limit = 15;
            $text_for_mail_training = '';

            $user['User'] = $userP;

            $userid = $session_userid = $user['User']['id'];

            // calculate success of last week's training
            $unit = $this->Unitcalc->get_unit_metric();
        
            $sql = "SELECT max(date) AS ldate FROM trainingstatistics WHERE user_id = " . $userid;
            $results = $Trainingstatistic->query($sql);
        
            $last_training = strtotime($results[0][0]['ldate']);
            $diff_time = time() - ( 86400 * $last_workout_limit );
      
            /*
            if ( $diff_time > $last_training )
            {
                $text_for_mail_training .= __("don't be lazy!", true) . ' ' .  
                    __('Go to', true) . ' <a href="' . Configure::read('App.hostUrl') . Configure::read('App.serverUrl') .        
                    '/trainingstatistics/list_trainings/?utm_source=tricoretrainingsystem&utm_medium=mailing" target="_blank">TriCoreTraining</a> ' . __('and track your workouts - now!', true) . "<br /><br />"; 
        
                if ( $debug == true ) echo "training statistics reminder sent.<br />\n";
            }
            */
            
            // automatic default date chooser
            $choosedates = $this->choose_daterange( $user, array(), 'competition_date' );

            // set form-fields of search form
            $this->data['Trainingstatistic']['fromdate'] = $start = $choosedates['start'];
            $this->data['Trainingstatistic']['todate'] = $end = $choosedates['end'];
                    
            if ( $Trainingstatistic && $session_userid && $start && $end )
            {  
                $return = $this->get_competition( $Trainingstatistic, $session_userid, "", $start, $end, $this->data );
                            
                // deactivated
                if ( isset( $return ) && is_array( $return ) && 1 == 2 )
                {
                        $text_for_mail_training .= "<b>" . __("Status of your season's training",true) . " (" . $start . " - " . $end . ")</b><br />"; 
                        //if ( $return['color'] ) $text_for_mail_training .= "<span style='background:" . $return['color'] . "'>";
                        $text_for_mail_training .= " " . $return['total_trimp'] . " " . __('of',true) . " " . 
                        $return['total_trimp_tp'] . " " . __('Trimps',true) . " (" . $return['trafficlight_percent'] . " %) ";
                        //if ( $return['color'] ) $text_for_mail_training .= "</span>";
                        $color = $return['color'];
                        
                        if ( isset( $color ) ) 
                        {
                            // bought with gentics account at istockphotos 3480031_thumbnail.jpg 2012-03-31
                            $block = '<span style="width:10px;background:' . $color . '">&nbsp;&nbsp;&nbsp;</span>&nbsp;';
                            $block = '<img class="none" alt="" src="' . Configure::read('App.hostUrl') . Configure::read('App.serverUrl') . '/img/trophy_' . $color . '_25x25.gif" />&nbsp;';
                                                
                            if ( $color == 'red' )
                            { 
                                $text_for_mail_training .= ($block);
                            }
                            if ( $color == 'orange' )
                            {
                                $text_for_mail_training .= ($block).($block);
                            }
                            if ( $color == 'green' )
                            { 
                                $text_for_mail_training .= ($block).($block).($block);
                            }
                        }
                    
                        $text_for_mail_training .= "<br /><br />";
                }
                
                // last weeks training compared planned to real
                // one week before
                $start = date('Y-m-d', time() - 6*24*3600);
                $end = date('Y-m-d', time());
                
                if ( $session_userid )
                {
                    $sql = "SELECT sum(trimp) AS strimp FROM trainingstatistics WHERE user_id = " . $session_userid . " AND " . 
                            "(date BETWEEN '" . $start . "' AND '" . $end . "')";
                    $results_real = $Trainingstatistic->query($sql);

                    if ( $results_real[0][0]['strimp'] ) 
                        $sum_real = $results_real[0][0]['strimp'];
                    else
                        $sum_real = 0;
                    
                    $sql = "SELECT sum(trimp) AS strimp FROM scheduledtrainings WHERE athlete_id = " . $session_userid . " AND " .
                            "(week BETWEEN '" . $start . "' AND '" . $end . "')";
                    $results_planned = $Trainingstatistic->query($sql);

                    if ( $results_planned[0][0]['strimp'] ) 
                        $sum_planned = $results_planned[0][0]['strimp'];
                    else
                        $sum_planned = 0;
                        
                    if ( $sum_planned > 0 ) {
                        $training_week_percentage = round( $sum_real / $sum_planned * 100 );
                        
                        if ( $training_week_percentage < 80 || $training_week_percentage > 110 )
                            $color = 'orange';
                        if ( $training_week_percentage < 60 || $training_week_percentage > 120 )
                            $color = 'red';
                        if ( $training_week_percentage >= 80 && $training_week_percentage <= 110 )
                            $color = 'green'; 
                    } else
                    {
                        $training_week_percentage = 0;
                        $color = 'red';
                    } 
                        
                    $text_for_mail_training .= "<b>" . __("Status of your week's training",true) . " (" . $start . " - " . $end . ")</b><br />";
                    //if ( isset( $color ) ) $text_for_mail_training .= "<span style='background:" . $color . "'>";
                    $text_for_mail_training .= $sum_real . " " . __('of', true) . " " . $sum_planned . " " . __('Trimps', true);
                    $text_for_mail_training .= " (" . $training_week_percentage . " %) ";
                    //if ( isset( $color ) ) $text_for_mail_training .= "</span>";
                    
                    if ( isset( $color ) ) 
                    {
                        $block = '<span style="width:10px;background:' . $color . '">&nbsp;&nbsp;&nbsp;</span>&nbsp;';
                        $block = '<img class="none" alt="" src="' . Configure::read('App.hostUrl') . Configure::read('App.serverUrl') . '/img/trophy_' . $color . '_25x25.gif" />&nbsp;';
                        
                        if ( $color == 'red' )
                            $text_for_mail_training .= ($block);
                        if ( $color == 'orange' )
                            $text_for_mail_training .= ($block).($block);
                        if ( $color == 'green' )
                            $text_for_mail_training .= ($block).($block).($block);
                    }
                                    
                    $text_for_mail_training .= "<br /><br />";
                }
            }

            return $text_for_mail_training;

    }
}

?>
