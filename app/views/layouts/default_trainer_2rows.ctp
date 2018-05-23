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

    <link rel="stylesheet" type="text/css" href="<?php echo $url; ?>/css/reset.css?v=<?php echo VERSION; ?>" />
    <link rel="stylesheet" type="text/css" href="<?php echo $url; ?>/css/text.css?v=<?php echo VERSION; ?>" />
    <link rel="stylesheet" type="text/css" href="<?php echo $url; ?>/css/960.css?v=<?php echo VERSION; ?>" />
    <link rel="stylesheet" type="text/css" href="<?php echo $url; ?>/css/styles.css?v=<?php echo VERSION; ?>" />
    <link rel="stylesheet" type="text/css" href="<?php echo $url; ?>/css/facebox.css?v=<?php echo VERSION; ?>" />
    <link rel="stylesheet" type="text/css" href="<?php echo $url; ?>/css/theme/jquery-ui-1.8.5.custom.css?v=<?php echo VERSION; ?>" />
    <link rel="stylesheet" type="text/css" href="<?php echo $url; ?>/css/tipTip.css?v=<?php echo VERSION; ?>" />
    <link rel="stylesheet" type="text/css" href="<?php echo $url; ?>/css/960.responsive.css?v=<?php echo VERSION; ?>" />


<?php if ( $_SERVER['HTTP_HOST'] == LOCALHOST ) { ?>
	<script type="text/javascript" src="<?php echo $url; ?>/js/jquery-1.6.4.min.js"></script>
<?php } else { ?>
    <script type="text/javascript" src="http://code.jquery.com/jquery-1.6.4.min.js"></script>
<?php } ?>

    <script type="text/javascript" src="<?php echo $url; ?>/js/jquery-ui-1.8.5.custom.min.js"></script>
    <script type="text/javascript" src="<?php echo $url; ?>/js/jquery-fluid16.min.js?v=<?php echo VERSION; ?>"></script>

    <script type="text/javascript" src="<?php echo $url; ?>/js/facebox.min.js?v=<?php echo VERSION; ?>"></script>
    <script type="text/javascript" src="<?php echo $url; ?>/fancybox/jquery.fancybox-1.3.4.pack.js"></script>
    <script type="text/javascript" src="<?php echo $url; ?>/js/jquery.tipTip.min.js?v=<?php echo VERSION; ?>"></script>
    <!--[if lte IE 8]><script language="javascript" type="text/javascript" src="<?php echo $url; ?>/js/excanvas.min.js"></script><![endif]-->

    <script type="text/javascript" src="http://www.google.com/jsapi"></script>
    

    <?php echo $scripts_for_layout; ?>

    <script type="JavaScript">
    $(document).ready(function() {
        $(document).scrollTop( $(".content").offset().top );  
    };
    </script>


</head>
<body>
<?php echo $this->element('tracker'); ?>

  <!-- Header -->
  <div class="container_12 header">
    <div class="grid_12 branding">
		  <a href="<?php echo Configure::read('App.serverUrl'); ?>">
			<img src="<?php echo Configure::read('App.serverUrl'); ?>/img/logo_tricoretraining_233.png" alt="TriCoreTraining Logo" title="TriCoreTraining Logo" />
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
      <div id="navigation" class="box navigation">
      <?php //__('Navigation');?>
               <?php echo $this->element('subnavigation_all'); ?>
      </div>
      
      <div id="ads" class="box last">
               <?php echo $this->element('adbox'); ?>
      </div>
    </div>
    <!-- /Left column -->
    
    <!-- Center column -->
      <div class="grid_9">
      <!-- Content -->
      <div class="box content last">
        <?php echo $content_for_layout; ?>
        <div class="clear"></div>
      </div>
      <!-- /Content -->
    </div>
    <!-- /Center column -->
    
  </div>
  <div class="clear"></div>
  <!-- /Main -->
  
  <!-- Footer -->
  <?php echo $this->element('footer'); ?>
  <!-- /Footer -->

  <?php if ( isset( $this->js_addon ) ) echo $this->js_addon; ?>
  
	<!-- Footer End -->
    <?php echo $this->element('footerend'); ?>
	<!-- /Footer End -->

</body>
</html>