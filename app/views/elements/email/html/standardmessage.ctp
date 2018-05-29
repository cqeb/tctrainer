
<?php echo $this->element('email/newsletter_header'); ?>

 <p><b><?php echo $subject; ?></b></p>
 
 <p><?php echo $mcontent; ?></p>

<img src="http://www.google-analytics.com/collect?v=1&tid=UA-116688964-1&cid=tct-2351&t=event&ec=email&ea=open&el=standardmessage&cs=tricoretrainingsystem&cm=email&cn=mailopens&cm1=1" />

<?php echo $this->element('email/newsletter_footer'); ?>
