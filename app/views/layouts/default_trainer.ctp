<!DOCTYPE html>
<html lang="<?php if ( $locale == 'ger' ) echo 'de'; else echo 'en'; ?>">
<head>
<title>TriCoreTraining.com <?php echo $title_for_layout; ?></title>
<?php
$url = Configure::read('App.serverUrl');
    echo $html->charset();
    ?>
<?php echo $html->meta('icon'); ?>

<?php echo $this->element('metanavigation'); ?>

<link rel="alternate" type="application/rss+xml" title="TriCoreTraining.com RSS" href="http://feeds.feedburner.com/tricoretraining/<?php if ( $locale == 'eng' || $locale == '' ) { ?>EN<?php } else { ?>DE<?php } ?>" />

<link rel="stylesheet" type="text/css" href="<?php echo $url; ?>/css/tipTip.css" />
<link rel="stylesheet" type="text/css" href="<?php echo $url; ?>/css/reset.css" />
<link rel="stylesheet" type="text/css" href="<?php echo $url; ?>/css/text.css" />
<link rel="stylesheet" type="text/css" href="<?php echo $url; ?>/css/960.css" />
<link rel="stylesheet" type="text/css" href="<?php echo $url; ?>/css/styles.css" />
<link rel="stylesheet" type="text/css" href="<?php echo $url; ?>/css/facebox.css" />
<link rel="stylesheet" type="text/css" href="<?php echo $url; ?>/css/theme/jquery-ui-1.8.5.custom.css" />
<link rel="stylesheet" type="text/css" href="<?php echo $url; ?>/css/trainingplans.css" />

<script type="text/javascript" src="<?php echo $url; ?>/js/jquery-1.4.2.js"></script>
<script type="text/javascript" src="<?php echo $url; ?>/js/jquery-ui-1.8.5.custom.min.js"></script>
<script type="text/javascript" src="<?php echo $url; ?>/js/jquery-fluid16.js"></script>
<script type="text/javascript" src="<?php echo $url; ?>/js/facebox.js"></script>
<script type="text/javascript" src="<?php echo $url; ?>/js/jquery.tipTip.minified.js"></script>

<?php echo $scripts_for_layout; ?>

</head>
<body>
	<!-- Header -->
	<div class="container_12 header">
		<div class="grid_12 branding">
		  <a href="<?php echo Configure::read('App.serverUrl'); ?>">
			<img src="<?php echo Configure::read('App.serverUrl'); ?>/img/logo_tricoretraining_233.png" alt="TriCoreTraining" title="TriCoreTraining" />
		  </a>
		  <?php echo $this->element('topprofile'); ?>
		</div>
		<div class="grid_12 navigation">
                <?php if ( isset( $userobject ) ) echo $this->element('topnavigation_private'); else echo $this->element('topnavigation_public'); ?>
		</div>
	</div>
	<!-- /Header -->
	<!-- Main -->
	<div class="container_12 main">
		<!-- Left column -->
		<div class="grid_3 left">
			<div class="box navigation last">
			<?php //__('Navigation');?>
               <?php echo $this->element('subnavigation_all'); ?>
			</div>
		</div>
		<!-- /Left column -->
		
		<!-- Center column -->
  		<div class="grid_6 center">
			<!-- Content -->
			<div class="box content last">
				<?php echo $content_for_layout; ?>
				<div class="clear"></div>
			</div>
			<!-- /Content -->
		</div>
		<!-- /Center column -->
		
		<!-- Right column -->
		<div class="grid_3 right">

<!--
<?php if ( isset($userobject) ) { ?>
			<div class="box userinfo">
				<h1><?php __('Aloha'); ?>, <?php echo $userobject['firstname']; ?>!</h1>
				<img width="80" src="<?php if ( $userobject['myimage'] ) { /** echo resize( $userobject['myimage'], array("w"=>80,"h"=>80)); **/ echo $userobject['myimage']; } else { ?>http://www.gravatar.com/avatar/<?php echo md5( strtolower( trim( $userobject['email'] ) ) ); } ?>" />
				<b><?php echo $userobject['firstname'] . ' ' . $userobject['lastname']; ?></b>
        <br /><br />
        <br /><br />
			</div>
<?php } ?>
-->
			
			<?php echo $this->element('rightbar'); ?>

		</div>
		<!-- /Right column -->
	</div>
	<div class="clear"></div>
	<!-- /Main -->
	
	<div class="container_12">
	<?php echo $cakeDebug; ?>
        </div>

	<!-- Footer -->
        <?php echo $this->element('footer'); ?>
	<!-- /Footer -->

	<?php if ( isset( $this->js_addon ) ) echo $this->js_addon; ?>

	<script type="text/javascript">
	var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
	document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
	</script>
	
	<script type="text/javascript">
	try {
	var pageTracker = _gat._getTracker("UA-15268905-1");
	pageTracker._trackPageview();
	} catch(err) {}
	</script>

<script type="text/javascript" charset="utf-8">
  var is_ssl = ("https:" == document.location.protocol);
  var asset_host = is_ssl ? "https://s3.amazonaws.com/getsatisfaction.com/" : "http://s3.amazonaws.com/getsatisfaction.com/";
  document.write(unescape("%3Cscript src='" + asset_host + "javascripts/feedback-v2.js' type='text/javascript'%3E%3C/script%3E"));
</script>

<script type="text/javascript" charset="utf-8">
  var feedback_widget_options = {};

  feedback_widget_options.display = "overlay";
  feedback_widget_options.company = "tricoretraining";
  feedback_widget_options.placement = "left";
  feedback_widget_options.color = "#222";
  feedback_widget_options.style = "idea";
  var feedback_widget = new GSFN.feedback_widget(feedback_widget_options);
</script>

</body>
</html>