<!DOCTYPE html>
<html lang="<?php if ( $locale == 'ger' ) echo 'de'; else echo 'en'; ?>">
<head>
    <title>TriCoreTraining.com <?php echo $title_for_layout; ?></title>
<?php
$url = Configure::read('App.serverUrl');
echo $html->charset();
?>
    <?php 
    /**
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <link rel="shortcut icon" href="/favicon.ico" />
    */
    ?>
    <?php echo $html->meta('icon'); ?>

    <?php echo $this->element('metanavigation'); ?>

    <link rel="alternate" type="application/rss+xml" title="TriCoreTraining.com RSS" href="#" />

    <link rel="stylesheet" type="text/css" href="<?php echo $url; ?>/css/reset.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo $url; ?>/css/text.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo $url; ?>/css/960.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo $url; ?>/css/styles.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo $url; ?>/css/facebox.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo $url; ?>/css/theme/jquery-ui-1.8.5.custom.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo $url; ?>/css/trainingplans.css" />

    <!--<script type="text/javascript" src="<?php echo Configure::read('App.serverUrl'); ?>/js/jquery-1.3.2.min.js"></script>-->
    <script type="text/javascript" src="<?php echo $url; ?>/js/jquery-1.4.2.js"></script>
    <!--<script type="text/javascript" src="<?php echo Configure::read('App.serverUrl'); ?>/js/jquery-ui.js"></script>-->
    <script type="text/javascript" src="<?php echo $url; ?>/js/jquery-ui-1.8.5.custom.min.js"></script>
    <!--script type="text/javascript" src="<?php echo $url; ?>/js/timeparser.js"></script-->
    <!--script type="text/javascript" src="<?php echo $url; ?>/js/trainingplanner.js"></script-->
    <script type="text/javascript" src="<?php echo $url; ?>/js/jquery-fluid16.js"></script>
    <script type="text/javascript" src="<?php echo $url; ?>/js/facebox.js"></script>

<?php echo $scripts_for_layout; ?>

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

?>
<script type="text/javascript">
// image fader
$(document).ready(function() {
	var $teasers = $(".teaserimages").children("img");
	var tcount = $teasers.length;
	var last = tcount - 1;
	
	setInterval(function() {
		$($teasers[last]).fadeOut();
		var r = Math.floor(Math.random() * tcount);

		if (r == last && r < (tcount - 1)) {
			r++;
		} else if (r == last && r == (tcount - 1)) {
			r = 0;
		}
		$($teasers[r]).fadeIn();
		last = r;
	}, 6000);
});
</script>

</head>
<body>
	<!-- Header -->
	<div class="container_12 header">
		<div class="grid_12 branding">
			<a href="<?php echo Configure::read('App.serverUrl'); ?>">
				<img src="<?php echo Configure::read('App.serverUrl'); ?>/img/logo_tricoretraining_233.png" alt="TriCoreTraining.com" title="TriCoreTraining.com" />
			</a>
      <?php echo $this->element('topprofile'); ?>
		</div>
		<div class="grid_12 navigation">
			<?php echo $this->element('topnavigation_public'); ?>
		</div>
	</div>
	<!-- /Header -->
	<!-- Main -->
	<div class="container_12 main">
		<!-- Center column -->
  		<div class="grid_12 center">
			<!-- Content -->
			<div class="box content" style="padding-bottom: 18px; height: 285px;">
				<div id="signup">
					<p></p>
					<p>
					<em><?php __('Gain speed, loose weight'); ?></em>
					</p>
					<!--button onclick="$('#signup').fadeOut(); $('.teaserimages').fadeOut();"-->
					<button onClick="javascript:top.location.href='<?php echo Configure::read('App.serverUrl'); ?>/users/register/';"><img src="/trainer/img/signup.png" alt="<?php __('Register FREE!'); ?>"/></button>
					
					<p>
					<iframe src="http://www.facebook.com/plugins/like.php?href=<?php echo urlencode('http://www.facebook.com/pages/TriCoreTraining/150997251602079'); ?>&amp;layout=standard&amp;show_faces=false&amp;width=280&amp;action=like&amp;font=arial&amp;colorscheme=light&amp;height=20" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:280px; height:20px;" allowTransparency="true"></iframe>
					</p>    

				</div>
				<div class="teaserimages">
					<img src="/trainer/img/start/start-1.jpg" alt="" />
					<img src="/trainer/img/start/start-2.jpg" alt="" />
					<img src="/trainer/img/start/start-3.jpg" alt="" />
					<img src="/trainer/img/start/start-4.jpg" alt="" />
				</div>
				<div class="clear"></div>
			</div>
			<!-- /Content -->
		</div>
		
		<div class="grid_4">
			<div class="box last">
				<h1><?php __('Easier.'); ?></h1>
				<ul>
					<li><?php __('Simple, solid training plans which are easy to understand'); ?></li>
					<li><?php __('Straightforward training log'); ?></li>
					<li><?php __('Fits your daily training needs'); ?></li>
					<li><?php __('No fluff - just plain, simple plans'); ?></li>
				</ul>
			</div>
		</div>

		<div class="grid_4">
			<div class="box last">
				<h1><?php __('Faster.'); ?></h1>
				<ul>
					<li><?php __('Train smart instead of hammering endless miles'); ?></li>
					<li><?php __('Even out your weaknesses'); ?></li>
					<li><?php __('Focus on your strengths'); ?></li>
					<li><?php __('On-the-fly training plans based on your fitness level and race goals'); ?></li>
				</ul>
			</div>
		</div>

		<div class="grid_4">
			<div class="box last">
				<h1><?php __('Better.'); ?></h1>
				<ul>
					<li><?php __('Take your time to decide: free basic account'); ?></li>
					<li><?php __('Quality-proven periodic training plans'); ?></li>
					<li><?php __('Easy to understand, simple to execute'); ?></li>
					<li><?php __('Crush the competition'); ?></li>
				</ul>
			</div>
		</div>

		<!-- /Center column -->
	<div class="clear"></div>
	<!-- /Main -->
	
	<div class="container_12">
	<?php echo $cakeDebug; ?>
  </div>
	
  <!-- Footer -->
  <?php echo $this->element('footer'); ?>
  <!-- /Footer -->
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

</body>
</html>