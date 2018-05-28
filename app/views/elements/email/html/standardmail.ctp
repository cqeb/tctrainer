
<?php echo $this->element('email/newsletter_header'); ?>

<p><?php __('Hi'); ?> <?php echo $to_name; ?>,</p>

<p><?php echo $mcontent; ?></p>

<br />
<?php if ( $show_notification_link == 'ok' ) { ?>
<p class="more"><i>
<a href="<?php echo Configure::read('App.hostUrl'); echo Configure::read('App.serverUrl'); ?>/users/stop_notification/<?php if ( isset( $ath_id_key ) ) echo "athlete_id:" . $athlete_id . "/key:" . $ath_id_key; ?>">
<?php __('Stop sending me weekly training plans!'); ?>
</a></i></p>
<?php } ?>
  
<?php echo $this->element('email/newsletter_footer'); ?>
