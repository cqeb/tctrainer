<?php

class RebatehandlerComponent extends Object {
	
   var $components = array('Session');
   var $helpers = array('Session');

   // TODO get from config
   var $company_rebate = 
		array( 
			//'A1TA30P' => 'a1telekom.at',
			//'TAG30P' => 'telekomaustria.com'
		);
			 
   function check_code( $code, $user )
   {
		if ( isset( $company_rebate[$code] ) )
		{
				$email_regex = $company_rebate[$code];
				if ( strpos( $user['email'], $email_regex ) > 0 )
						return true;
				else
						return false;			
		}

   }

}

?>