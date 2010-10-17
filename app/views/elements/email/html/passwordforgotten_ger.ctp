<pre>
Hi athlete <?php echo $user['User']['firstname']; ?>,

you tried to recover your password on TriCoreTraining.com

Please <a href="<?php echo Configure::read('App.hostUrl'); echo Configure::read('App.serverUrl'); ?>/users/password_reset/transaction_id:<?php echo $transaction_id?>">click to reset your password.</a>

best regards, Klaus-M.
--
TriCoreTraining.com - your individual trainingplans
Verein
Becomerich Street 11
A-1010 Vienna
Austria

Web:   http://www.tricoretraining.com
Email: km.schremser@tricoretraining.com
Phone: +43 699 1 6301524

<?php
/**
   echo $html->link(
        'Password reset', 'http://localhost:8080', array('controller' => 'users', 'action' => 'password_reset',
        'email' => $encoded_email, 'userid' => $encoded_id));
**/
?>

</pre>