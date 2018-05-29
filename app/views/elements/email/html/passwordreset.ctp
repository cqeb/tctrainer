
<?php echo $this->element('email/newsletter_header'); ?>

 <p><?php __('Hi'); ?> <?php echo $user['User']['firstname']; ?>,</p>

 <p><i><?php __('your password is reset.'); ?></i></p>
 <p><?php __('Your new password on TriCoreTraining:'); ?> <?php echo $randompassword; ?></p>
 <p class="more"><a href="<?php echo Configure::read('App.hostUrl'); echo Configure::read('App.serverUrl'); ?>/users/login/?utm_source=tricoretrainingsystem&utm_medium=email&utm_campaign=login_after_reset">
 <?php __('Click here to login'); ?>.</a></p>

 <img src="http://www.google-analytics.com/collect?v=1&tid=UA-116688964-1&cid=tct-2351&t=event&ec=email&ea=open&el=passwordreset&cs=tricoretrainingsystem&cm=email&cn=mailopens&cm1=1" />

<?php echo $this->element('email/newsletter_footer'); ?>
