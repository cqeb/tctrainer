
<?php __('Hi'); ?> <?php echo $user['User']['firstname']; ?>,

<?php __('Thank you for subscribing to a TriCoreTraining plan for'); ?> <?php echo $timeinterval; ?> <?php __('months'); ?>.

<?php __('You will receive an invoice as soon as the payment provider (PAYPAL) charges the subscription fee. This will happen after your trial-period expired.'); ?>

<?php __('Old period:'); ?> <?php echo $paid_from; ?> <?php __('to'); ?> <?php echo $paid_to; ?>
<?php __('New period:'); ?> <?php echo $paid_new_from; ?> <?php __('to'); ?> <?php echo $paid_new_to; ?>

<?php __('You are awesome. Happy training!'); ?>

<?php __('Cheers'); ?> Klaus-M.

<?php echo $this->element('email/newsletter_text_footer'); ?>
