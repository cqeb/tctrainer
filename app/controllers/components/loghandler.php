<?php

/**
save logs in database
especially for PAYPAL integration
**/

class LoghandlerComponent extends Object {
   var $components = array('Session');
   var $helpers = array('Session');

   function handle_log( $model, $logtype, $logmessage, $logcomment )
   {
            $model->create();

            $this->data_l['Log']['logtype'] = $logtype;
            $this->data_l['Log']['logmessage'] = $logmessage;
            $this->data_l['Log']['comment'] = $logcomment;

            if ( $model->save(
                          $this->data_l,
                          array(
                                 'validate' => true,
                                 'fieldList' =>
                                             array( 'logtype', 'logmessage', 'comment' )
                                 )
                          )
            )
                          return true;
            else
                          return false;

/**
            $results = $model->findAllByTransaction($tid);

            for($i = 0; $i < count($results); $i++)
            {
                  $keyword = $results[$i]['Transaction']['transaction_key'];
                  $value = $results[$i]['Transaction']['transaction_value'];
                  $result[$keyword] = $value;
            }

            if ( count( $results ) > 0 ) return $result;
            else return false;
**/

   }

}

?>