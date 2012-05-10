<?php 

class NotificationsShell extends Shell {
    
  var $uses = array( 'User' );
  
  function main() {

      $this->requestAction('/users/check_notifications');     
    
  }

}
  
?>