
<?php echo $this->element('email/newsletter_header'); ?>

<p><?php __('Hi'); ?> <?php echo $to_name; ?>,</p>

<p><?php echo $mcontent; ?></p>

<br />
<?php if ( $show_notification_link == 'ok' ) { ?>
<p class="more"><i>
<a href="<?php echo Configure::read('App.hostUrl'); echo Configure::read('App.serverUrl'); ?>/users/stop_notification/<?php if ( isset( $ath_id_key ) ) echo "athlete_id:" . $athlete_id . "/key:" . $ath_id_key; ?>?utm_source=tricoretrainingsystem&utm_medium=email&utm_campaign=stop_weekly_plan">
<?php __('Stop sending me weekly training plans!'); ?>
</a></i></p>
<?php } ?>

<?php 
$campaign_level = 'standardmail';
if ( $show_notification_link == 'ok' ) { 
    $campaign_level = 'weekly_plans';
}
?>

<img src="http://www.google-analytics.com/collect?v=1&tid=UA-116688964-1&cid=tct-2351&t=event&ec=email&ea=open&el=<?php echo $campaign_label; ?>&cs=tricoretrainingsystem&cm=email&cn=mailopens&cm1=1" />


<?php echo $this->element('email/newsletter_footer'); ?>
