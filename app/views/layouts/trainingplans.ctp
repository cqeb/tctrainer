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

    <link rel="stylesheet" type="text/css" href="<?php echo $url; ?>/css/reset.css?v=<?php echo VERSION; ?>" />
    <link rel="stylesheet" type="text/css" href="<?php echo $url; ?>/css/text.css?v=<?php echo VERSION; ?>" />
    <link rel="stylesheet" type="text/css" href="<?php echo $url; ?>/css/960.css?v=<?php echo VERSION; ?>" />
    <link rel="stylesheet" type="text/css" href="<?php echo $url; ?>/css/styles.css?v=<?php echo VERSION; ?>" />
    <link rel="stylesheet" type="text/css" href="<?php echo $url; ?>/css/facebox.css?v=<?php echo VERSION; ?>" />
    <link rel="stylesheet" type="text/css" href="<?php echo $url; ?>/css/theme/jquery-ui-1.8.5.custom.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo $url; ?>/fancybox/jquery.fancybox-1.3.4.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo $url; ?>/css/trainingplans.css?v=<?php echo VERSION; ?>" />
    <link rel="stylesheet" type="text/css" href="<?php echo $url; ?>/css/tipTip.css?v=<?php echo VERSION; ?>" />


<?php if ( $_SERVER['HTTP_HOST'] == 'localhost' ) { ?>
	<script type="text/javascript" src="<?php echo $url; ?>/js/jquery-1.6.4.min.js"></script>
<?php } else { ?>
    <script type="text/javascript" src="http://code.jquery.com/jquery-1.6.4.min.js"></script>
<?php } ?>
    <script type="text/javascript" src="<?php echo $url; ?>/js/jquery-ui-1.8.5.custom.min.js"></script>
<!--
    <script type="text/javascript" src="<?php echo $url; ?>/js/jquery-fluid16.min.js?v=<?php echo VERSION; ?>"></script>

    <script type="text/javascript" src="<?php echo $url; ?>/js/facebox.min.js?v=<?php echo VERSION; ?>"></script>
-->
    <script type="text/javascript" src="<?php echo $url; ?>/fancybox/jquery.fancybox-1.3.4.pack.js"></script>
	<script type="text/javascript" src="<?php echo $url; ?>/js/jquery.tipTip.min.js?v=<?php echo VERSION; ?>"></script>

    <script type="text/javascript" src="<?php echo $url; ?>/js/timeparser.js?v=<?php echo VERSION; ?>"></script>
    <script type="text/javascript" src="<?php echo $url; ?>/js/trainingplanner.js?v=<?php echo VERSION; ?>"></script>
    <script type="text/javascript" src="<?php echo $url; ?>/js/zoneguide.js?v=<?php echo VERSION; ?>"></script>

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

      	<div class="grid_6">
      		<div class="box">
    			<a id="guide" href="javascript:;" title=""><?php __('Beginner\'s guide to your training'); ?></a>
      		</div>

<?php if ( isset( $userobject ) && $userobject['level'] == 'freemember' ) { ?>
      		
      		<div class="box last">
<script type="text/javascript"><!--
google_ad_client = "ca-pub-1221279145141294";
/* Content middle 2 */
google_ad_slot = "6926088674";
google_ad_width = 200;
google_ad_height = 200;
//-->
</script>
<script type="text/javascript"
src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
</script>
			</div>

<?php } ?>

      	</div>

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
 		sport : "<?php echo __('Sport',true); ?>",
 		zone : "<?php echo __('Zone',true); ?>",
 		run : "<?php echo __('Run',true); ?>",
 		bike : "<?php echo __('Bike',true); ?>"
 	}, true));

    $("#guide").click(function() {
		$.fancybox([
			{
				'href'	: '/trainer/img/guide/01_trainingplan.jpg',
				'title'	: '<?php __('1. Your workouts are sorted by relevancy. If you receive a lot of workouts, combine them, but have one day for rest at minimum.'); echo '<br />'; __('2. Change your available time, if necessary.'); echo '<br />'; __('3. Change your sports balance, if necessary.'); echo '<br />'; __('Click on the right side of the image to go to the next step.'); echo '<br />'; ?>'
			},
			{
				'href'	: '/trainer/img/guide/02_competition.jpg',
				'title'	: '<?php __('Add your important competitions to get an improved training plan based on your sport goals.'); ?>'
			},
			{
				'href'	: '/trainer/img/guide/03_settings.jpg',
				'title'	: '<?php __('If you have more specific training data, modify your settings. Change your lactate threshold or check your heart rate zones.'); ?>'
			},
			{
				'href'	: '/trainer/img/guide/04_workout.jpg',
				'title'	: '<?php __('Logg your workouts to have a history of your training and receive more specific training workouts. Post your achievements to Twitter or Facebook.'); ?>'
			},
			{
				'href'	: '/trainer/img/guide/05_statistics.jpg',
				'title'	: '<?php __('Analyse the results of your training with the most important graphs and statistics.'); ?>'
			}
		], {
			'padding'			: 0,
			'transitionIn'		: 'none',
			'transitionOut'		: 'none',
			'titlePosition' 	: 'over',
			'titleFormat'       : function(title, currentArray, currentIndex, currentOpts) {
		    	return '<span id="fancybox-title-over">' + title + ' (<?php __('Step'); ?> ' +  (currentIndex + 1) + ' / ' + currentArray.length + ')</span>';
			},
			'changeFade'        : 0
		});
	});


});

</script>

	<!-- Footer End -->
    <?php echo $this->element('footerend'); ?>
	<!-- /Footer End -->

</body>
</html>