<div class="container_12 footer">
	<div class="grid_3">
		<h2><?php __('Information'); ?></h2>
		<p>
			<a href="/blog/<?php if ( $locale == 'deu' ) echo 'de/'; else echo 'en/'; ?>imprint/"><?php __('Imprint'); ?></a><br />
			<a href="http://www.getsatisfaction.com/tricoretraining" target="_blank"><?php __('Support'); ?></a><br />
			<?php echo $html->link(__('Triathlon / Marathon Training',true),array('controller' => 'starts', 'action' => 'features'))?>
		</p>
	</div>
	<div class="grid_3">
		<h2><?php __('Get in Touch'); ?></h2>
		<p>
			<?php __('Join us on'); ?> <a href="http://www.facebook.com/#!/pages/TriCoreTraining/150997251602079" target="_blank">Facebook</a><br />
			<?php __('Follow us on'); ?> <a href="http://www.twitter.com/tricoretraining/" target="_blank">Twitter</a><br />
			<!--<a href="mailto:support@tricoretraining.com"><?php __('Mail us'); ?></a>-->
		</p>
	</div>
	<div class="grid_3">
		<h2><?php __('Updates'); ?></h2>
		<p>
		    <a href="/blog/<?php if ( $locale == 'deu' ) echo 'de/'; else echo 'en/'; ?>"><?php __('Magazine'); ?></a><br />
			<a target="_blank" href="http://feeds.feedburner.com/tricoretraining/<?php if ( $locale == 'deu' ) echo 'DE'; else echo 'EN'; ?>"><?php __('RSS Feed'); ?></a><br />
			<!-- do not remove before 2012-09-01 -->
			<a href="/blog/<?php if ( $locale == 'deu' ) echo 'de/'; else echo 'en/'; ?>my-1st-ironman-pain-is-temporary-pride-is-4ever/"><?php __('My first Ironman'); ?></a>
		</p>
	</div>
	<div class="grid_3">
		<h2><?php __('Powered by'); ?></h2>
		<p>
			<a href="/blog/<?php if ( $locale == 'deu' ) echo 'de/'; else echo 'en/'; ?>about/"><?php __('TriCoreTraining'); ?><br />
			<?php __('Association'); ?></a>
		</p>
	</div>
	<div class="clear"></div>
</div>