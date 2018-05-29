
<?php echo $this->element('email/newsletter_header'); ?>

 <p><?php __('Hi'); ?> <?php echo $user['User']['firstname']; ?>,</p>

 <p><i><?php __('you want to reset your password on TriCoreTraining.'); ?></i></p>
 <p class="more"><?php __('Please'); ?> 
 <a href="<?php echo Configure::read('App.hostUrl'); echo Configure::read('App.serverUrl'); ?>/users/password_reset/transaction_id:<?php echo $transaction_id?>?utm_source=tricoretrainingsystem&utm_medium=email&utm_campaign=password_reset">
 <?php __('click to reset your password.'); ?></a></p>

<img src="http://www.google-analytics.com/collect?v=1&tid=UA-116688964-1&cid=tct-2351&t=event&ec=email&ea=open&el=passwordforgotten&cs=tricoretrainingsystem&cm=email&cn=mailopens&cm1=1" />

<?php echo $this->element('email/newsletter_footer'); ?>
