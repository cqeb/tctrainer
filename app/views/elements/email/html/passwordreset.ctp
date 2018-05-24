
<?php echo $this->element('email/newsletter_header'); ?>

 <p><?php __('Hi'); ?> <?php echo $user['User']['firstname']; ?>,</p>

 <p><i><?php __('your password is reset.'); ?></i></p>
 <p><?php __('Your new password on TriCoreTraining:'); ?> <?php echo $randompassword; ?></p>
 <p class="more"><a href="<?php echo Configure::read('App.hostUrl'); echo Configure::read('App.serverUrl'); ?>/users/login/">
 <?php __('Click here to login'); ?>.</a></p>
                           
<?php echo $this->element('email/newsletter_footer'); ?>
