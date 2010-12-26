
<?php echo $this->element('email/newsletter_header'); ?>

 <table cellspacing="0" cellpadding="4" bgcolor="#FFAE00" width="100%">
    <tr>
       <td>
          <h2><?php __('Aloha'); ?> Admin,</h2>
       </td>
    </tr>
 </table>

 <p><i><?php __('some notification arrived.'); ?></i></p>
 <p>
<?php

echo $error;
echo '<hr>';
print_r( $user );
echo '<hr>';
print_r( $array );

?>
 </p>
 
 <p><?php __('Yours, Clemens'); ?></p>
 <br />

<?php echo $this->element('email/newsletter_footer'); ?>
