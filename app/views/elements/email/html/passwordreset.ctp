
 <table cellspacing="0" cellpadding="4" bgcolor="#FFAE00">
    <tr>
       <td>
          <h2><?php __('Hello'); ?> <?php echo $user['User']['firstname']; ?>,</h2>
       </td>
    </tr>
 </table>

 <p><i><?php __('your password is reset.'); ?></i></p>
 <p><?php __('Your new password on TriCoreTraining.com is'); ?> <?php echo $randompassword; ?>.</p>
 <p class="more"><a href="<?php echo Configure::read('App.hostUrl'); echo Configure::read('App.serverUrl'); ?>/users/login/"><?php __('Click here to login'); ?>.</a></p>
                           
 <p><?php __('Yours, Clemens'); ?></p>
