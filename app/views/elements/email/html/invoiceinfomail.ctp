
<?php echo $this->element('email/newsletter_header'); ?>

 <p><?php __('Hi'); ?> <?php echo $user['User']['firstname']; ?>,</p>

 <p><i><?php __('Thank you for subscribing to a TriCoreTraining plan for'); ?> <?php echo $timeinterval; ?> <?php __('months'); ?>.</i></p>
 <p><?php __('You will receive an invoice as soon as the payment provider (PAYPAL) charges the subscription fee. This will happen after your trial-period expired.'); ?></p>
 <p>
 <?php __('Old period:'); ?> <?php echo $paid_from; ?> <?php __('to'); ?> <?php echo $paid_to; ?><br />
 <?php __('New period:'); ?> <?php echo $paid_new_from; ?> <?php __('to'); ?> <?php echo $paid_new_to; ?>
 </p>
 <p>
     <?php __('You are awesome. Happy training!'); ?>
     <br /><br />
     <?php __('Cheers'); ?> Klaus-M.
</p> 

<img src="http://www.google-analytics.com/collect?v=1&tid=UA-116688964-1&cid=tct-2351&t=event&ec=email&ea=open&el=invoiceinfomail&cs=tricoretrainingsystem&cm=email&cn=mailopens&cm1=1" />


<?php echo $this->element('email/newsletter_footer'); ?>

