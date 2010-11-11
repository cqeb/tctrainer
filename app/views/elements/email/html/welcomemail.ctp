
 <table cellspacing="0" cellpadding="4" bgcolor="#FFAE00">
    <tr>
       <td>
          <h2><?php __('Welcome'); ?> <?php echo $user['User']['firstname']; ?>,</h2>
       </td>
    </tr>
 </table>

 <p><i><?php __('you completed the first step for gaining speed in your sport and probably loosing weight.'); ?></i></p>
 <p><?php __('Your trial period is FREE and ends automatically if you do not subscribe to a membership.'); ?></p>
 <p class="more"><a href="<?php echo Configure::read('App.hostUrl'); echo Configure::read('App.serverUrl'); ?>/users/activate/transaction_id:<?php echo $transaction_id?>"><?php __('Click to activate your account'); ?></a></p>
                           
 <p><?php __('Login to your personal training dashboard.'); ?></p>
 <p><?php __('Yours, Clemens'); ?></p>

