<?php __('Welcome'); ?> <?php echo $user['firstname']; ?>,

<?php echo strip_tags( $mcontent ); ?>
                           
<?php echo $this->element('email/newsletter_text_footer'); ?>
