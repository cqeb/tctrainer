<?php


?><!DOCTYPE html>
<html lang="<?php 
    if ( $locale == 'deu' ) echo 'de'; 
    else echo 'en'; 
?>">

<head>
    <title><?php

if ( isset( $title ) ) 
	echo 'TriCoreTraining.com' . ' ' . $title;
else	
	echo 'TriCoreTraining.com' . ' ' . $title_for_layout;
?></title>

    <?php $url = Configure::read('App.serverUrl'); //echo $html->charset(); ?>

    <?php echo $html->meta('icon'); ?>

<!--	<link rel="shortcut icon" href="<?php echo $url; ?>/assets/ico/favicon.png">    -->
	
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">

    <?php echo $this->element('metanavigation'); ?>

    <link rel="alternate" type="application/rss+xml" title="TriCoreTraining.com RSS" href="http://feeds.feedburner.com/tricoretraining/<?php if ( $locale == 'eng' || $locale == '' ) { ?>EN<?php } else { ?>DE<?php } ?>" />


	<!-- Latest compiled and minified CSS BS 3.0. RC1-->
	<link href="<?php echo $url; ?>/assets/css/theme.css?v=<?php echo VERSION; ?>" rel="stylesheet">

	<link rel="stylesheet" type="text/css" href="<?php echo $url; ?>/css/tipTip.css?v=<?php echo VERSION; ?>" />

	<link rel="stylesheet" type="text/css" href="<?php echo $url; ?>/css/edittraining.css?v=<?php echo VERSION; ?>" />
	<script type="text/javascript" src="<?php echo $url; ?>/js/workoutstats.js?v=<?php echo VERSION; ?>"></script>
	<script type="text/javascript" src="<?php echo $url; ?>/js/timeparser.js?v=<?php echo VERSION; ?>"></script>      	

	<?php echo $scripts_for_layout; ?>

 <?php echo $this->element('header'); ?>


	<link href="http://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css?v=<?php echo VERSION; ?>" rel="stylesheet"> 
	<!--[if lt IE 7]>
	<link href="<?php echo $url; ?>/assets/css/font-awesome-ie7.min.css?v=<?php echo VERSION; ?>" rel="stylesheet">
	<![endif]-->

	<!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
	<!--[if lt IE 9]>
	<script src="http://html5shim.googlecode.com/svn/trunk/html5.js?v=<?php echo VERSION; ?>" type="text/javascript"></script>

	<![endif]-->

<!--	<link rel="shortcut icon" href="<?php echo $url; ?>/assets/ico/favicon.ico">-->
	<link rel="apple-touch-icon-precomposed" sizes="144x144" href="<?php echo $url; ?>/assets/ico/apple-touch-icon-144-precomposed.png">
	<link rel="apple-touch-icon-precomposed" sizes="114x114" href="<?php echo $url; ?>/assets/ico/apple-touch-icon-114-precomposed.png">
	<link rel="apple-touch-icon-precomposed" sizes="72x72" href="<?php echo $url; ?>/assets/ico/apple-touch-icon-72-precomposed.png">
	<link rel="apple-touch-icon-precomposed" href="<?php echo $url; ?>/assets/ico/apple-touch-icon-57-precomposed.png">
	
 </head>

<body <?php if ( isset( $this->onLoad ) ) { echo 'onLoad="'. $this->onLoad . '"'; } ?>>
  
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
		<a class="navbar-brand navbar-brand-small" href="#">
		<img width="120px" src="<?php echo $url; ?>/img/logo_tricoretraining_233.png" alt="TriCoreTraining.com Logo"></a>
	  	</div>

		<?php echo $this->element('subnavigation_all_new'); ?>

		</div><!-- /.navbar-collapse --> 
	</div>	
	</nav>


</header>
<!-- /PAGE-HEADER-->

<article>
<div class="container">

<?php echo $content_for_layout; ?>

</div>
</article>

	<!-- Footer -->
	<?php echo $this->element('footer_new'); ?>
	<!-- /Footer -->

</div>

<!-- Placed at the end of the document so the pages load faster -->
<script src="<?php echo $url; ?>/assets/js/jquery.js?v=<?php echo VERSION; ?>" type="text/javascript"></script>

<script src="http://netdna.bootstrapcdn.com/bootstrap/3.0.0-rc1/js/bootstrap.min.js?v=<?php echo VERSION; ?>"></script>
<!-- PAGE CUSTOM SCROLLER -->
<script type="text/javascript" src="<?php echo $url; ?>/assets/js/jquery.nicescroll.min.js?v=<?php echo VERSION; ?>"></script>

<script src="<?php echo $url; ?>/assets/js/jquery.parallax-1.1.3.js?v=<?php echo VERSION; ?>" type="text/javascript" ></script>
<script src="<?php echo $url; ?>/assets/js/jquery.localscroll-1.2.7-min.js?v=<?php echo VERSION; ?>" type="text/javascript" ></script>
<script src="<?php echo $url; ?>/assets/js/jquery.scrollTo-1.4.2-min.js?v=<?php echo VERSION; ?>" type="text/javascript" ></script>

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
 $('.carousel').carousel({interval:5000});
</script>

</body>
</html>