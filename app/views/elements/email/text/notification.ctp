
<?php __('Aloha'); ?> Admin,

<?php __('some notification arrived.'); ?>

<?php

echo $error;

foreach ( $user['User'] as $key => $value )
{
	echo $key . " = " . $value . "\n\n";
}

echo '---------------------------------------------\n';

foreach ( $array as $key => $value )
{
	echo $key . " = " . $value . "\n\n";
}

echo '---------------------------------------------\n';

?>

<?php __('Yours, Clemens'); ?>

<?php echo $this->element('email/newsletter_text_footer'); ?>

