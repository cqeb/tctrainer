<?php

class UnitcalcHelper extends AppHelper {
   var $components = array('Session');
   var $helpers = array('Html', 'Javascript', 'Session');

   function beforeRender() 
   {

   }

/**
 * reuse code of component here
 */

   function convert_metric( $amount, $convertunit, $roundnumber = 0 )
   {
        return UnitcalcComponent::convert_metric( $amount, $convertunit, $roundnumber );
   }
 
   function check_distance( $amount, $mode = 'show', $ret = 'both' )
   {
        return UnitcalcComponent::check_distance( $amount, $mode, $ret );
   }

   function check_weight( $amount, $mode = 'show', $ret = 'both' )
   {
        return UnitcalcComponent::check_weight( $amount, $mode, $ret );
   }

   function check_height( $amount, $mode = 'show', $ret = 'both' )
   {
        return UnitcalcComponent::check_height( $amount, $mode, $ret );
   }

   function seconds_to_time( $seconds )
   {
        return UnitcalcComponent::seconds_to_time( $seconds );
   }

   function check_date( $date, $mode = 'show' )
   {
        return UnitcalcComponent::check_date( $date, $mode );
   }

   function format_number($number, $decimals = 0, $thousand_separator = '&nbsp;', $decimal_point = '.')
   {
        return UnitcalcComponent::format_number( $number, $decimals, $thousand_separator, $decimal_point );
   }

}
?>