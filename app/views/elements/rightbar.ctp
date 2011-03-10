<div class="box">
<b><?php __('Hot News'); ?></b>
<br /><br />
<?php if ( isset( $session_userid ) ) { ?>
<a href="/trainer/payments/subscribe_triplans"><b>&raquo; <?php __('PREMIUM Upgrade'); ?></b></a>
<br /><br />
<?php } ?>
<a href="/blog/<?php if ( $locale != 'eng' || $locale == '' ) { ?>de/<?php } else { ?>en/<?php } ?>">&raquo; <?php __('TriCoreTraining Blog'); ?></a>
<br /><br />

<a href="/blog/<?php if ( $locale != 'eng' || $locale == '' ) { ?>de/<?php } else { ?>en/<?php } ?>category/faq/">&raquo; <?php __('FAQs'); ?></a>

<?php if ( isset( $session_userid ) ) { ?>
<br /><br />
<a href="/trainer/starts/index/<?php if ( $locale != 'eng' || $locale == '' ) { ?>de/<?php } else { ?>en/<?php } ?>ur:<?php echo base64_encode($userobject['id']); ?>/">&raquo; <?php __('Invite your friends'); ?></a>
<?php } ?>

<?php if ( !isset( $session_userid ) ) { ?>
<br /><br /><br />
<a href="/trainer/users/login_facebook/"><img alt="<?php __('Login with your Facebook account!'); ?>" src="/trainer/img/loginfb.png"></a>
<?php } ?>
</div>

<div class="box">
<b><?php __('Recommendation'); ?></b>
<br /><br />
<?php echo $this->element('referral'); ?>
</div>

<div class="box<?php if ( $_SERVER['HTTP_HOST'] != 'localhost') { ?> last<?php } ?>">
<script type="text/javascript"><!--
google_ad_client = "ca-pub-1221279145141294";
/* Content right 2 */
google_ad_slot = "7321319812";
google_ad_width = 200;
google_ad_height = 200;
//-->
</script>
<script type="text/javascript"
src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
</script>

<?php if ( isset( $userobject ) && $userobject['admin'] == '1' ) { ?>
<br /><br />
<ul>
        <li><a href="/trainer/users/list_users"><?php __('Administrate users'); ?></a></li>
</ul>
<?php } ?>
  
<?php if ( $_SERVER['HTTP_HOST'] == 'localhost' ) { ?>
</div>
<div class="box last">
<b>Debugging (only localhost)</b>
<br /><br />
<ul>
        <li><a target="_blank" href="<?php echo Configure::read('App.serverUrl'); ?>/app/webroot/flash.php"><?php __('Graphs'); ?></a></li>
        <li><a target="_blank" href="/phpmyadmin/"><?php __('PHPMyAdmin'); ?></a></li>
        <li><a target="_blank" href="/trainer/starts/fill_my_database"><?php __('Fill my database'); ?></a></li>
        <li><a target="_blank" href="/trainer/trainingplans/get?debug=1">DEBUG Trainingplan</a></li>
</ul>
<?php } ?>

</div>