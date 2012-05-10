<?php

/**
* converts, calculates, etc
**/

class UnitcalcComponent extends Object {
   var $components = array('Session', 'Provider');
   var $helpers = array('Session');

   /**
   * converts from different metrics to another
   **/
   function convert_metric( $amount, $convertunit, $roundnumber = 3, $commasep = '.' )
   {
     // round one number less than saving - round at viewing
     if ( $convertunit != '' )
     {
       switch ( $convertunit )
       {
            case "cm_ft":
            $result = $amount / 30.48;
            break;

            case "ft_cm":
            $result = $amount * 30.48;
            break;

            case "kg_lbs":
            $result = $amount * 2.2046;
            break;

            case "lbs_kg":
            $result = $amount / 2.2046;
            break;

            case "km_mi":
            $result = $amount * 0.62137;
            break;

            case "mi_km":
            $result = $amount / 0.62137;
            break;
       }
     } else
            $result = $amount;
            
     $result = $this->format_number( $result, $roundnumber, '', $commasep );

     return $result;
   }

   /**
   get metric unit definitions for displaying
   **/
   function get_unit_metric()
   {
            // length / weight / height
            $session_userobject = $this->Session->read('userobject');
            if (  $session_userobject['unit'] == 'imperial' )
            {
               $return['length'] = 'mi';
               $return['weight'] = 'lbs';
               $return['height'] = 'ft';
            } else
            {
               $return['length'] = 'km';
               $return['weight'] = 'kg';
               $return['height'] = 'cm';
            }
            return $return;
   }

   /**
   check a distance to be saved and viewed in the correct metric
   **/
   function check_distance( $amount, $mode = 'show', $ret = 'both', $excel = '' )
   {
            if ( is_numeric( $amount ) )
            {
	              $session_userobject = $this->Session->read('userobject');
				  $locale = $session_userobject['yourlanguage'];
				  
	              if (  $session_userobject['unit'] == 'imperial' )
	              {
	                 if ( $mode == 'show' ) $convert = 'km_mi';
	                 else
	                     $convert = 'mi_km';
	
	                 $amount_array['amount'] = $this->convert_metric( $amount, $convert );
	                 $amount_array['unit'] = 'mi';
	              } else
	              {
	                  if ( $mode == 'show' ) $amount_array['amount'] = $this->format_number( $amount, 3, '', '.' );
	                  else $amount_array['amount'] = $amount;
	
	                  $amount_array['unit'] = 'km';
	              }
	
				  if ( $locale == 'ger' || $excel == 'excel' )
				  { 
				  		$amount_array['amount'] = str_replace( '.', ',', $amount_array['amount'] );
				  }
				  	
	              if ( $ret == 'single' )
	                 return $amount_array['amount'];
	              else
	                 return $amount_array;

            } else
              	  return false;
   }

   /**
   check a weight to be saved and viewed in the correct metric
   **/
   function check_weight( $amount, $mode = 'show', $ret = 'both', $excel = '' )
   {
            if ( is_numeric( $amount ) )
            {
              $session_userobject = $this->Session->read('userobject');
			  $locale = $session_userobject['yourlanguage'];
              if (  $session_userobject['unit'] == 'imperial' )
              {
                 if ( $mode == 'show' ) $convert = 'kg_lbs';
                 else
                     $convert = 'lbs_kg';

                 $amount_array['amount'] = $this->convert_metric( $amount, $convert );
                 $amount_array['unit'] = 'lbs';
              } else
              {
                  if ( $mode == 'show' ) $amount_array['amount'] = $this->format_number( $amount, 3, '', '.' );
                  else $amount_array['amount'] = $amount;
                  $amount_array['unit'] = 'kg';
              }
			  
			  if ( $locale == 'ger' || $excel == 'excel' ) 
			  		$amount_array['amount'] = str_replace( '.', ',', $amount_array['amount'] );
			
              if ( $ret == 'single' )
                 return $amount_array['amount'];
              else
                 return $amount_array;
            } else
                return false;
   }

   /**
   check a height to be saved and viewed in the correct metric
   **/
   function check_height( $amount, $mode = 'show', $ret = 'both' )
   {

            if ( is_numeric( $amount ) )
            {
		
              $session_userobject = $this->Session->read('userobject');

              if (  $session_userobject['unit'] == 'imperial' )
              {
                 if ( $mode == 'show' ) 
                 {
                 	$convert = 'cm_ft';
                 } else
                     $convert = 'ft_cm';

				 $amount = $this->convert_metric( $amount, $convert );
                 //$amount_array['amount'] = $this->format_number( $amount, 3, '', '.' );
                 $amount_array['amount'] = $amount;
                 $amount_array['unit'] = 'ft';
              } else
              {
                  if ( $mode == 'show' ) 
                  		$amount_array['amount'] = $this->format_number( $amount, 3, '', '.' );
                  else 
                  		$amount_array['amount'] = $amount;
                  
                  $amount_array['unit'] = 'cm';
              }

              if ( $ret == 'single' )
                 return $amount_array['amount'];
              else
                 return $amount_array;

            } else
                return false;
   }

   /**
   calculate bmi and give back a status on your bmi
   **/
   function calculate_bmi( $weight, $height, $age )
   {
            /**
            BMI (Body mass index) Tabelle
            Age     underw. normal  overw.  really fat
            18-24  	<19  	19-24  	24-29  	29-39  	>39
            25-34 	<20 	20-25 	25-30 	30-40 	>40
            35-44 	<21 	21-26 	26-31 	31-41 	>41
            45-54 	<22 	22-27 	27-32 	32-42 	>42
            55-64 	<23 	23-28 	28-33 	33-43 	>43
            65+ 	<24 	24-29 	29-34 	34-44 	>44

            BMI = kg / m^2
            **/

            $height = $height / 100; // must be in meters
            $bmi = $weight / ($height * $height);

            $bmi_current = $bmi;

            // reduce bmi by age interval
            if ( $age < 25 ) $bmi = $bmi + 0;
            if ( $age < 35 && $bmi > 24 ) $bmi = $bmi - 1;
            if ( $age < 45 && $bmi > 34 ) $bmi = $bmi - 2;
            if ( $age < 55 && $bmi > 44 ) $bmi = $bmi - 3;
            if ( $age < 65 && $bmi > 54 ) $bmi = $bmi - 4;
            if ( $age > 64 ) $bmi = $bmi - 5;

            if ( $bmi <= 16 ) $bmi_status = __('critical (too low)',true);
            if ( $bmi >= 16 && $bmi < 20 ) $bmi_status = __('not critical (but too low)',true);
            if ( $bmi >= 20 && $bmi < 25 ) $bmi_status = __('normal',true);
            if ( $bmi >= 25 && $bmi < 30 ) $bmi_status = __('not critical (but too high)',true);
            if ( $bmi >= 30 ) $bmi_status = __('critical (too high)',true);

            $return['bmi_status'] = $bmi_status;
            $return['bmi'] = round($bmi_current, 1);
            return $return;
   }

   /**
   format a number in correct format
   **/
   function format_number($number, $decimals = 0, $thousand_separator = '&nbsp;', $decimal_point = '.')
   {
            $tmp1 = round((float) $number, $decimals);

            while (($tmp2 = preg_replace('/(\d+)(\d\d\d)/', '\1 \2', $tmp1)) != $tmp1)
                  $tmp1 = $tmp2;

            return strtr($tmp1, array(' ' => $thousand_separator, '.' => $decimal_point));
   }
   /**
   is the send amount a correct decimal number?
   **/
   function check_decimal( $amount )
   {
            $amount = trim($amount);

            // if decimal numbers on the right side are more than 100 - problemos :)

            //if ( preg_match("~^([0-9]+|(?:(?:[0-9]{1,3}([.,' ]))+[0-9]{3})+)(([.,])[0-9]{1,2})?$~", $amount, $parts) )
            if ( preg_match("~^([0-9]+|(?:(?:[0-9]{1,3}([.,' ]))+[0-9]{3})+)(([.,])[0-9]{1,100})?$~", $amount, $parts) )
            {
                 //print_r($parts);
                 if ( !empty($parts['2']) )
                 {
                      $pre = preg_replace("~[".$parts['2']."]~", "", $parts['1']);
                 } else
                 {
                      $pre = $parts['1'];
                 }
                 if ( !empty($parts['4']) )
                 {
                      $post = ".".preg_replace("~[".$parts['4']."]~", "", $parts['3']);
                 } else
                 {
                      $post = false;
                 }
                 $format_amount = $pre.$post;

                 return $format_amount;
            }
            return false;
   }

   /**
   a lot of date and time functions
   time_from_to - what is the difference between 2 dates
   **/
   function time_from_to( $date_from, $date_to )
   {
            if ( $date_from == "" )
            {
                $date_from_ts = time();
            } else
            {
                list($year,$month,$day) = explode("-",$date_from);
                $date_from_ts = mktime( 0, 0, 0, $month, $day, $year );
            }

            $date_to_string = $date_to['year'] . '-' . $date_to['month'] . '-' . $date_to['day'];
            list($year,$month,$day) = explode("-", $date_to_string);
            $date_to_ts = mktime( 0, 0, 0, $month, $day, $year );

            $diff['days'] = ($date_to_ts - $date_from_ts) / ( 3600 * 24 );
            // TODO (B) 30 days =/= 1 month
            // that might not be correct :)
            $diff['months'] = $diff['days'] / 30;

            return $diff;
   }

   /**
   convert HH:MM:SS to seconds
   **/
   function time_to_seconds( $time )
   {
            // HH:MM:SS to seconds
            $time = trim( $time );
            $time_array = explode( ":", $time );
            if ( count( $time_array ) == 3 )
            {
               $seconds = $time_array[2];
               $minutes_in_seconds = $time_array[1] * 60;
               $hours_in_seconds = $time_array[0] * 3600;

               $result = $seconds + $minutes_in_seconds + $hours_in_seconds;
               return $result;

            } else
               return false;
   }

   /**
   convert seconds to HH:MM:SS
   **/
   function seconds_to_time( $seconds )
   {
            $hours = intval( $seconds / 3600 );
            $rest_hours = $seconds - ( $hours * 3600 );
            $minutes = intval( $rest_hours / 60 );
            $rest_minutes = $seconds - ( $hours * 3600 ) - ( $minutes * 60 );
            $seconds2 = intval( $rest_minutes );

            $result = sprintf("%02d", $hours) . ":" . sprintf("%02d", $minutes) . ":" . sprintf("%02d", $seconds2);

            return $result;
   }

   /**
   calculate age from birthday on
   **/
   function how_old( $birthday )
   {
			if ( is_array( $birthday ) ) $birthday = $birthday['year'] . '-' . $birthday['month'] . '-' . $birthday['day'];
            if ( !isset( $birthday ) ) return 0;
            //calculate years of age (input string: YYYY-MM-DD)
            list($year,$month,$day) = explode("-",$birthday);
            $year_diff  = date("Y") - $year;
            $month_diff = date("m") - $month;
            $day_diff   = date("d") - $day;
            if ($day_diff < 0 || $month_diff < 0)
               $year_diff--;

            return $year_diff;
   }

   /**
   show date in correct format (depending on your user profile)
   save date in correct format
   **/
   function check_date( $date, $mode = 'show', $session_unitdate_overwrite = '' )
   {
            $session_userobject = $this->Session->read('userobject');
			
			$session_unidate = '';
            if ( isset( $session_unitdate_overwrite ) && $session_unitdate_overwrite != '' ) 
            	$session_unitdate = $session_unitdate_overwrite;
				
			else
			{
				$session_unitdate = $session_userobject['unitdate'];
			}
			
            if ( $session_unitdate == '' ) 
            	$session_unitdate = $this->Session->read('session_unitdate');
				
            if ( $session_unitdate == '' )
				$session_unitdate = 'yyyymmdd'; 
			
            $return = "";

            // save / show / display
            if ( $mode == 'show' )
            {
               $date_split_fromtime = split( ' ', $date );
               $date_split = split( '-', $date_split_fromtime[0] );
               switch ( $session_unitdate )
               {
                      case "ddmmyyyy":
                      $return = $date_split[2] . '.' . $date_split[1] . '.' . $date_split[0];
                      break;

                      case "mmddyyyy":
                      $return = $date_split[1] . '.' . $date_split[2] . '.' . $date_split[0];
                      break;

                      case "yyyymmdd":
                      $return = $date_split[0] . '-' . $date_split[1] . '-' . $date_split[2];
                      break;
               }
            } elseif ( $mode == 'save' )
            {

               switch ( $session_unitdate )
               {
                      case "ddmmyyyy":
                      $date_split = split( '\.', $date );
                      $return = $date_split[2] . '-' . $date_split[1] . '-' . $date_split[0];
                      break;

                      case "mmddyyyy":
                      $date_split = split( '\.', $date );
                      $return = $date_split[2] . '-' . $date_split[0] . '-' . $date_split[1];
                      break;

                      case "yyyymmdd":
                      $date_split = split( '-', $date );
                      if ( count( $date_split ) == 3 )
					  {
	                      // in case you get a wrong format
	                      $return = $date_split[0] . '-' . $date_split[1] . '-' . $date_split[2];
					  } else
					  {
					  		$return = 0;
					  }
                      break;
               }

            }
            return $return;
   }

   /**
    * calculate trimp
    *
    */
   function calc_trimp( $duration_total, $avg_pulse_total, $time_in_zones, $lth, $sport )
   {
           // duration must be in minutes!!
           $trimp = 0;
           $avgHR = $avg_pulse_total;
           $minutes = $duration_total;
           $this->threshold = $lth;

           $zones = $this->getZones($sport);
           if ($avgHR < $zones[1])
           {
              $factor = 1;
           } else if ($avgHR < $zones[2])
           {
              $factor = 1.1;
           } else if ($avgHR < $zones[3])
           {
              $factor = 1.2;
           } else if ($avgHR < $zones[4])
           {
              $factor = 2.2;
           } else
           {
              $factor = 4.5;
           }

           // adapted to match athlete->calcTRIMP();
           return intval($minutes * $factor);
   }

	/**
	 * (non-PHPdoc)
	 * @see Athlete::getZones()
	 */
	function getZones($sport) {
    	return $this->Provider->getAthlete()->getZones($sport);
	}
       
   /**
   this functions seems to be duplicate - damn!
   **/
   function diff_dates( $date_from, $date_to )
   {
            //$date_to_string = $date_to['year'] . '-' . $date_to['month'] . '-' . $date_to['day'];
            list($year_from, $month_from, $day_from) = explode("-", $date_from);
            $ts_from = mktime( 0, 0, 0, $month_from, $day_from, $year_from );

            list($year_to, $month_to, $day_to) = explode("-", $date_to);
            $ts_to = mktime( 0, 0, 0, $month_to, $day_to, $year_to );

            $diff_in_days = ($ts_to - $ts_from)/(3600*24);

            return $diff_in_days;
   }

/**
   function date_plus_days( $date, $days, $calctype = 'plus' )
   {
            list($year, $month, $day) = explode("-", $date);
            $ts = mktime( 0, 0, 0, $month, $day, $year );

            if ( $calctype == 'plus' )
            {
                 $ts_return = $ts + ( $days * 24 * 3600 );
            } elseif ( $calctype == 'minus' )
            {
                 $ts_return = $ts - ( $days * 24 * 3600 );
            }

            $date_return = date( "Y-m-d", $ts_return );

            return $date_return;
   }
**/

   /**
   take given daten and add/subtract days
   **/
   function date_plus_days( $date, $days )
   {
            // TODO (B) - replace with strtotime
            if ( strpos( $date, ' ' ) )
            {
                 $date_split = explode( ' ', $date );
                 $date = $date_split[0];
            }

            list($year, $month, $day) = explode( '-', $date );
            $ts = mktime( 0, 0, 0, $month, $day, $year );

            $ts_return = $ts + ( $days * 86400 );

            $date_return = date( "Y-m-d", $ts_return );

            return $date_return;
   }

   /**
   some helper function - don't wanna explain that :)
   **/
   function month_in_year( $month, $year )
   {
            if ( $month > 12 )
            {
                 $month -= 12;
                 $year++;
            }

            if ( $month < 1 )
            {
                 $month += 12;
                 $year--;
            }
            $return['month'] = $month;
            $return['year'] = $year;

            return $return;
   }

   /**
   take a given date and return the start and end of a season
   **/
   function get_season( $userdata, $sentdata )
   {
               // if no event is saved, than use current date
               if ( !is_array( $sentdata ) )
               {
                  $sentdata['Competition']['competitiondate']['month'] = date('m', time());
                  $sentdata['Competition']['competitiondate']['year'] = date('Y', time());
               }

			   if ( $userdata['User']['coldestmonth'] < 10 )
			   		$userdata['User']['coldestmonth'] = '0' . $userdata['User']['coldestmonth'];
					
               $seasonstartmonth = $seasonendmonth = $userdata['User']['coldestmonth'];
               $compmonth = $sentdata['Competition']['competitiondate']['month'];
               $compyear = $sentdata['Competition']['competitiondate']['year'];

               if ( $seasonstartmonth < $compmonth )
               {
                   $seasonstartyear = $compyear;
                   $seasonendyear = $compyear+1;
               } else
               {
                   $seasonstartyear = $compyear-1;
                   $seasonendyear = $compyear;
               }

               $season['start'] = $seasonstartyear . '-' . $seasonstartmonth . '-01';
               $season['end']   = $seasonendyear . '-' . $seasonendmonth . '-01';

               return $season;
   }

   /**
   * return the correct currency for a country
   * KEEP UP-TO-DATE !!
   **/
   function currency_for_country( $country )
   {
            $eur_countries = array( 'D', 'AT', 'F', 'GB', 'BE', 'BG', 'HR', 'CZ', 'GR', 'HU', 'LI', 'LU', 'PL', 'PT', 'RO', 'SK', 'SI', 'ES' );

            if ( in_array( $country, $eur_countries ) )
                $currency = 'EUR';
            else
                $currency = 'USD';

            return $currency;
   }


	function get_prices( $country = null, $currency = null, $userobject )
	{
		if ( isset( $country ) ) $currency = $this->currency_for_country( $country );
		elseif ( !isset( $currency ) )  $currency = 'USD';
		
		// show special prices for companies			
		if ( isset( $userobject['inviter'] ) && preg_match( '/@/', $userobject['inviter'] ) && preg_match( '/'.$userobject['inviter'].'/', Configure::read('company_emails') ) )
		{
			$price_eur = Configure::read('company_price_eur');
			$price_eur_month = Configure::read('company_price_eur_month');
			$price_usd = Configure::read('company_price_usd');
			$price_usd_month = Configure::read('company_price_usd_month');
		} elseif ( isset( $userobject['admin'] ) && $userobject['admin'] == '1' )
		{
			$price_eur = Configure::read('tct_price_eur');
			$price_eur_month = Configure::read('tct_price_eur_month');
		} else
		{
			$price_eur = Configure::read('price_eur');
			$price_eur_month = Configure::read('price_eur_month');
			$price_usd = Configure::read('price_usd');
			$price_usd_month = Configure::read('price_usd_month');
		}
				
		if ( $currency == 'USD' )
		{
			$price_array_split['USD']['total'] = str_replace( '"', '', split(",",$price_usd));
			$price_array_split['USD']['month'] = str_replace( '"', '', split(",",$price_usd_month));
		} else
		{
			$price_array_split['EUR']['total'] = str_replace( '"', '', split(",",$price_eur));
			$price_array_split['EUR']['month'] = str_replace( '"', '', split(",",$price_eur_month));
		}
				
		return $price_array_split;
	}
	
   /**
    * this function should return you the coldest month for various countries
    * TODO (B) not finished 
    */
   function coldestmonth_for_country( $country )
   {
            /**
            $countries = array( 'D', 'AT', 'F', 'GB', 'BE', 'BG', 'HR', 'CZ', 'GR', 'HU', 'LI', 'LU', 'PL', 'PT', 'RO', 'SK', 'SI', 'ES' );

            if ( in_array( $country, $eur_countries ) )
                $currency = 'EUR';
            else
                $currency = 'USD';
            **/
            return '1';
   } 

   /**
    * this function should return you the right metric / units for various countries
    * TODO (B) not finished 
    */
   function unit_for_country( $country, $type )
   {
            /**
            $countries = array( 'D', 'AT', 'F', 'GB', 'BE', 'BG', 'HR', 'CZ', 'GR', 'HU', 'LI', 'LU', 'PL', 'PT', 'RO', 'SK', 'SI', 'ES' );

            if ( in_array( $country, $eur_countries ) )
                $currency = 'EUR';
            else
                $currency = 'USD';
            **/
            if ( $type == 'unitdate' )
                  return 'yyyymmdd';
            elseif ( $type == 'unit' )
                  return 'metric';
   } 

   function get_sports()
   {
            $session_userobject = $this->Session->read('userobject');
            if (  $session_userobject['unit'] == 'imperial' )
            {
                $unit = 'mi';
                $convertunit = 'km_mi';
            } else
            {
                $unit = 'km';
                $convertunit = '';
            }  
            
            $tri_ironman = __('Ironman', true) . ' (' . 
              $this->convert_metric( '3.8', $convertunit, 1 ) . ' ' . $unit . ' ' . __('Swim', true) . ', ' .  
              $this->convert_metric( '180', $convertunit, 0 ) . ' ' . $unit . ' ' . __('Bike', true) . ', ' . 
              $this->convert_metric( '42', $convertunit, 0 ) . ' ' . $unit . ' ' . __('Run', true) . ')';
            $tri_halfironman = __('Half-Ironman', true) . ' (' .
              $this->convert_metric( '1.9', $convertunit, 1) . ' ' . $unit . ' ' . __('Swim', true) . ', ' . 
              $this->convert_metric( '90', $convertunit, 0 ) . ' ' . $unit . ' ' . __('Bike', true) . ', ' .
              $this->convert_metric( '21', $convertunit, 0 ) . ' ' . $unit . ' ' . __('Run', true) . ')';
            $tri_olympic = __('Olympic Distance', true) . ' (' .
              $this->convert_metric( '1.5', $convertunit, 1 ) . ' ' . $unit . ' ' . __('Swim', true) . ', ' . 
              $this->convert_metric( '40', $convertunit, 0 ) . ' ' . $unit . ' ' . __('Bike', true) . ', ' .
              $this->convert_metric( '10', $convertunit, 0 ) . ' ' . $unit . ' ' . __('Run', true) . ')';
            $tri_sprint = __('Sprint Distance', true) . ' (' . 
              $this->convert_metric( '0.75', $convertunit, 1 ) . ' ' . $unit . ' ' . __('Swim', true) . ', ' . 
              $this->convert_metric( '20', $convertunit, 0 ) . ' ' . $unit . ' ' . __('Bike', true) . ', ' .
              $this->convert_metric( '5', $convertunit, 0 ) . ' ' . $unit . ' ' . __('Run', true) . ')';
                
            $run_ultra = __('Ultrarun', true) . ' (> ' . $this->convert_metric( '50', $convertunit, 0 ) . ' ' . $unit . ' ' . __('Run', true) . ')';
            $run_marathon = __('Marathon', true) . ' (' . $this->convert_metric( '42', $convertunit, 0 ) . ' ' . $unit . ' ' . __('Run', true) . ')';
            $run_halfmarathon = __('Half-Marathon', true) . ' (' . $this->convert_metric( '21', $convertunit, 0 ) . ' ' . $unit . ' ' . __('Run', true) . ')';
            $run_10k = __('Race', true) . ' (' . $this->convert_metric( '10', $convertunit, 0 ) . ' ' . $unit . ' ' . __('Run', true) . ')';
            $run_5k = __('Race', true) . ' (' . $this->convert_metric( '5', $convertunit, 0 ) . ' ' . $unit . ' ' . __('Run', true) . ')';
                
            $duathlon_middle = __('Duathlon', true) . ' (' . 
              $this->convert_metric( '10', $convertunit, 0 ) . ' ' . $unit . ' ' . __('Run', true) . ', ' . 
              $this->convert_metric( '60', $convertunit, 0 ) . ' ' . $unit . ' ' . __('Bike', true) . ', ' .
              $this->convert_metric( '10', $convertunit, 0 ) . ' ' . $unit . ' ' . __('Run', true) . ')';
            $duathlon_short = __('Duathlon', true) . ' (' .
              $this->convert_metric( '5', $convertunit, 0 ) . ' ' . $unit . ' ' . __('Run', true) . ', ' . 
              $this->convert_metric( '40', $convertunit, 0 ) . ' ' . $unit . ' ' . __('Bike', true) . ', ' .
              $this->convert_metric( '10', $convertunit, 0 ) . ' ' . $unit . ' ' . __('Run', true) . ')';
                
            $bike_ultra = __('Races', true) . ' (> ' . $this->convert_metric( '150', $convertunit, 0 ) . ' ' . $unit . ')';
            $bike_long = __('Races', true) . ' (' . $this->convert_metric( '100', $convertunit, 0 ) . '-' . $this->convert_metric( '150', $convertunit, 0 ) . ' ' . $unit . ')';
            $bike_middle = __('Races', true) . ' (' . $this->convert_metric( '50', $convertunit, 0 ) . '-' . $this->convert_metric( '100', $convertunit, 0 ) . ' ' . $unit . ')';
            $bike_short = __('Races', true) . ' (< ' . $this->convert_metric( '50', $convertunit, 0 ) . ' ' . $unit . ')';

            $sports = array(
                 'Triathlon' => array (
                             'TRIATHLON IRONMAN' => $tri_ironman,
                             'TRIATHLON HALFIRONMAN' => $tri_halfironman,
                             'TRIATHLON OLYMPIC' => $tri_olympic,
                             'TRIATHLON SPRINT' => $tri_sprint
                 ),
                 'Running' => array(
                             'RUN ULTRA' => $run_ultra,
                             'RUN MARATHON' => $run_marathon,
                             'RUN HALFMARATHON' => $run_halfmarathon,
                             'RUN 10K' => $run_10k,
                             'RUN 5K' => $run_5k
                 ),
                 'Duathlon' => array(
                             'DUATHLON MIDDLE' => $duathlon_middle,
                             'DUATHLON SHORT' => $duathlon_short
                 ),
                 'Bikeracing' => array(
                             'BIKE ULTRA' => $bike_ultra,
                             'BIKE LONG' => $bike_long,
                             'BIKE MIDDLE' => $bike_middle,
                             'BIKE SHORT' => $bike_short
                 )
            );

            // for translation
            __('TRIATHLON IRONMAN', true);
            __('TRIATHLON HALFIRONMAN', true);
            __('TRIATHLON OLYMPIC', true);
            __('TRIATHLON SPRINT', true);
            __('RUN ULTRA', true);
            __('RUN MARATHON', true);
            __('RUN HALFMARATHON', true);
            __('RUN 10K', true);
            __('RUN 5K', true);
            __('DUATHLON MIDDLE', true);
            __('DUATHLON SHORT', true);
            __('BIKE ULTRA', true);
            __('BIKE LONG', true);
            __('BIKE MIDDLE', true);
            __('BIKE SHORT', true);
            
            return $sports; 
   }

   function get_countries()
   {
              $countries = array(
                    'D' => __('Germany', true),
                    'AT' => __('Austria', true),
                    'AU' => __('Australia', true),
                    'CA' => __('Canada', true),
                    'F' => __('France', true),
                    'GB' => __('United Kingdom', true),
                    'US' => __('United States of America', true),
                    '' => '--------------',
                    'AD' => __('Andorry', true),
                    'AR' => __('Argentina', true),
                    'BE' => __('Belgium', true),
                    'BA' => __('Bosnia', true),
                    'BR' => __('Brazil', true),
                    'BG' => __('Bulgaria', true),
                    'CN' => __('China', true),
                    'HR' => __('Croatia', true),
                    'CY' => __('Cyprus', true),
                    'CZ' => __('Czech Republic', true),
                    'DK' => __('Denmark', true),
                    'EE' => __('Estonia', true),
                    'FI' => __('Finland', true),
                    'GR' => __('Greece', true),
                    'GCA' => __('Guatemala', true),
                    'HK' => __('Hong Kong', true),
                    'HU' => __('Hungary', true),
                    'IN' => __('India', true),
                    'IE' => __('Ireland', true),
                    'IL' => __('Israel', true),
                    'IT' => __('Italy', true),
                    'JP' => __('Japan', true),
                    'ADN' => __('Jemen', true),
                    'LV' => __('Latvia', true),
                    'LI' => __('Liechtenstein', true),
                    'LT' => __('Lithuania', true),
                    'LU' => __('Luxembourg', true),
                    'MT' => __('Malta', true),
                    'NL' => __('Netherlands', true),
                    'NZ' => __('New Zealand', true),
                    'NO' => __('Norway', true),
                    'PE' => __('Peru', true),
                    'PL' => __('Poland', true),
                    'PT' => __('Portugal', true),
                    'RU' => __('Russian Federation', true),
                    'RO' => __('Romania', true),
                    'SK' => __('Slovakia', true),
                    'SI' => __('Slovenia', true),
                    'CH' => __('Switzerland', true),
                    'ZA' => __('South Africa', true),
                    'ES' => __('Spain', true),
                    'SE' => __('Sweden', true),
                    'TW' => __('Taiwan', true),
                    'TR' => __('Turkey', true),
                    'UA' => __('Ukraine', true),
                    'OTH' => __('Other', true)
              );
        return $countries;
    }

    function is_utf8( $str )
    {
      $strlen = strlen( $str );
      for($i=0; $i < $strlen; $i++)
      {
        $ord = ord( $str[$i] );
        if ($ord < 0x80) continue; // 0bbbbbbb
        elseif (($ord&0xE0)===0xC0 && $ord>0xC1) $n = 1; // 110bbbbb (exkl C0-C1)
        elseif (($ord&0xF0)===0xE0) $n = 2; // 1110bbbb
        elseif (($ord&0xF8)===0xF0 && $ord<0xF5) $n = 3; // 11110bbb (exkl F5-FF)
        else 
          return false; // ungültiges UTF-8-Zeichen
        for ($c=0; $c<$n; $c++) // $n Folgebytes? // 10bbbbbb
          if (++$i===$strlen || (ord($str[$i])&0xC0)!==0x80)
            return false; // ungültiges UTF-8-Zeichen
      }
      return true; // kein ungültiges UTF-8-Zeichen gefunden
    }

    /**
     * http://www.triathlontrainingblog.com/calculators/calories-burned-calculator-based-on-average-heart-rate/
	 *
     * Based on the following formulas:
	 *
     * Without VO2max
     * Men: C/min = (-55.0969 + 0.6309 x HR + 0.1988 x weight + 0.2017 x age) / 4.184
     * Women: C/min = (-20.4022 + 0.4472 x HR + 0.1263 x weight + 0.074 x age) / 4.184
     * 
     * weight is in kg
     * duration is in seconds
     */
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

    function calc_kcal( $data )
    {
      $avgHR = $data['avg_pulse'];
      $duration = $data['duration'];
      $age = $this->how_old($data['birthday']);
      $weight = $data['weight'];

      // calculate kcal for workout
      if ( $data['gender'] == 'm' )
      {
          $kcal = 
            round(( -55.0969 + 0.6309 * $avgHR + 0.1988 * $weight + 0.2017 * $age ) / 4.1845
            * $duration/60);
      } else
      {
          $kcal = 
            round((-20.4022 + 0.4472 * $avgHR + 0.1263 * $weight + 0.074 * $age ) / 4.1845
            * $duration/60);
      }
      return $kcal;
    }
    
}

?>