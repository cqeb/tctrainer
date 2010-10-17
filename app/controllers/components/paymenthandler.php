<?php

/**
create transactions for PAYPAL integration
is for permanent information/data
**/

class PaymenthandlerComponent extends Object {
   var $components = array('Session');
   var $helpers = array('Session');

   // TODO - not finished
   function handle_payment( $model, $tid = null, $mode = 'create', $key = '', $val = '' )
   {
            // create // add // read
	          //$this->loadModel('Transaction');

            if ( $mode == 'create' )
            {
              // get last invoice number
               $model->create();
            }

            if ( $mode == 'add' )
            {
               $model->create();
            }

            if ( $mode != 'read' )
            {
               $this->data_t['Transaction']['transaction'] = $tid;
               $this->data_t['Transaction']['transaction_key'] = $key;
               $this->data_t['Transaction']['transaction_value'] = $val;

               $model->save( $this->data_t, array( 'validate' => true, 'fieldList' => array( 'transaction', 'transaction_key', 'transaction_value' ) ) );

               return $tid;
            } else
            {
               $results = $model->findAllByTransaction($tid);
               for($i = 0; $i < count($results); $i++)
               {
                  $keyword = $results[$i]['Transaction']['transaction_key'];
                  $value = $results[$i]['Transaction']['transaction_value'];
                  $result[$keyword] = $value;
               }
               if ( count( $results ) > 0 ) return $result;
               else return false;
            }
   }

   function delete_payment( $model, $tid )
   {
            $model->deleteAll("Transaction = \"$tid\"");
            return true;
   }

}
?>