
<?php __('Hello'); ?> Admin,

<?php __('some notification arrived.'); ?>

<?php

echo $error;
echo '---------------------------------------------\n';
print_r( $user );
echo '---------------------------------------------\n';
print_r( $array );

?>

<?php __('Yours, Clemens'); ?>

<?php echo $this->element('email/newsletter_text_footer'); ?>

