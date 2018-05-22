
<?php echo $this->element('email/newsletter_header'); ?>

<?php __('Hi'); ?> <?php echo $to_name; ?>,

<?php echo strip_tags( $mcontent ); ?>
                           
<?php __('Stop sending me notifications!'); ?>
<?php echo Configure::read('App.hostUrl'); echo Configure::read('App.serverUrl'); ?>/users/edit_userinfo/?utm_source=tricoretraining.com&utm_medium=newsletter

<?php echo $this->element('email/newsletter_footer'); ?>
