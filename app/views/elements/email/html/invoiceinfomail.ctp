
<?php echo $this->element('email/newsletter_header'); ?>

 <table cellspacing="0" cellpadding="4" bgcolor="#FFAE00" width="100%">
    <tr>
       <td>
          <h2><?php __('Aloha'); ?> <?php echo $user['User']['firstname']; ?>,</h2>
       </td>
    </tr>
 </table>

 <p><i><?php __('Thank you for subscribing to TriCoreTraining-Plans for'); ?> <?php echo $timeinterval; ?> <?php __('months'); ?>.</i></p>
 <p><?php __('You will receive an invoice as soon as PAYPAL charges the subscription fee. This might happen after your trial-period expired.'); ?></p>
 <p>
 <?php __('Old period:'); ?> <?php echo $paid_from; ?> <?php __('to'); ?> <?php echo $paid_to; ?><br />
 <?php __('New period:'); ?> <?php echo $paid_new_from; ?> <?php __('to'); ?> <?php echo $paid_new_to; ?>
 </p>
  
<?php echo $this->element('email/newsletter_footer'); ?>

