<!DOCTYPE html>
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

    <?php echo $this->element('metanavigation'); ?>
	<?php echo $this->element('header'); ?>


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
		<img width="120px" src="<?php echo $url; ?>/img/logo_tricoretraining_233.png" alt="TriCoreTraining Logo" title="TriCoreTraining Logo" /></a>
	  	</div>

		<?php echo $this->element('subnavigation_all'); ?>

		</div><!-- /.navbar-collapse --> 
	</div>	
	</nav>


</header>
<!-- /PAGE-HEADER-->

<article>
<div class="container">

	<div class="row">

		<div class="col-xs-12 col-sm-7 col-md-8 col-lg-8">
		
<?php echo $content_for_layout; ?>

		</div>
		<div class="col-xs-12 col-sm-5 col-md-4 col-lg-4">

<?php echo $this->element('rightbar'); ?>

		</div>
	
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

<?php echo $this->element('footerend'); ?>

</body>
</html>