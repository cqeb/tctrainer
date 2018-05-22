<aside>
<div class="panel">
	<div class="panel-body">

<?php if ( isset( $session_userid ) ) { ?>
<a class="btn btn-primary" href="/trainer/payments/subscribe_triplans"><b>&raquo; <?php __('Go PREMIUM'); ?></b></a>
<br /><br />
<?php } ?>

<?php /*
<script type="text/javascript"><!--
google_ad_client = "ca-pub-1221279145141294";
google_ad_slot = "8838845432";
google_ad_width = 200;
google_ad_height = 200;
//-->
</script>
<script type="text/javascript"
src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
</script>
<?php */ ?>

<p>
<b><?php __('Recommendation'); ?></b>
<br />
<?php echo $this->element('referral'); ?>
</p>

<br /><br />

<?php /* ?>
<iframe src="http://www.facebook.com/plugins/likebox.php?href=http%3A%2F%2Fwww.facebook.com%2Fpages%2FTriCoreTraining%2F150997251602079&amp;width=200&amp;colorscheme=light&amp;show_faces=true&amp;stream=false&amp;header=false&amp;height=250" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:250px; height:250px;" allowTransparency="true"></iframe>
<?php */ ?>

<?php if ( isset( $session_userid ) && isset( $userobject['id'] ) ) { ?>
<br /><br />
<?php __('Send this link to your friends'); ?>:<br />
<a href="/trainer/starts/index/<?php if ( $locale == 'deu' ) { ?>de/<?php } else { ?>en/<?php } ?>ur:<?php echo base64_encode($userobject['id']); ?>/">&raquo; <?php __('Invite your friends'); ?></a>
<?php } ?>

	</div>
</div>
</aside>
