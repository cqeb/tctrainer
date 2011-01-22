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
    <script type="text/javascript" src="<?php echo $url; ?>/js/timeparser.js"></script>
    <script type="text/javascript" src="<?php echo $url; ?>/js/trainingplanner.js"></script>
    <script type="text/javascript" src="<?php echo $url; ?>/js/zoneguide.js"></script>
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
		<div class="grid_6 center">
			<div class="box info">
				<?php echo $info; ?>
				<div class="clear"></div>
	      	</div>
		</div>
		<!-- /Right column -->
		
      	<!-- Training hour distribution -->
		<div class="grid_2 avgweekly">
      		<div class="box last">
      			<label for="avg"><?php __('Training Hours'); ?></label>
      			<img class="edit" src="/trainer/img/pencil.gif" onClick="jQuery('#avg').focus()" title="<?php __('Edit');?>">
      			<input type="text" name="avg" id="avg" title="<?php __('These are your <b>average</b> training hours - the average amount of training you will complete throughout your training year. If you update this setting, your whole future training plan will be affected.'); ?>"/>
      			<label for="week"><?php __('This Week'); ?></label>
      			<img class="edit" src="/trainer/img/pencil.gif" onClick="jQuery('#week').focus()" title="<?php __('Edit');?>">
      			<input type="text" name="week" id="week" title="<?php __('This is the amount of training hours for the current training week, derived from your average training hours right above. Adapt this value to receive more or fewer training volume for this week.'); ?>"/>
      			<a href="javascript:TrainingPlanner.resetWeeklyHours();" class="reset"><?php __('reset'); ?></a>
      		</div>
      	</div>
      	
      	<div class="grid_4 distribution">
      		<div class="box last">
	      		<label><?php __('Workout Balance'); ?> <a href="javascript:TrainingPlanner.resetWorkoutBalance();" class="reset"><?php __('reset'); ?></a></label>
      			<div id="slider" title="<?php __('Here you can adjust the balance between your workout types. Drag the sliders to determine how much time is spent on training for each kind of sport. Changing these settings will also affect all future training weeks.'); ?>"></div>
      		</div>
      	</div>
	<!-- /Training hour distribution -->
	</div>
	<div class="clear"></div>
	<!-- /Main -->
	
	<!-- Footer -->
	<?php echo $this->element('footer'); ?>
	<!-- /Footer -->

<script language="JavaScript" type="text/javascript">
// initialize the view
$(document).ready(function() {
 	TrainingPlanner.init('<?php echo $url; ?>', <?php echo ($weeklyhours * 60); ?>, '<?php echo $usersport; ?>', '<?php echo $advancedFeatures;?>');
 	jQuery('#slider').tipTip({ defaultPosition: 'top', maxWidth : "270px" });
 	jQuery('#avg, .edit').tipTip({ defaultPosition: 'top' });
 	jQuery('#week').tipTip();
 	
 	jQuery('body').append(ZoneGuide.getTable(<?php echo $rlth; ?>, <?php echo $blth; ?>, {
 		type : "<?php echo __('Type',true); ?>",
 		zone : "<?php echo __('Zone',true); ?>",
 		run : "<?php echo __('Run',true); ?>",
 		bike : "<?php echo __('Bike',true); ?>"
 	}));
});

// google analytics
var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
try {
var pageTracker = _gat._getTracker("UA-15268905-1");
pageTracker._trackPageview();
} catch(err) {}

// get satisfaction
var is_ssl = ("https:" == document.location.protocol);
var asset_host = is_ssl ? "https://s3.amazonaws.com/getsatisfaction.com/" : "http://s3.amazonaws.com/getsatisfaction.com/";
document.write(unescape("%3Cscript src='" + asset_host + "javascripts/feedback-v2.js' type='text/javascript'%3E%3C/script%3E"));
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