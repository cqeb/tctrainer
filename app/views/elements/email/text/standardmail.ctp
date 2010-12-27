
<?php echo $this->element('email/newsletter_header'); ?>

<?php __('Aloha'); ?> <?php echo $to_name; ?>,

<?php echo strip_tags( $mcontent ); ?>

<?php __('Go to TriCoreTraining.com!'); ?>
<a href="<?php echo Configure::read('App.hostUrl'); ?>">
                           
<?php __('Yours, Clemens'); ?>

<?php echo $this->element('email/newsletter_footer'); ?>
