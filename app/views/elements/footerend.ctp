
<?php 
echo "<pre style=\"border: 1px solid #000; height: 9em; overflow: auto; margin: 0.5em;\">";

if ($_SERVER['REMOTE_ADDR'] == MYIP || $this->Session->read('session_userid') == 1) {

    echo 'DEBUG KMS<br />';

    if ( $this->Session->read('DEBUGLOG') ) echo $this->Session->read('DEBUGLOG');

    echo 'SESSION KMS<br />';

    if ( isset($this->Session) ) print_r($this->Session);
    
    print_r($_SESSION);

    echo 'COOKIE KMS<br />';

    if ( isset($this->Cookie) ) print_r($this->Cookie);
    
    print_r($_COOKIE);
    
}
?>

<?php 
if ( isset( $cakeDebug ) && DEBUG ) { 
    print_r( $cakeDebug ); 
} 
echo "</pre>\n";

?>
