<?php
$url = url;
?>
<!-- do not track on localhost and testhost -->
<?php if ( $_SERVER['HTTP_HOST'] != LOCALHOST && $_SERVER['HTTP_HOST'] != TESTHOST ) { ?>

<?php 
$admin_user = $this->Session->read('userobject');

if ( isset($admin_user['admin']) && $admin_user['admin'] != 1 ) { 
?>
<!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-P47J8C3');</script>
<!-- End Google Tag Manager -->

<?php } ?>

<?php } ?>

	<!-- Latest compiled and minified CSS BS 3.0. RC1-->
	<link rel="stylesheet" type="text/css" href="<?php echo $url; ?>/assets/css/theme.css?v=<?php echo VERSION; ?>" />
	<link rel="stylesheet" type="text/css" href="<?php echo $url; ?>/css/theme/jquery-ui-1.8.5.custom.css?v=<?php echo VERSION; ?>" />

	<link rel="stylesheet" type="text/css" href="https://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css?v=<?php echo VERSION; ?>" /> 
	<!--[if lt IE 7]>
	<link href="<?php echo $url; ?>/assets/css/font-awesome-ie7.min.css?v=<?php echo VERSION; ?>" rel="stylesheet">
	<![endif]-->

	<link rel="stylesheet" type="text/css" href="<?php echo $url; ?>/css/tipTip.css?v=<?php echo VERSION; ?>" />
	<link rel="stylesheet" type="text/css" href="<?php echo $url; ?>/css/magnific-popup.css?v=<?php echo VERSION; ?>" />
	<link rel="stylesheet" type="text/css" href="<?php echo $url; ?>/css/custom.css?v=<?php echo VERSION; ?>" />

	<script type="text/javascript" src="<?php echo $url; ?>/assets/js/jquery-1.9.1.js?v=<?php echo VERSION; ?>"></script>

	<!--script type="text/javascript" src="<?php echo $url; ?>/js/jquery-ui-1.8.5.custom.min.js?v=<?php echo VERSION; ?>"></script-->
	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/jquery-ui.min.js"></script>


	<script type="text/javascript" src="https://www.google.com/jsapi"></script>

	<!--script type="text/javascript" src="https://netdna.bootstrapcdn.com/bootstrap/3.0.0-rc1/js/bootstrap.js?v=<?php echo VERSION; ?>"></script-->
	<script type="text/javascript" src="<?php echo $url; ?>/assets/js/bootstrap.min.js?v=<?php echo VERSION; ?>"></script>

	<!-- PAGE CUSTOM SCROLLER -->
	<script type="text/javascript" src="<?php echo $url; ?>/assets/js/jquery.nicescroll.min.js?v=<?php echo VERSION; ?>"></script>

	<script type="text/javascript" src="<?php echo $url; ?>/assets/js/jquery.parallax-1.1.3.js?v=<?php echo VERSION; ?>"></script>
	<script type="text/javascript" src="<?php echo $url; ?>/assets/js/jquery.localscroll-1.2.7-min.js?v=<?php echo VERSION; ?>"></script>
	<script type="text/javascript" src="<?php echo $url; ?>/assets/js/jquery.scrollTo-1.4.2-min.js?v=<?php echo VERSION; ?>"></script>

	<script type="text/javascript" src="<?php echo $url; ?>/js/workoutstats.js?v=<?php echo VERSION; ?>"></script>
	<script type="text/javascript" src="<?php echo $url; ?>/js/timeparser.js?v=<?php echo VERSION; ?>"></script>      	
	<script type="text/javascript" src="<?php echo $url; ?>/js/jquery.tipTip.min.js?v=<?php echo VERSION; ?>"></script>
	<script type="text/javascript" src="<?php echo $url; ?>/js/jquery.magnific-popup.js?v=<?php echo VERSION; ?>"></script>


	<!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
	<!--[if lt IE 9]>
	<script src="http://html5shim.googlecode.com/svn/trunk/html5.js?v=<?php echo VERSION; ?>" type="text/javascript"></script>
	<![endif]-->

