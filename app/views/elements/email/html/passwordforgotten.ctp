
<?php echo $this->element('email/newsletter_header'); ?>

 <table cellspacing="0" cellpadding="4" bgcolor="#FFAE00" width="100%">
    <tr>
       <td>
          <h2><?php __('Aloha'); ?> <?php echo $user['User']['firstname']; ?>,</h2>
       </td>
    </tr>
 </table>

 <p><i><?php __('you tried to recover your password on TriCoreTraining.com.'); ?></i></p>
 <p class="more"><?php __('Please'); ?> <a href="<?php echo Configure::read('App.hostUrl'); echo Configure::read('App.serverUrl'); ?>/users/password_reset/transaction_id:<?php echo $transaction_id?>"><?php __('click to reset your password.'); ?></a></p>

 <p><?php __('Yours, Clemens'); ?></p>
 <br /> 

<?php echo $this->element('email/newsletter_footer'); ?>
