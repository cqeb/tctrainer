<!DOCTYPE html>
<html lang="<?php 
    if ( $language == 'deu' ) echo 'de'; 
    else echo 'en'; 
?>">
<head>
    <title><?php
if ( isset( $title ) ) 
	echo 'TriCoreTraining - ' . ' ' . $title;
else	
	echo 'TriCoreTraining - ' . ' ' . $title_for_layout;
?></title>

    <?php $url = Configure::read('App.serverUrl'); //echo $html->charset(); ?>
    <?php echo $html->meta('icon'); ?>

	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">

    <?php echo $this->element('metatags'); ?>
	<?php echo $this->element('header'); ?>

	<link rel="stylesheet" type="text/css" href="<?php echo $url; ?>/css/trainingplans.css?v=<?php echo VERSION; ?>" />
	
    <script type="text/javascript" src="<?php echo $url; ?>/js/trainingplanner.js?v=<?php echo VERSION; ?>"></script>
    <script type="text/javascript" src="<?php echo $url; ?>/js/zoneguide.js?v=<?php echo VERSION; ?>"></script>

	<?php echo $scripts_for_layout; ?>

	<script type="JavaScript">
	$(document).ready(function() {
		$(document).scrollTop( $(".content").offset().top );  
	};
	</script>
	
</head>

<body <?php if ( isset( $this->onLoad ) ) { echo 'onLoad="'. $this->onLoad . '"'; } ?>>
<?php echo $this->element('tracker'); ?>
  
<!-- MAIN WRAPPER class="wrapper" max-width="1110px"-->
<div class="wrapper">

<header>	

    <!-- PAGE-HEADER-->	
	<!-- NAVBAR-->
	<nav class="navbar navbar-fixed-top navbar-inverse" role="navigation">
	<div class="container">
	  	<!-- Brand and toggle get grouped for better mobile display -->
	  	<div class="navbar-header">
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
			<span class="sr-only">Toggle navigation</span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			</button>
			<a class="navbar-brand navbar-brand-small" href="/trainer/">
			<img width="120px" src="<?php echo $url; ?>/img/logo_tricoretraining_233.png" alt="TriCoreTraining Logo"></a>
	  	</div>

		<?php echo $this->element('subnavigation_all'); ?>

	</div><!-- /.navbar-collapse --> 
	<!--</div>	KMS-->
	</nav>

</header>
<!-- /PAGE-HEADER-->

<article>
<div class="container">

	<div class="row">

		<div class="col-xs-12 col-sm-6 col-md-7 col-lg-7">
			<div class="panel">
				<div class="panel-heading"><h1><?php __('Training Plan'); ?></h1></div>
					<div class="panel-body">

					<?php echo $content_for_layout; ?>

					</div>
				</div>
			</div>
		
			<div class="col-xs-12 col-sm-6 col-md-5 col-lg-5">
				<div class="panel">
					<div class="panel-body">

						<div class="info">
							<?php echo $info; ?>
						</div>

						<div class="distribution">
							<div class="box">
								<label><?php __('Workout Balance'); ?> <a href="javascript:TrainingPlanner.resetWorkoutBalance();" class="reset"><?php __('reset'); ?></a></label>
								<div id="slider" title="<?php __('Here you can adjust the balance between your workout types. Drag the sliders to determine how much time is spent on training for each kind of sport. Changing these settings will also affect all future training weeks.'); ?>">
									</div>
							</div>
							<br /><br /><br /><br />
						</div> 		
     				</div>

     			</div>
				<div class="panel">
					<div class="panel-body">

						<!-- Training hour distribution -->
						<div class="avgweekly">
							<div class="box">
								<label for="avg"><?php __('Training Hours'); ?></label>
								<img class="edit" src="/trainer/img/pencil.gif" onClick="jQuery('#avg').focus()" title="<?php __('Edit');?>">
								<input type="text" name="avg" id="avg" title="<?php __('These are your <b>average</b> training hours - the average amount of training you will complete throughout your training year. If you update this setting, your whole future training plan will be affected.'); ?>"/>
								<label for="week"><?php __('This Week'); ?></label>
								<img class="edit" src="/trainer/img/pencil.gif" onClick="jQuery('#week').focus()" title="<?php __('Edit');?>">
								<input type="text" name="week" id="week" title="<?php __('This is the amount of training hours for the current training week, derived from your average training hours right above. Adapt this value to receive more or fewer training volume for this week.'); ?>"/>
								<a href="javascript:TrainingPlanner.resetWeeklyHours();" class="reset"><?php __('reset'); ?></a>
							</div>
						</div>

					</div>
				</div>

				<div class="panel">
					<div class="panel-body">

						<h3><?php __('Calendar import'); ?></h3>
						<?php echo $html->link(__('Add current training week to your calendar',true),array('controller' => 'trainingplans', 'action' => 'get_events'))?> (<?php echo $html->link(__('Next',true),array('controller' => 'trainingplans', 'action' => 'get_events?o=1'))?>)
						
						<!--//
						<?php //if ( $this->getAthlete()->isValid() == 0 ) { ?>
						<?php if ( 1 == 1 ) { ?>
						<a class="btn btn-primary" href="/trainer/payments/subscribe_triplans"><b><?php __('Upgrade to PREMIUM'); ?></b></a>
							<br /><br />
						<?php } ?>
						//-->
						
						<h3><?php __('First steps'); ?></h3>
						<a id="guide" href="#" title=""><?php __('Beginner\'s guide to your training'); ?></a>

						<h3><?php __('Your mesocycle of the next weeks'); ?> <a class="help badge" href="/blog/<?php if (isset($language)) echo $language . '/'; ?>basics-what-to-know-about-endurance-training/">?</a></h3>
						
						<?php

						echo $mesocycles;

						?>
						<div class="spacerr"></div>
					</div>
				</div>
			</div>
		</div>
		<?php if ($session->read('flash')) { ?>
			<div class="alert alert-danger">
			<?php echo $session->read('flash'); $session->delete('flash'); ?>
			</div><br />
		<?php } ?>
	</div>
</div>
</article>

<!-- Footer -->
<?php echo $this->element('footer'); ?>
<!-- /Footer -->

</div>

<!-- Placed at the end of the document so the pages load faster -->


<?php if ( isset( $this->js_addon ) ) echo $this->js_addon; ?>

<script>
jQuery(document).ready(function(){
	jQuery('#topnav').localScroll(3000);
	jQuery('#startbtn').localScroll(2000);
	//.parallax(xPosition, speedFactor, outerHeight) options:
	//xPosition - Horizontal position of the element
	//inertia - speed to move relative to vertical scroll. Example: 0.1 is one tenth the speed of scrolling, 2 is twice the speed of scrolling
	//outerHeight (true/false) - Whether or not jQuery should use it's outerHeight option to determine when a section is in the viewport
	jQuery('#parallax-bg').parallax("50%", 0.1);
	//jQuery('#Section-1').parallax("50%", 0.3);
	//jQuery('#Section-2').parallax("50%", 0.1);
	//jQuery('#foot-sec').parallax("50%", 0.1);

})
</script>

<script>
//hide menu after click on mobile
jQuery('.navbar .nav > li > a').click(function(){
		jQuery('.nav-collapse.navbar-responsive-collapse.in').removeClass('in').addClass('collapse').css('height', '0');

		});
</script>

<!-- NICE Scroll plugin -->
<script>
//scroll bar custom
	jQuery(document).ready(
  function() {  
    jQuery("html").niceScroll({cursorcolor:"#333"});
  }
);
</script>
<script>
 //$('.carousel').carousel({interval:5000});
</script>

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


	jQuery('#guide').magnificPopup({
	    items: [
				{
					'src'	: "<div class='white-popup-block'><img class='responsiveimage' alt='' src='/trainer/img/guide/01_trainingplan.jpg'><?php __('1. Your workouts are sorted by relevancy. If you receive a lot of workouts, combine them, but have one day for rest at minimum.'); echo '<br />'; __('2. Change your available time, if necessary.'); echo '<br />'; __('3. Change your sports balance, if necessary.'); echo '<br />'; __('Click on the right side of the image to go to the next step.'); echo '<br /></div>'; ?>"
				},
				{
					'src'	: "<div class='white-popup-block'><img class='responsiveimage' alt='' src='/trainer/img/guide/02_competition.jpg'><?php __('Add your important competitions to get an improved training plan based on your sport goals.'); ?></div>"
				},
				{
					'src'	: "<div class='white-popup-block'><img class='responsiveimage' alt='' src='/trainer/img/guide/03_settings.jpg'><?php __('If you have more specific training data, modify your settings. Change your lactate threshold or check your heart rate zones.'); ?></div>"
				},
				{
					'src'	: "<div class='white-popup-block'><img class='responsiveimage' alt='' src='/trainer/img/guide/04_workout.jpg'><?php __('Logg your workouts to have a history of your training and receive more specific training workouts. Post your achievements to Twitter or Facebook.'); ?></div>"
				},
				{
					'src'	: "<div class='white-popup-block'><img class='responsiveimage' alt='' src='/trainer/img/guide/05_statistics.jpg'><?php __('Analyse the results of your training with the most important graphs and statistics.'); ?></div>"
				}
		],
	    gallery: {
	      enabled: true
	    },
	    type: 'inline' // this is default type
	});
});
</script>


<?php echo $this->element('footerend'); ?>

</body>
</html>