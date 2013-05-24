<?php

/**
default transaction component
for handling secure saving of parameters via transaction-key
is for temporary information/data
**/

class TransactionhandlerComponent extends Object {
   var $components = array('Session');
   var $helpers = array('Session');

   function handle_transaction( $model, $tid = null, $mode = 'create', $key = '', $val = '' )
   {
            // create // add // read
	        //$this->loadModel('Transaction');

            // create transaction
            // if tid is already existing then create a new tid
            // TODO (B)
            if ( $mode == 'create' )
            {
               $tid = rand() . microtime();
               $tid = substr( md5($tid), 0, 8);

               $model->create();
            }

            // add parameter to transaction
            if ( $mode == 'add' )
            {
               $model->create();
            }

            // read from transaction
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

   function _delete_transaction( $model, $tid )
   {
            $model->deleteAll("Transaction = \"$tid\"");
            return true;
   }

   function _delete_old_transactions( $model )
   {
            $until_date = date( 'Y-m-d', (time()-86400*14) );
            $conditions = 'created BETWEEN \"2010-01-01\" AND \"' . $until_date . '\"';

            // PRIO (B) currently deactivated
            //$model->deleteAll($conditions);
            return true;
   }

   function _decrypt_data( $text ) {

       $text = base64_decode(base64_decode($text));
       
       return $text;
   }

   function _encrypt_data( $text ) {

       $text = base64_encode(base64_encode($text));

       return $text;

   }

}
?>