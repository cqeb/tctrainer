<?php

/** 
 * 
 * testing
 * 
 */

class FilldatabaseComponent extends Object 
{
   var $components = array('Session');
   var $helpers = array('Session');

  function prefill($model)
  {
      $number['users'] = 100;
      $number['competitions'] = 10;
      $number['tracks'] = 500;
      $number['plannedtrainings'] = 500;
              
      $model->query("DELETE FROM users WHERE id != 110");
      $model->query('DELETE FROM competitions WHERE user_id != 110');
      $model->query('DELETE FROM scheduledtrainings WHERE athlete_id != 110');
      $model->query('DELETE FROM trainingstatistics WHERE user_id != 110');

      for ( $i = 0; $i < $number['users']; $i++ )
      {
            if ( rand(1,2) == 1 ) $gender = 'm';
            else $gender = 'f';
            $randHR = rand( 180, 230 );
            $weight = rand( 65, 150 );
            $height = rand( 150, 210 );
            if ( rand(1,2) == 1 ) { $rookie = 1; $traininglevel = 1; $weeklyhours = rand(4,8); } else
              { $rookie = 0; $traininglevel = 4; $weeklyhours = rand(8,24); }
            if ( rand(1,2) == 1 ) {
              $unit = 'metric';
              $unitdate = 'ddmmyyyy';
            } else
            {
              $unit = 'imperial';
              $unitdate = 'yyyymmdd';
            }

            $sports_arr = array('TRIATHLON IRONMAN','TRIATHLON OLYMPIC','RUN MARATHON','BIKE LONG');
            $arr_idx = rand(0,3);
            $sport = $sports_arr[$arr_idx];            

            $sql = "INSERT INTO users VALUES (
            null, 'Klaus-M. " . $i . "', 'Prerovsky $i', '$gender', 
            'phone', 'address', 'zip', 'city', 'AT', 
            'tri" . $i . "@schremser.com', '1', '1975-11-26', md5('finger'), 
            1, $randHR, " . $randHR*0.85 . ", 'youknowus', 
            1, 'philo', '$sport', 0, $weight,
            '', 1, '', $height, '1', 
            '$unit', '$unitdate', 0, 0, 
            $rookie, $traininglevel, $weeklyhours, 
            'FRI', 1, 0, 'ger', 'image', 'bikeimage', 
            'freemember', '". date('Y-m-d', time()) . "', '" . date('Y-m-d', time()+86400*90) . "',
            0, 'cancelreason', '" .  date('Y-m-d', time()) . "', '" .  date('Y-m-d', time()) . "')";
            //echo $sql . "<br>";
                 
            $model->query( $sql );
            
            $sql = "SELECT id FROM users WHERE email = 'tri" . $i . "@schremser.com'";
            $return = $model->query( $sql );
            
            $userid = $return[0]['users']['id'];
            
            for ( $k = 0; $k < $number['competitions']; $k++ )
            {
               $sports_arr = array('TRIATHLON IRONMAN','TRIATHLON OLYMPIC','RUN MARATHON','BIKE LONG');
               $arr_idx = rand(0,3);
               $sport = $sports_arr[$arr_idx];            
               $important = rand(1,3);
               if ( $important != 1 ) $important = 0;
               // do not change $sport ?!
               $sql = "INSERT INTO competitions VALUES (null, $userid, '" . 
                    date( 'Y-m-d', time()+86400*rand(-365,365)) . "','Competition $k','$sport',
                    null,null,null,null,null,null,null,null,$important, 'Vienna, Austria', 
                    '" . date('Y-m-d', time()) . "', '" . date('Y-m-d', time()) . "' )";
               //echo $sql . "<br>";
               $model->query( $sql );
            }                
            for ( $l = 0; $l < $number['tracks']; $l++ )
            {
               $sportst_arr = array( 'RUN', 'BIKE', 'SWIM', 'RUN' );
               $arr_idx2 = rand(0,2);
               $sportst = $sportst_arr[$arr_idx2];
               $name = "Training $l";
               $distance = rand( 5,90 );
               if ( rand(1,2) == 1 ) { $testworkout = 1; $distance = 13; $sportst = 'RUN'; $name = 'Testworkout'; }
               else $testworkout = 0;  
               
               $sql = "INSERT INTO trainingstatistics VALUES (null, $userid, '$name', 
               '" . date( 'Y-m-d', time()+86400*rand(-365,365)) . "', '$sportst', " . $distance . ",
               " . rand( 1800, 18000 ) . "," . rand( 130,220 ) . ",0,0,0,0,0,0, " . rand( 500, 3000 ) . ",
               0, '', " . rand( 65, 88 ) . ", 0, '', $testworkout, 0, '','','','',
               '" . date('Y-m-d', time()) . "', '" . date('Y-m-d', time()) . "' )";
               //echo $sql . "<br>";
               $model->query( $sql );
            }
            for ( $m = 0; $m < $number['plannedtrainings']; $m++ )
            {
               $sportst_arr = array( 'RUN', 'BIKE', 'SWIM', 'RUN' );
               $arr_idx2 = rand(0,2);
               $sportst = $sportst_arr[$arr_idx2];

               $sql = "INSERT INTO scheduledtrainings VALUES ( $userid, 
               '" . date( 'Y-m-d', time()+86400*rand(-365,365)) . "', '$sportst', '" . substr( $sportst, 0, 2 ) . "',
               " . ( round ( rand( 1800, 18000 ) / 60 ) ) . "," . rand( 500,3000 ) . ", 0)";
               //echo $sql . "<br>";
               $model->query( $sql );
            }
      }
   }
}
?>