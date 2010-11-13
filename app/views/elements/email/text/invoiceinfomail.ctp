
<?php __('Hello'); ?> <?php echo $user['User']['firstname']; ?>,

<?php __('Thank you for subscribing to TriCoreTraining-Plans for'); ?> <?php echo $timeinterval; ?> <?php __('months'); ?>.

<?php __('You will receive an invoice as soon as PAYPAL charges the subscription fee. This might happen after your trial-period expired.'); ?>

<?php __('Old period:'); ?> <?php echo $payed_from; ?> <?php __('to'); ?> <?php echo $payed_to; ?>
<?php __('New period:'); ?> <?php echo $payed_new_from; ?> <?php __('to'); ?> <?php echo $payed_new_to; ?>

<?php __('Yours, Clemens'); ?>

<?php echo $this->element('email/newsletter_text_footer'); ?>
