
<?php __('Hi'); ?> <?php echo $user['User']['firstname']; ?>,

<?php __('you want to reset your password on TriCoreTraining.'); ?> (https://tricoretraining.com)

<?php __('Please'); ?> <?php __('click to reset your password.'); ?>
<?php echo Configure::read('App.hostUrl'); echo Configure::read('App.serverUrl'); ?>/users/password_reset/transaction_id:<?php echo $transaction_id?>

<?php echo $this->element('email/newsletter_text_footer'); ?>


