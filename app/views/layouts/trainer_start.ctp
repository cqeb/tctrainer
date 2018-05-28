<?php

// NEW VERSION
// get currencies
$currency = 'EUR';
$userobject = null;
$price_array = $unitcalc->get_prices( null, $currency, $userobject );
$price_array_split = $price_array[$currency]['total'];
$price_month_array_split = $price_array[$currency]['month'];

if ( $currency == 'EUR' ) { $currency_show = '€'; } else { $currency_show = '$'; }

// get discount
if ( isset( $userinfo ) ) 
{
		$facebox_content = '';
			
		// create text for facebox with workout
		if ( isset( $distance ) ) 
		{
			
			$facebox_content = '<br /><h1>' . __('My TriCoreTraining workout!', true) . '</h1><p>' . 
			__('I did a', true) . ' ' . $distance . ' ' . $distance_unit . ' ' . 
			__($sport . ' workout', true) . ' ' . __('in',true) . ' ' . $duration . ' ' . 
			__('hour(s)',true) . ' ' . __('with', true) . ' ' .	'TriCoreTraining' .	
			'<br /><br />' . __('Yours', true) . ', ' . $userinfo['firstname'] . '<br /><br />' . 
			'<a href=\'/trainer/users/register\'>&raquo; ' . __('You want to achieve your goal and get a plan for it, why not sign up?', true) . '</a></p>' . 
			'<img alt=\'' . $userinfo['firstname'] . '\' src=\'http://0.gravatar.com/avatar/' . md5( $userinfo['email'] ) . '?s=69&d=identicon\' />';

		// user recommended our service
		} else
		{
			$facebox_content = '<br /><h1>' . __('I LIKE TriCoreTraining!', true) . '</h1><p>' . 
			__("Why don't you become a triathlon athlete too? Why not a marathon runner? TriCoreTraining is your interactive online coach.", true) .
			'<br /><br />' . __('Yours', true) . ', ' . $userinfo['firstname'] . '<br /><br />' . 
			'<a href=\'/trainer/users/register\'>&raquo; ' . __('You want to achieve your goal and get a plan for it, why not sign up?', true) . '</a></p>' . 
			'<img alt=\'' . $userinfo['firstname'] . '\' src=\'http://0.gravatar.com/avatar/' . md5( $userinfo['email'] ) . '?s=69&d=identicon\' />';
		}
		
}

if ( isset( $companyinfo ) ) 
{
			$facebox_content = '<br /><h1>' . __('Your company helps you to save 30% of the membership fee!', true) . '</h1><p>' . 
			__("Register initially with your company email, try out TriCoreTraining and then you will get a discounted PREMIUM membership.", true) . 
			'<br /><br />' . __('Yours', true) . ', Klaus-M. (' . __('founder of', true) . ') ' . __('TriCoreTraining', true) . '<br /><br />' . 
			'<a href=\'/trainer/users/register\'>&raquo; ' . __('If you want to improve your athletic skills and get a plan, why not register?', true) . '</a></p>';
}

if ( isset( $facebox_content ) ) {
	$facebox_content = "
	jQuery.magnificPopup.open({
	    items: {
	      src: \"<div class='white-popup-block'>" . $facebox_content . "</div>\"
	    },
	    type: 'inline'
	});
	";
}

?><!DOCTYPE html>
<html lang="<?php 
    if ( $locale == 'deu' ) echo 'de'; 
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

	<link href="<?php echo $url; ?>/css/styles.css" rel="stylesheet">

	<?php echo $scripts_for_layout; ?>

	<link rel="canonical" href="https://tricoretraining.com" />

</head>

<body>
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
		  <span class="sr-only"><?php __('Toggle navigation', false); ?></span>
		  <span class="icon-bar"></span>
		  <span class="icon-bar"></span>
		  <span class="icon-bar"></span>
		</button>
		<a class="navbar-brand navbar-brand-small" href="/trainer/">
		<img width="120px" src="<?php echo $url; ?>/img/logo_tricoretraining_233.png" alt="TriCoreTraining Logo"></a>
	  	</div>

		<?php echo $this->element('subnavigation_all'); ?>

		</div><!-- /.navbar-collapse --> 
	</div>	
	</nav>


</header>
<!-- /PAGE-HEADER-->

<article>
<div class="container">

         <div class="panel">
			
			<div class="panel-heading">
				<h1><?php __('Reach Your Goal With a Plan!'); ?></h1>
				<h3><?php __('for Triathlon, Running and Biking'); ?></h3>
			</div>
				<div class="panel-body">
					<div id="carousel-example-generic" class="carousel slide bs-docs-carousel-example">
						<ol class="carousel-indicators">
							<li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
							<li data-target="#carousel-example-generic" data-slide-to="1" class=""></li>
							<li data-target="#carousel-example-generic" data-slide-to="2" class=""></li>
							<!--<li data-target="#carousel-example-generic" data-slide-to="3" class=""></li>-->
						</ol>
						<div class="carousel-inner">

							<div class="item active">
							    <img width="125%" class="img-responsive" src="<?php echo $url; ?>/img/start/start-1.jpg" alt="<?php __('Reach Your Goal With a Plan!'); ?>">
								<div class="carousel-caption">
									<h3><?php __('Like Having A Coach!'); ?></h3>
									<p><?php __('Get a <b>professional</b>, <b>online</b> training plan to <br/> <b>improve</b> your <b>running</b>, <b>biking</b> or <b>triathlon skills</b>!');?>
										<br /><br />
									<a class="btn btn-success" href="<?php echo Configure::read('App.serverUrl'); ?>/users/register/"><?php __('Get Started');?><!--<em><?php __('it´s free!');?></em>--></a></p>
								</div>
							</div>
							<div class="item">
								<img width="125%" class="img-responsive" src="<?php echo $url; ?>/img/start/start-2.jpg" alt="<?php __('Job, Family, No Time?'); ?>">
								<div class="carousel-caption">
									<h3><?php __('Job, Family, No time?'); ?></h3>
									<p><?php __('Be an ambitious athlete despite <b>a full time job and family time</b>.'); ?>
										<br /><br />
										<a class="btn btn-success" href="<?php echo Configure::read('App.serverUrl'); ?>/users/register/"><?php __('Get Started');?><!--<br /><em><?php __('it´s free!');?></em>--></a></p>
									</p>
								</div>
							</div>
							<div class="item">
								<img width="125%" class="img-responsive"src="<?php echo $url; ?>/img/start/start-3.jpg" alt="<?php __('Enjoy your training'); ?>">
								<div class="carousel-caption">
									<h3><?php __('Enjoy your training'); ?></h3>
									<p> <?php __('Want to finish a Half Ironman or marathon? <b>Get the most out of training!</b>'); ?>
										<br /><br />
										<a class="btn btn-success" href="<?php echo Configure::read('App.serverUrl'); ?>/users/register/"><?php __('Get Started');?><!--<br /><em><?php __('it´s free!');?></em>--></a></p>
									</p>
								</div>
							</div>
							<!--
							<div class="item">
								<img width="125%" class="img-responsive"src="<?php echo $url; ?>/img/start/start-4.jpg" alt="<?php __(''); ?>">
								<div class="carousel-caption">
									<h3>First slide label</h3>
									<p>Nulla vitae elit libero, a pharetra augue mollis interdum.
										<br />
										<a class="btn btn-success" href="<?php echo Configure::read('App.serverUrl'); ?>/users/register/"><?php __('Get Started');?><br /><em><?php __('it´s free!');?></em></a></p>
									</p>
								</div>
							</div>
							-->
						</div>
						<a class="left carousel-control" href="#carousel-example-generic" data-slide="prev">
							<span class="icon-prev"></span>
						</a>
						<a class="right carousel-control" href="#carousel-example-generic" data-slide="next">
							<span class="icon-next"></span>
						</a>
					</div>
				<?php /*
				<div class="panel-heading">
				<h1><?php __('Reach Your GOAL With A Trainingplan'); ?></h1>
				<!--	<h2><?php __('for Triathlon, Run and Bike'); ?></h2>-->
				</div>
				*/ ?>
				</div><a name="howitworks"></a>
        </div>

		<div class="panel">
			<div class="col-12 col-lg-12 panel-heading text-center">
				<h3 class="big"><?php __('WHAT IS TRICORETRAINING?'); ?></h3>
			</div>
			<div class="panel-body">
				<div class="row">
					<div class="col-lg-12">
            		<?php echo $this->element('startcontent'); ?>
            	</div>
            </div>
        </div>
  		<a name="features"></a>
</div>

<div class="container">

	<div class="panel text-center">
		<div class="col-12 col-lg-12 panel-heading text-center">
<!--		<div class="panel-heading">-->
			<h3 class="big"><?php __('FEATURES'); ?></h3>
<!--		</div>-->
		</div>
		<div class="panel-body">
			<div class="row">
	      	<!-- START THE FEATURETTES -->
			<div class="col-lg-12">

		      <hr class="featurette-divider">

		      <div class="row featurette">
		        <div class="col-md-7">
		          <h2 class="featurette-heading"><?php __('Get individual training plans');?><span class="text-muted"></span></h2>
		          <p class="lead"><?php __('Receive individual training plans based on your workouts and upcoming competitions.');?></p>
		        </div>
		        <div class="col-md-5">
		          <a target="_blank" href="<?php echo $url; ?>/img/startpage-feature-plans-big.png"><img class="featurette-image img-responsive" src="<?php echo $url; ?>/img/startpage-feature-plans-small.jpg" data-src="holder.js/500x500/auto" alt="<?php __('Get individual training plans');?>" title="<?php __('Get individual training plans');?>"></a>
		        </div>
		      </div>

		      <hr class="featurette-divider">

		      <div class="row featurette">
		        <div class="col-md-5">
		          <a target="_blank" href="<?php echo $url; ?>/img/startpage-feature-stats-big.png"><img class="featurette-image img-responsive" src="<?php echo $url; ?>/img/startpage-feature-stats-small.jpg" data-src="holder.js/500x500/auto" alt="<?php __('Analyze your workouts');?>" title="<?php __('Analyze your workouts');?>"></a>
		        </div>
		        <div class="col-md-7">
		          <h2 class="featurette-heading"><?php __('Analyze your workouts');?><span class="text-muted"></span></h2>
		          <p class="lead"><?php __('Use detailed statistics to assess yor fitness and gain even more from your workouts.');?></p>
		        </div>
		      </div>

		      <hr class="featurette-divider">

		      <div class="row featurette">
		        <div class="col-md-7">
		          <h2 class="featurette-heading"><?php __('Track your trainings');?><span class="text-muted"></span></h2>
		          <p class="lead"><?php __('Log your trainings, manage your competitions, and also keep track of your weight.');?></p>
		        </div>
		        <div class="col-md-5">
		          <a target="_blank" href="<?php echo $url; ?>/img/startpage-feature-track-big.png"><img class="featurette-image img-responsive" src="<?php echo $url; ?>/img/startpage-feature-track-small.jpg" data-src="holder.js/500x500/auto" alt="<?php __('Track your trainings');?>" title="<?php __('Track your trainings');?>"></a>
		        </div>
		      </div>

		      <hr class="featurette-divider">

		      <!-- /END THE FEATURETTES -->
  			</div>
  			</div>
		</div><a name="references"></a>
	</div>

</div>

<div class="container">
	<div class="panel">
		<div class="col-12 col-lg-12 panel-heading text-center">
			<h3 class="big"><?php __('WHAT PEOPLE SAY ABOUT'); ?> TRICORETRAINING</h3>
		</div>
	<div class="panel-body">
		<div class="row">
			<div class="col-xs-12 col-sm-6 col-lg-6">
				<div class="row">
				<div class="col-xs-12 col-sm-4 col-lg-3 hidden-xs text-right">
					<img class="img-circle" src="<?php echo $url; ?>/img/profile_nicor.jpg" alt="Nicolaus Reimer, <?php __('reference for'); ?> TriCoreTraining" style="width: 75px; height: 75px;">
				</div>
					<div class="col-xs-12 col-sm-8 col-lg-9">
						<blockquote>
						  <p><?php __('TriCoreTraining helped me in my training for my Ironmans and many other races. Thank you.'); ?></p>
						  <small>Nicolaus Reimer, 39, six times Ironman <cite title="Source Title"></cite></small>
						</blockquote>
					</div>
				</div>
			</div>
			<div class="col-xs-12 col-sm-6 col-lg-6">
				<div class="row">
				<div class="col-xs-12 col-sm-4 col-lg-3 hidden-xs text-right">
					<img class="img-circle" src="<?php echo $url; ?>/img/profile_klausms.jpg" alt="Klaus-M. Schremser, <?php __('reference for'); ?> TriCoreTraining" style="width: 75px; height: 75px;">
				</div>
					<div class="col-xs-12 col-sm-8 col-lg-9">
						<blockquote>
						  <p><?php __('I lost 8 kilograms while I did my TriCoreTraining training for two Half-Ironmans a year'); ?></p>
						  <small>Klaus-M. Schremser, 38, Triathlete since 2003 <cite title="Source Title"></cite></small>
						</blockquote>
					</div>
				</div>
			</div>
			<div class="col-xs-12 col-sm-6 col-lg-6">
				<div class="row">
				<div class="col-xs-12 col-sm-4 col-lg-3 hidden-xs text-right">
					<img class="img-circle" src="<?php echo $url; ?>/img/profile_bernhardr.jpg" alt="Bernhard Riegler,  <?php __('reference for'); ?> TriCoreTraining" style="width: 75px; height: 75px;">
				</div>
					<div class="col-xs-12 col-sm-8 col-lg-9">
						<blockquote>
						  <p><?php __('I am a rookie at triathlon, but now I go for Ironman Austria with TriCoreTraining - great!'); ?></p>
						  <small>Bernhard Riegler, 32, Triathlon rookie<cite title="Source Title"></cite></small>
						</blockquote>
					</div>
				</div>
			</div>
			<div class="col-xs-12 col-sm-6 col-lg-6">
				<div class="row">
				<div class="col-xs-12 col-sm-4 col-lg-3 hidden-xs text-right">
					<img class="img-circle" src="<?php echo $url; ?>/img/profile_clemensp.jpg" alt="Clemens Prerovsky,  <?php __('reference for'); ?> TriCoreTraining" style="width: 75px; height: 75px;">
				</div>
					<div class="col-xs-12 col-sm-8 col-lg-9">
						<blockquote>
						  <p><?php __('My marathon time is down to 3 hours 27 minutes. Thanks to TriCoreTraining and its training plans.'); ?></p>
						  <small>Clemens Prerovsky, 34, 2 times Ironman <cite title="Source Title"></cite></small>
						</blockquote>
					</div>
				</div>	
			</div>
		</div>
	</div><a name="newsletter"></a>
	</div>
</div>

<?php echo $this->element('newsletter'); ?>

<div class="container">
	<div class="jumbotron">
			<div class="container">
				<div class="row">
					<div class="col-12 col-lg-12 text-center">
						<a name="pricing"></a><h2><?php __('Choose your plan'); ?></h2>
						<p></p>
					</div>
				</div>
			</div>
    </div>
</div>

<div class="container">
      <!-- Example row of columns -->
      <div class="row">
        <div class="col-xs-12 col-sm-4 col-lg-4">
			<div class="panel panel-success">
				<div class="panel-heading">
					<h3 class="text-center"><i class="icon-fullscreen"></i> <?php __('FREE PLAN'); ?></h3>
				</div>
				<div class="panel-body">
					<div class="row">
						<div class="col-xs-12 col-sm-12 col-lg-12 text-center">
							<p class="lead text-success" style="font-size:40px"><strong><?php echo $currency_show; ?> 0</strong></p>
						</div>
					</div>
					<ul class="list-group list-group-flush text-center">
							<li class="list-group-item"><?php __('Workout log', false); ?></li>
							<li class="list-group-item"><?php __('Training statistics', false); ?></li>
							<li class="list-group-item"><?php __('Personal settings', false); ?></li>
							<li class="list-group-item"><?php __('Track goals', false); ?></li>
							<li class="list-group-item"><?php __('Mobile + Tablet usage', false); ?></li>
							<li class="list-group-item"><?php __('Knowledgebase', false); ?></li>
							<li class="list-group-item"><?php __('No Training Plan', false); ?></li>
						</ul>
				</div>
			<div class="panel-footer">
					<a class="btn btn-success btn-block" href="/trainer/users/register"><?php __('Get Started', false); ?></a>
			</div>
		  </div>
        </div>
        <div class="col-xs-12 col-sm-4 col-lg-4">
			<div class="panel panel-info">
				<div class="panel-heading">
					<h3 class="text-center"><i class="icon-fullscreen"></i> <?php __('MONTHLY PLAN'); ?></h3>
				</div>
				<div class="panel-body">
					<div class="row">
						<div class="col-xs-12 col-sm-12 col-lg-12 text-center">
							<p class="lead text-info" style="font-size:40px"><strong><?php echo $currency . ' ' . $price_array_split[0]; ?></strong></p>
						</div>

					</div>
						<ul class="list-group list-group-flush text-center">
							<li class="list-group-item"><?php __('Workout log', false); ?></li>
							<li class="list-group-item"><?php __('Training statistics', false); ?></li>
							<li class="list-group-item"><?php __('Personal settings', false); ?></li>
							<li class="list-group-item"><?php __('Track goals', false); ?></li>
							<li class="list-group-item"><?php __('Mobile + Tablet usage', false); ?></li>
							<li class="list-group-item"><?php __('Knowledgebase', false); ?></li>
							<li class="list-group-item"><b><?php __('Interactive', false); ?> <?php __('Training Plan', false); ?></b></li>
						</ul>
				</div>
				<div class="panel-footer">
					<a class="btn btn-info btn-block" href="/trainer/users/register"><?php __('Get Started', false); ?></a>
				</div>
			</div> 
	   </div>
        <div class="col-xs-12 col-sm-4 col-lg-4">
			<div class="panel panel-danger">
				<div class="panel-heading">
					<h3 class="text-center"><i class="icon-fullscreen"></i> <?php __('YEARLY PLAN'); ?></h3>
				</div>
				<div class="panel-body">
					<div class="row">
						<div class="col-xs-12 col-sm-12 col-lg-12 text-center">
							<p class="lead text-danger" style="font-size:40px"><strong><?php echo $currency . ' ' . $price_array_split[3]; ?></strong></p>
						</div>
					</div>
						<ul class="list-group list-group-flush text-center">
							<li class="list-group-item"><?php __('Workout log', false); ?></li>
							<li class="list-group-item"><?php __('Training statistics', false); ?></li>
							<li class="list-group-item"><?php __('Personal settings', false); ?></li>
							<li class="list-group-item"><?php __('Track goals', false); ?></li>
							<li class="list-group-item"><?php __('Mobile + Tablet usage', false); ?></li>
							<li class="list-group-item"><?php __('Knowledgebase', false); ?></li>
							<li class="list-group-item"><b><?php __('Interactive', false); ?> <?php __('Training Plan', false); ?></b></li>
						</ul>
				</div>
				<div class="panel-footer">
					<a class="btn btn-danger btn-block" href="/trainer/users/register"><?php __('Get Started', false); ?></a>
				</div>
			</div> 
	   </div>
	</div>
	<div class="container">
		<div class="row">
			<div class="col-12 col-lg-12 text-center">
				<p><i>* <?php __('20% VAT included!'); ?></i></p>
			</div>
		</div>
    </div>
</div>	
</div>
</article>

	<!-- Footer -->
	<?php echo $this->element('footer'); ?>
	<!-- /Footer -->

</div>

<script type="text/javascript">
/** initiate JQuery **/

$(document).ready(function() {
	<?php if ( isset( $facebox_content ) ) echo $facebox_content; ?>
});
</script>

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
 jQuery('.carousel').carousel({interval:5000});
</script>

<?php echo $this->element('footerend'); ?>

<!-- Go to www.addthis.com/dashboard to customize your tools -->
<!--script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-548497ef4596dc15" async="async"></script-->

</body>
</html>