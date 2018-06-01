
<?php 

    if ($_SERVER['REMOTE_ADDR'] == MYIP) {

        echo 'DEBUG KMS';

        if ( $this->Session->read('DEBUGLOG') ) echo $this->Session->read('DEBUGLOG');

        echo 'SESSION KMS';

        if (isset($this->Session)) print_r($this->Session);

        echo 'COOKIE KMS';

        if (isset($this->Cookie)) print_r($this->Cookie);
        
    }
?>

<?php 
if ( isset( $cakeDebug ) && DEBUG ) { 
    print_r( $cakeDebug ); 
} 
?>
