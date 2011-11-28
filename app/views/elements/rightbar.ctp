<div class="box">
<b><?php __('Hot News'); ?></b>
<br /><br />
<!--
<?php if ( isset( $session_userid ) ) { ?>
<a href="/trainer/payments/subscribe_triplans"><b>&raquo; <?php __('PREMIUM Upgrade'); ?></b></a>
<br /><br />
<?php } ?>
-->
<a href="/blog/<?php if ( $locale != 'eng' || $locale == '' ) { ?>de/<?php } else { ?>en/<?php } ?>">&raquo; <?php __('TriCoreTraining Blog'); ?></a>
<br /><br />
<a href="/blog/<?php if ( $locale != 'eng' || $locale == '' ) { ?>de/<?php } else { ?>en/<?php } ?>category/faq/">&raquo; <?php __('FAQs'); ?></a>

<?php if ( isset( $session_userid ) ) { ?>
<br /><br />
<?php __('Send this link to your friends'); ?>:<br />
<a href="/trainer/starts/index/<?php if ( $locale != 'eng' || $locale == '' ) { ?>de/<?php } else { ?>en/<?php } ?>ur:<?php echo base64_encode($userobject['id']); ?>/">&raquo; <?php __('Invite your friends'); ?></a>
<?php } ?>

<br /><br />

<?php
/**

<script type="text/javascript"><!--
google_ad_client = "ca-pub-1221279145141294";
google_ad_slot = "8666894126";
google_ad_width = 200;
google_ad_height = 90;
//-->
</script>
<script type="text/javascript" src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
</script>
**/
?>

</div>

<div class="box<?php if ( $_SERVER['HTTP_HOST'] != 'localhost') { ?> last<?php } ?>">
<?php
/**
<b><?php __('Recommendation'); ?></b>
<br /><br />
<?php echo $this->element('referral'); ?>
**/
?>

<iframe src="http://www.facebook.com/plugins/likebox.php?href=http%3A%2F%2Fwww.facebook.com%2Fpages%2FTriCoreTraining%2F150997251602079&amp;width=200&amp;colorscheme=light&amp;show_faces=true&amp;stream=false&amp;header=false&amp;height=250" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:200px; height:250px;" allowTransparency="true"></iframe>

</div>

<div class="box">

<?php if ( isset( $userobject ) && $userobject['admin'] == '1' ) { ?>
<b>Admin (only for admin)</b>
<br /><br />
<ul>
	<li><a href="/trainer/users/list_users"><?php __('Administrate users'); ?></a></li>      
</ul>
<?php } ?>
  
<?php if ( $_SERVER['HTTP_HOST'] == 'localhost' ) { ?>

<b>Debugging (only localhost)</b>
<br /><br />
<ul>
        <li><a target="_blank" href="<?php echo Configure::read('App.serverUrl'); ?>/app/webroot/flash.php"><?php __('Graphs'); ?></a></li>
        <li><a target="_blank" href="/phpmyadmin/"><?php __('PHPMyAdmin'); ?></a></li>
        <li><a target="_blank" href="/trainer/starts/fill_my_database"><?php __('Fill my database'); ?></a></li>
        <li><a target="_blank" href="/trainer/trainingplans/get?debug=1">DEBUG Trainingplan</a></li>
		<li><a href="#/trainer/starts/index/en/u:TRANSACTIONID">Redirect workout (u)</a></li> 
		<li><a href="/trainer/starts/index/en/ur:<?php echo base64_encode("1"); ?>">Redirect no Money (ur):1</a></li> 
		<li><a href="/trainer/starts/index/en/urm:<?php echo base64_encode("1"); ?>">Redirect Money (urm):1</a></li>
		<li><a href="/trainer/starts/index/en/c:<?php echo base64_encode("@gentics.com"); ?>">Company:@gentics.com</a></li>
        
</ul>
<?php } ?>

</div>