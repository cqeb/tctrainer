
 <table cellspacing="0" cellpadding="4" bgcolor="#FFAE00">
    <tr>
       <td>
          <h2><?php __('Hello'); ?> <?php echo $user['User']['firstname']; ?>,</h2>
       </td>
    </tr>
 </table>

 <p><i><?php __('Thank you for subscribing to TriCoreTraining-Plans for'); ?> <?php echo $timeinterval; ?> <?php __('months'); ?>.</i></p>
 <p><?php __('You will receive an invoice as soon as PAYPAL charges the subscription fee. This might happen after your trial-period expired.'); ?></p>
 <p>
 <?php __('Old period:'); ?> <?php echo $payed_from; ?> <?php __('to'); ?> <?php echo $payed_to; ?><br />
 <?php __('New period:'); ?> <?php echo $payed_new_from; ?> <?php __('to'); ?> <?php echo $payed_new_to; ?>
 </p>
 <!--<p class="more"><a href="<?php echo Configure::read('App.hostUrl'); echo Configure::read('App.serverUrl'); ?>/trainingstatistics/"><?php __('Yes, I\'ll do!'); ?></a></p>-->
 
 <p><?php __('Yours, Clemens'); ?></p>
