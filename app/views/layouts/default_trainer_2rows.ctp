<!DOCTYPE html>
<html lang="en">
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

    <script type="text/javascript" src="<?php echo $url; ?>/js/jquery-1.4.2.js"></script>
    <!--<script type="text/javascript" src="<?php echo Configure::read('App.serverUrl'); ?>/js/jquery-ui.js"></script>-->
    <script type="text/javascript" src="<?php echo $url; ?>/js/jquery-ui-1.8.5.custom.min.js"></script>
    <script type="text/javascript" src="<?php echo $url; ?>/js/timeparser.js"></script>
    <script type="text/javascript" src="<?php echo $url; ?>/js/trainingplanner.js"></script>
    <script type="text/javascript" src="<?php echo $url; ?>/js/jquery-fluid16.js"></script>
    <script type="text/javascript" src="<?php echo $url; ?>/js/facebox.js"></script>

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
    <!-- Left column -->
    <div class="grid_3 left">
      <div class="box navigation last">
      <?php //__('Navigation');?>
               <?php echo $this->element('subnavigation_all'); ?>
      </div>
<!--
      <div class="box last">
        <h1>Yet another...</h1>
        ... box.      
      </div>
-->
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
  
  <div class="container_12">
  <?php echo $cakeDebug; ?>
  </div>
  
  <!-- Footer -->
  <?php echo $this->element('footer'); ?>
  <!-- /Footer -->

  <?php if ( isset( $this->js_addon ) ) echo $this->js_addon; ?>
  
  <script type="text/javascript">
  var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
  document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
  </script>
  
  <script type="text/javascript">
  try {
  var pageTracker = _gat._getTracker("UA-66985-6");
  pageTracker._trackPageview();
  } catch(err) {}
  </script>
</body>
</html>