
<?php __('Aloha'); ?> <?php echo $user['User']['firstname']; ?>,

<?php __('your password is reset.'); ?>

<?php __('Your new password on TriCoreTraining.com is'); ?> <?php echo $randompassword; ?>.

<?php __('Click here to login'); ?>:
<?php echo Configure::read('App.hostUrl'); echo Configure::read('App.serverUrl'); ?>/users/login/
                           
<?php __('Yours, Clemens'); ?>

<?php echo $this->element('email/newsletter_text_footer'); ?>

