
     <h1><?php __('TriCoreTraining'); ?></h1>

     <?php if ($session->check('Message.flash')) { ?>
     <div class="<?php echo $statusbox; ?>">
     <?php $session->flash(); ?>
     </div><br />
     <?php } ?>

<!--
     <div class="errorbox">
     You haven't defined your competitions (goals). Do this first!
     <br /><br />
     <a href="/trainer/competitions/edit_competition"><button value="<?php __('Add competition'); ?>"><?php __('Add competition'); ?></button></a>
     </div><br /> 
-->
     
     <div class="clear"></div>

     <h2><?php __('Next steps to use TriCoreTraining'); ?></h2>
     <ol>
       <li><a href="<?php echo Configure::read('App.hostUrl') . Configure::read('App.serverUrl'); ?>/competitions/list_competitions"><?php __('Define your competitions (goals)'); ?></a></li>
       <li><a href="<?php echo Configure::read('App.hostUrl') . Configure::read('App.serverUrl'); ?>/trainingplans/view"><?php __('Study and fulfill your training schedule'); ?></a></li>
       <li><a href="<?php echo Configure::read('App.hostUrl') . Configure::read('App.serverUrl'); ?>/trainingstatistics/list_trainings"><?php __('Track your workouts'); ?></a></li>
       <li><a href="<?php echo Configure::read('App.hostUrl') . Configure::read('App.serverUrl'); ?>/trainingstatistics/statistics_whathaveidone"><?php __('Analyse your workouts'); ?></a></li>
       <li><a href="<?php echo Configure::read('App.hostUrl') . Configure::read('App.serverUrl'); ?>/users/edit_traininginfo"><?php __('Optimize your settings'); ?></a></li>
       <li><a href="<?php echo Configure::read('App.hostUrl'); ?>/blog/<?php if ( $locale == 'eng' || $locale == '' ) { ?>en<?php } else { ?>de<?php } ?>/"><?php __('Read our FAQs and our blog'); ?></a></li>
     </ol>

     <h2><?php __('Referral'); ?></h2>
	 <?php echo $this->element('referral'); ?>

     <div class="clear"></div>

<?php
      $this->js_addon = "";
?>