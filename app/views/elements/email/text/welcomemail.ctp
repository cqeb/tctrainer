
<?php __('Welcome'); ?> <?php echo $user['User']['firstname']; ?>,

<?php __('you completed the first step for gaining speed in your sport and probably loosing weight.'); ?>

<?php __('Your trial period is FREE and ends automatically if you do not subscribe to a membership.'); ?>

<?php __('Click to activate your account'); ?>
<?php echo Configure::read('App.hostUrl'); echo Configure::read('App.serverUrl'); ?>/users/activate/transaction_id:<?php echo $transaction_id?>
                           
<?php __('Login to your personal training dashboard.'); ?>

<?php echo $this->element('email/newsletter_text_footer'); ?>


