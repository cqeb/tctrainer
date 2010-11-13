<?php

$magazine_class = 'active';

if ( $this->name == 'Competitions' ) { $competitions_class = 'active'; $magazine_class = 'main'; }
else $competitions_class = 'main';

if ( $this->name == 'Trainingplans' ) { $trainingplans_class = 'active'; $magazine_class = 'main'; }
else $trainingplans_class = 'main';

if ( $this->name == 'Trainingstatistics' ) { $trainingstatistics_class = 'active'; $magazine_class = 'main'; }
else $trainingstatistics_class = 'main';

?>
<ul>
	<li>
		<?php echo $html->link(__('Competitions',true),array('controller' => 'competitions', 'action' => 'list_competitions'), array('class' => $competitions_class))?>
	</li>
	<li>
		<?php echo $html->link(__('Training Schedule',true),array('controller' => 'trainingplans', 'action' => 'view'), array('class' => $trainingplans_class ))?>
	</li>
  <li>
    <?php echo $html->link(__('Logbook',true),array('controller' => 'trainingstatistics', 'action' => 'list_trainings'), array('class' => $trainingstatistics_class))?>
  </li>
	<li>
		<a class="<?php echo $magazine_class; ?>" href="#"><?php __('Magazine'); ?></a>
	</li>
  <li>
  <a href="http://www.facebook.com/#!/pages/TriCoreTraining/150997251602079?v=wall" target="_blank"><img alt="TriCoreTraining.com Facebook Page" src="<?php echo Configure::read('App.serverUrl'); ?>/img/icon_facebook.png" /></a>
  </li>
  <li>
  <a href="http://www.twitter.com/tricoretraining/" target="_blank"><img alt="TriCoreTraining.com on Twitter" src="<?php echo Configure::read('App.serverUrl'); ?>/img/icon_twitter.png" /></a>
  </li>
  <!--
  <li>
  <a href="#" target="_blank"><img alt="TriCoreTraining.com RSS-Feed" src="<?php echo Configure::read('App.serverUrl'); ?>/img/icon_rss.png" /></a>
  </li>
  -->	
</ul>