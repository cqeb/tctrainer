
<?php __('Hi'); ?> <?php echo $user['User']['firstname']; ?>,

<?php __('your password is reset.'); ?>

<?php __('Your new password on TriCoreTraining (https://tricoretraining.com) is'); ?> <?php echo $randompassword; ?>.

<?php __('Click here to login'); ?>:
<?php echo Configure::read('App.hostUrl'); echo Configure::read('App.serverUrl'); ?>/users/login/

<?php echo $this->element('email/newsletter_text_footer'); ?>

