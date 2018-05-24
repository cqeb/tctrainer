
<?php echo $this->element('email/newsletter_header'); ?>

 <p><?php __('Hi'); ?> <?php echo $user['User']['firstname']; ?>,</p>

 <p><i><?php __('you want to reset your password on TriCoreTraining.'); ?></i></p>
 <p class="more"><?php __('Please'); ?> 
 <a href="<?php echo Configure::read('App.hostUrl'); echo Configure::read('App.serverUrl'); ?>/users/password_reset/transaction_id:<?php echo $transaction_id?>">
 <?php __('click to reset your password.'); ?></a></p>

<?php echo $this->element('email/newsletter_footer'); ?>
