
<?php echo $this->element('email/newsletter_header'); ?>

 <table cellspacing="0" cellpadding="4" bgcolor="#FFAE00" width="100%">
    <tr>
       <td>
          <h2><?php __('Hi'); ?> <?php echo $user['User']['firstname']; ?>,</h2>
       </td>
    </tr>
 </table>

 <p><i><?php __('your password is reset.'); ?></i></p>
 <p><?php __('Your new password on TriCoreTraining (https://tricoretraining.com) is'); ?> <b><?php echo $randompassword; ?></b>.</p>
 <p class="more"><a href="<?php echo Configure::read('App.hostUrl'); echo Configure::read('App.serverUrl'); ?>/users/login/"><?php __('Click here to login'); ?>.</a></p>
                           

<?php echo $this->element('email/newsletter_footer'); ?>
