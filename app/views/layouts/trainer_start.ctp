<!DOCTYPE html>
<html lang="<?php if ( $locale == 'ger' ) echo 'de'; else echo 'en'; ?>">
<head>
    <title><?php

if ( isset( $title ) ) 
	echo $title;
else	
	echo 'TriCoreTraining.com' . ' ' . $title_for_layout;
	
if ( isset( $userinfo ) ) 
{
		$facebox_content = '';
			
		// create text for facebox with workout
		if ( $distance ) 
		{
			
			$facebox_content = '<br /><h1>' . __('My TriCoreTraining.com workout!', true) . '</h1><p>' . 
			__('I did a', true) . ' ' . $distance . ' ' . $distance_unit . ' ' . 
			__($sport . ' workout', true) . ' ' . __('in',true) . ' ' . $duration . ' ' . 
			__('hour(s)',true) . ' ' . __('with', true) . ' ' .	'TriCoreTraining.com' .	
			'<br /><br />' . __('Yours', true) . ', ' . $userinfo['firstname'] . '<br /><br />' . 
			'<a href=\'/trainer/users/register\'>&raquo; ' . __('If you want to improve your athletic skills or loose weight, why not register?', true) . '</a></p>' . 
			'<img alt=\'' . $userinfo['firstname'] . '\' src=\'http://0.gravatar.com/avatar/' . md5( $userinfo['email'] ) . '?s=69&d=identicon\' />';

        	$facebox_content = 'jQuery.facebox("' . $facebox_content . '");';

		// user recommended our service
		} else
		{
			$facebox_content = '<br /><h1>' . __('I LIKE TriCoreTraining.com!', true) . '</h1><p>' . 
			__("Why don't YOU become a triathlon athlete too? Why not a marathon runner? I already did it! With TriCoreTraining.com.", true) .
			'<br /><br />' . __('Yours', true) . ', ' . $userinfo['firstname'] . '<br /><br />' . 
			'<a href=\'/trainer/users/register\'>&raquo; ' . __('If you want to improve your athletic skills or loose weight, why not register?', true) . '</a></p>' . 
			'<img alt=\'' . $userinfo['firstname'] . '\' src=\'http://0.gravatar.com/avatar/' . md5( $userinfo['email'] ) . '?s=69&d=identicon\' />';

        	$facebox_content = 'jQuery.facebox("' . $facebox_content . '");';		
		}
		
}

if ( isset( $companyinfo ) ) 
{
			$facebox_content = '<br /><h1>' . __('Your company helps you to save 30% of membership costs!', true) . '</h1><p>' . 
			__("Register initially with your company email, try TriCoreTraining one month for free and then you will get a reduced PREMIUM membership which costs not more than 3 coffees a month.", true) . 
			'<br /><br />' . __('Yours', true) . ', Klaus-M. (' . __('founder of', true) . ') ' . __('TriCoreTraining', true) . '<br /><br />' . 
			'<a href=\'/trainer/users/register\'>&raquo; ' . __('If you want to improve your athletic skills or loose weight, why not register?', true) . '</a></p>';

        	$facebox_content = 'jQuery.facebox("' . $facebox_content . '");';		
}

?></title>
    <?php $url = Configure::read('App.serverUrl'); echo $html->charset(); ?>
    <?php echo $html->meta('icon'); ?>

    <?php echo $this->element('metanavigation'); ?>

    <link rel="alternate" type="application/rss+xml" title="TriCoreTraining.com RSS" href="http://feeds.feedburner.com/tricoretraining/<?php if ( $locale == 'eng' || $locale == '' ) { ?>EN<?php } else { ?>DE<?php } ?>" />

    <link rel="stylesheet" type="text/css" href="<?php echo $url; ?>/css/reset.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo $url; ?>/css/text.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo $url; ?>/css/960.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo $url; ?>/css/styles.css?v=<?php echo VERSION; ?>" />
    <link rel="stylesheet" type="text/css" href="<?php echo $url; ?>/css/facebox.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo $url; ?>/css/theme/jquery-ui-1.8.5.custom.css" />

    <link rel="stylesheet" type="text/css" href="<?php echo $url; ?>/css/start.css?v=<?php echo VERSION; ?>" />
    <link rel="stylesheet" type="text/css" href="<?php echo $url; ?>/fancybox/jquery.fancybox-1.3.4.css" />

    <script type="text/javascript" src="<?php echo $url; ?>/js/jquery-1.4.2.js"></script>
    <script type="text/javascript" src="<?php echo $url; ?>/js/jquery-ui-1.8.5.custom.min.js"></script>
    <script type="text/javascript" src="<?php echo $url; ?>/js/jquery-fluid16.js"></script>
    <script type="text/javascript" src="<?php echo $url; ?>/js/facebox.js"></script>

    <script type="text/javascript" src="<?php echo $url; ?>/fancybox/jquery.fancybox-1.3.4.pack.js"></script>

<?php echo $scripts_for_layout; ?>

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
	
   $('.box.last.features a').fancybox();
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
				<h1><?php __('Gain speed, loose weight!'); ?></h1>
				<p><?php __('TriCoreTraining provides you with <b>professional</b>, yet <b>easy and fun</b> training plans to <b>improve</b> your <b>running</b>, <b>biking</b> or <b>triathlon skills</b>!');?></p>
				<a href="<?php echo Configure::read('App.serverUrl'); ?>/users/register/"><?php __('Sign up now');?><br /><em><?php __('it´s free!');?></em></a>
			</div>
			<iframe id="facebook" src="http://www.facebook.com/plugins/like.php?href=<?php echo urlencode('http://www.facebook.com/pages/TriCoreTraining/150997251602079'); ?>&amp;layout=standard&amp;show_faces=false&amp;width=280&amp;action=like&amp;font=arial&amp;colorscheme=light&amp;height=40" scrolling="no" frameborder="0" allowTransparency="true"></iframe>

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

    
    <div class="grid_3">
    	<div class="box">
	        <?php __("You are an ambitious athlete who wants to get the most out of training, whilst juggling a full time job alongside keeping your family happy? <b>Then you've come to the right place.</b>"); ?>
        </div>
    	<div class="box last">
	        <?php __("You want to finish your first Marathon, improve your personal best at Half Ironman distance, or just enjoy your morning run? <b>We help you to get even more out of your training!</b>"); ?>
        </div>
    </div>
    
    <div class="grid_9">
    	<div class="box last features">
    		<div>
    			<a href="/trainer/img/startpage-feature-track-big.jpg"><img src="/trainer/img/startpage-feature-track.jpg" alt="<?php __('Track your trainings');?>" title="<?php __('Track your trainings');?>"/></a>
    			<p><?php __('Log your trainings, manage your competitions, and also keep track of your weight.');?></p>
    		</div>
    		<div>
    			<a href="/trainer/img/startpage-feature-stats-big.jpg"><img src="/trainer/img/startpage-feature-stats.jpg" alt="<?php __('Analyze your workouts');?>" title="<?php __('Analyze your workouts');?>"/></a>
    			<p><?php __('Use detailed statistics to assess yor fitness and gain even more from your workouts.');?></p>
    		</div>
    		<div style="padding-right: 0px;">
    			<a href="/trainer/img/startpage-feature-plans-big.jpg"><img src="/trainer/img/startpage-feature-plans.jpg" alt="<?php __('Get individual training plans');?>" title="<?php __('Get individual training plans');?>"/></a>
    			<p><?php __('Receive individual training plans based on your workouts and upcoming competitions.');?></p>
    		</div>
    	</div>
    </div>

  <!-- /Center column -->
  <div class="clear"></div>
  <!-- /Main -->

<!-- Footer -->
<?php echo $this->element('footer'); ?>
<!-- /Footer -->

<div class="container_12">
<?php echo $cakeDebug; ?>
</div>

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

<?php
/*
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
*/
?>
<script type="text/javascript">

/** initiate JQuery **/

$(document).ready(function() {

        // facebox box
        //$('a[rel*=facebox]').facebox();
		<?php if ( isset( $facebox_content ) ) echo $facebox_content; ?>
});

</script>

</body>
</html>