<!-- FOOTER-->
<footer>
	
<div class="container">
	<div class="row">
      <div class="col-xs-6 col-sm-6 col-lg-3">
        <h4 class="line3 center standart-h4title"><span><?php __('Navigation'); ?></span></h4>
        <ul class="footer-links">
            <li><a href="/trainer/"><?php __('Home'); ?></a></li>
		    <!--<li><a href="/blog/<?php if ( $locale == 'deu' ) echo 'de/'; else echo 'en/'; ?>"><?php __('Blog'); ?></a></li>-->
         	<li><?php __('About'); ?> <a href="/blog/<?php if ( $locale == 'deu' ) echo 'de/'; else echo 'en/'; ?>about/">TriCoreTraining</a></li>
         	<li><a style="word-wrap: break-word; -ms-word-wrap: break-word;" href="/blog/<?php if ( $locale == 'deu' ) echo 'de/'; else echo 'en/'; ?>terms-of-service-2/"><?php __('Terms of Service'); ?></a></li>
        </ul>
      </div>
	  
    <div class="col-xs-6 col-sm-6 col-lg-3">
        <h4 class="line3 center standart-h4title"><span><?php __('Contact'); ?></span></h4>
        <ul class="footer-links">
			<li><a href="mailto:support@tricoretraining.com"><?php __('Support'); ?></a></li>
		 	<li><a href="mailto:support@tricoretraining.com"><?php __('Contact us'); ?></a></li>
			<li><a href="/blog/<?php if ( $locale == 'deu' ) echo 'de/'; else echo 'en/'; ?>imprint/"><?php __('Imprint'); ?></a></li>
        </ul>
    </div> 
	  
	<div class="col-xs-6 col-sm-6 col-lg-3">
        <h4 class="line3 center standart-h4title"><span><?php __('Useful Links'); ?></span></h4>
        <ul class="footer-links">
			<li><?php echo $html->link(__('Pricing',true),array('controller' => 'starts', 'action' => 'features'))?></li>
			<li><?php echo $html->link(__('Get Started',true),array('controller' => 'starts'))?></li>
			<li><a href="/blog/<?php if ( $locale == 'deu' ) echo 'de/'; else echo 'en/'; ?>my-1st-ironman-pain-is-temporary-pride-is-4ever/"><?php __('My first Ironman'); ?></a></li>
        </ul>
    </div>
	
    <div class="col-xs-6 col-sm-6 col-lg-3">
        <h4 class="line3 center standart-h4title"><span><?php __('Social Media'); ?></span></h4>
		<!--
		<address>
			<strong></strong><br>
			<i class="icon-map-marker"></i> 
			<i class="icon-phone-sign"></i>
		</address>
		-->
		<ul class="footer-links">
		 <li><?php __('Join us on'); ?> <a href="http://www.facebook.com/#!/pages/TriCoreTraining/150997251602079" target="_blank">Facebook</a></li>
		 <li><?php __('Follow us on'); ?> <a href="http://www.twitter.com/tricoretraining/" target="_blank">Twitter</a></li>
	 	 <!--<li><a target="_blank" href="http://feeds.feedburner.com/tricoretraining/<?php if ( $locale == 'deu' ) echo 'DE'; else echo 'EN'; ?>"><?php __('RSS'); ?></a></li>-->

		</ul>
    </div>
   </div>
</div><!-- CONTAINER FOOTER-->
</footer>
