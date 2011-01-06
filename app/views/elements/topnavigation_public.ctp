<ul>
	<li>
		<?php echo $html->link(__('Signup FREE',true),array('controller' => 'users', 'action' => 'register'), array('class' => 'active'))?>
	</li>
	<li>
		<?php echo $html->link(__('Login',true),array('controller' => 'users', 'action' => 'login'), array('class' => 'main'))?>
	</li>
	<li>
    <?php echo $html->link(__('Features & Prices',true),array('controller' => 'starts', 'action' => 'features'), array('class' => 'main'))?>
	</li>
  <li>
    <a href="/blog/<?php if ( $locale == 'deu' ) echo 'de/'; else echo 'en/'; ?>"><?php __('Blog'); ?></a>
  </li>
	<li>
	<a href="http://www.facebook.com/#!/pages/TriCoreTraining/150997251602079?v=wall" target="_blank"><img width="30" alt="TriCoreTraining.com Facebook Page" src="<?php echo Configure::read('App.serverUrl'); ?>/img/icon_facebook.png" /></a>
  </li>
  <li>
  <a href="http://www.twitter.com/tricoretraining/" target="_blank"><img width="30" alt="TriCoreTraining.com on Twitter" src="<?php echo Configure::read('App.serverUrl'); ?>/img/icon_twitter.png" /></a>
  </li>
  <!--
  <li>
  <a href="#" target="_blank"><img alt="TriCoreTraining.com RSS-Feed" src="<?php echo Configure::read('App.serverUrl'); ?>/img/icon_rss.png" /></a>
	</li>
	-->
</ul>