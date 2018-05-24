
<?php echo $this->element('email/newsletter_header'); ?>

 <p><?php __('Hi'); ?> Admin,</p>

 <p><i><?php __('some notifications arrived.'); ?></i></p>
 <p>
<font color="red"><?php

echo $error;

?>
</font>
</p>
<p>
<i>
<?php

foreach ( $user['User'] as $key => $value )
{
	echo $key . " = " . $value . "<br />\n\n";
}

?>
</p>
<p>
<?php

foreach ( $array as $key => $value )
{
	echo $key . " = " . $value . "<br />\n\n";
}

?>
</i>
 </p>
 

<?php echo $this->element('email/newsletter_footer'); ?>
