
<?php echo $this->element('email/newsletter_header'); ?>

 <p><?php __('Welcome'); ?> <?php echo $user['User']['firstname']; ?>,</p>

 <p><i><?php __('you completed the first step for gaining speed in your sport and probably loosing weight.'); ?></i></p>
 
 <p><?php __('Your trial period is FREE and ends automatically if you do not subscribe to a membership.'); ?></p>
 <p><?php __('You can test TriCoreTraining for 15 days.'); ?></p>

 <p><a class="button" href="<?php echo Configure::read('App.hostUrl'); echo Configure::read('App.serverUrl'); ?>/users/activate/transaction_id:<?php echo $transaction_id?>?utm_source=tricoretrainingsystem&utm_medium=email&utm_campaign=singup_activation">
 <?php __('Click to activate your account'); ?>
 </a></p>

 <p>
 <?php __('With your subscription you agree that we are allowed to send you newsletters and mailings on a regular base. Thanks a lot!'); ?>
 </p>
 
 <img src="http://www.google-analytics.com/collect?v=1&tid=UA-116688964-1&cid=tct-2351&t=event&ec=email&ea=open&el=welcomeemail&cs=tricoretrainingsystem&cm=email&cn=mailopens&cm1=1" />

<?php echo $this->element('email/newsletter_footer'); ?>
