<?php $q_config['language'] = qtrans_getLanguage(); ?>

	<!-- Footer -->
	<!-- FOOTER-->
<footer>
	
<div class="container">
	<div class="row">
      <div class="col-xs-6 col-sm-6 col-lg-3">
        <h4 class="line3 center standart-h4title"><span><?php _e('Navigation'); ?></span></h4>
        <ul class="footer-links">
            <li><a href="/trainer/"><?php _e('Home'); ?></a></li>
		    <!--<li><a href="/blog/en/"><?php _e('Blog'); ?></a></li>-->
         	<li><?php _e('About'); ?> <a href="/blog/en/about/">TriCoreTraining</a></li>
         	<li><a href="/blog/en/terms-of-service-2/"><?php _e('Terms of Service'); ?></a></li>
        </ul>
      </div>
	  
    <div class="col-xs-6 col-sm-6 col-lg-3">
        <h4 class="line3 center standart-h4title"><span><?php _e('Contact'); ?></span></h4>
        <ul class="footer-links">
			<li><a href="mailto:support@tricoretraining.com"><?php _e('Support'); ?></a></li>
		 	<li><a href="mailto:support@tricoretraining.com"><?php _e('Contact us'); ?></a></li>
			<li><a href="/blog/en/imprint/"><?php _e('Imprint'); ?></a></li>
        </ul>
    </div> 
	  
	<div class="col-xs-6 col-sm-6 col-lg-3">
        <h4 class="line3 center standart-h4title"><span><?php _e('Useful Links'); ?></span></h4>
        <ul class="footer-links">
			<li><a href="/trainer/starts/features"><?php _e('Pricing'); ?></a></li>
			<li><a href="/trainer/starts"><?php _e('Get Started'); ?></a></li>
			<li><a href="/blog/en/my-1st-ironman-pain-is-temporary-pride-is-4ever/"><?php _e('My first Ironman'); ?></a></li>
        </ul>
    </div>
	
    <div class="col-xs-6 col-sm-6 col-lg-3">
        <h4 class="line3 center standart-h4title"><span><?php _e('Social Media'); ?></span></h4>
		<!--
		<address>
			<strong></strong><br>
			<i class="icon-map-marker"></i> 
			<i class="icon-phone-sign"></i>
		</address>
		-->
		<ul class="footer-links">
		 <li>Join us on <a href="http://www.facebook.com/#!/pages/TriCoreTraining/150997251602079" target="_blank"><?php _e('Facebook'); ?></a></li>
		 <li>Follow us on <a href="http://www.twitter.com/tricoretraining/" target="_blank"><?php _e('Twitter'); ?></a></li>
	 	 <!--<li><a target="_blank" href="http://feeds.feedburner.com/tricoretraining/<?php echo strtoupper( $q_config['language'] ); ?>"><?php _e('RSS'); ?></a></li>-->

		</ul>
    </div>
   </div>
</div><!-- CONTAINER FOOTER-->
</footer>
	<!-- /Footer -->

<?php wp_footer(); ?>
<!--
<?php echo get_num_queries(); ?> <?php _e('queries'); ?>. <?php timer_stop(1); ?> <?php _e('seconds'); ?>.
-->

</div>

<!-- Placed at the end of the document so the pages load faster -->



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


</body>
</html>