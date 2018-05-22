
<?php __('Hi'); ?> Admin,

<?php __('some notifications arrived.'); ?>

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

<?php echo $this->element('email/newsletter_text_footer'); ?>

