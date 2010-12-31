
<?php __('Aloha'); ?> <?php if ( isset( $to_name ) ) echo $to_name; else echo $user['User']['firstname']; ?>,

<?php __('don\'t be lazy. Train and track your trainings!'); ?>

<?php __('Go to'); ?> TriCoreTraining.com (http://www.tricoretraining.com) <?php __('and track your workouts - NOW!'); ?>

<?php __('Yes, I\'ll do!'); ?>

<?php echo Configure::read('App.hostUrl'); echo Configure::read('App.serverUrl'); ?>/trainingstatistics/list_trainings/
 
<?php __('Yours, Clemens'); ?>

<?php __('Stop sending me notifications!'); ?>
<?php echo Configure::read('App.hostUrl'); echo Configure::read('App.serverUrl'); ?>/users/edit_userinfo/
 
<?php echo $this->element('email/newsletter_text_footer'); ?>

