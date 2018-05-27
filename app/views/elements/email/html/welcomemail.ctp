
<?php echo $this->element('email/newsletter_header'); ?>

 <p><?php __('Welcome'); ?> <?php echo $user['User']['firstname']; ?>,</p>

 <p><i><?php __('you completed the first step for gaining speed in your sport and probably loosing weight.'); ?></i></p>
 
 <p><?php __('Your trial period is FREE and ends automatically if you do not subscribe to a membership.'); ?></p>
 <p><?php __('You can test TriCoreTraining for 15 days.'); ?></p>

 <p><a class="button" href="<?php echo Configure::read('App.hostUrl'); echo Configure::read('App.serverUrl'); ?>/users/activate/transaction_id:<?php echo $transaction_id?>">
 <?php __('Click to activate your account'); ?>
</a></p>

<?php echo $this->element('email/newsletter_footer'); ?>
