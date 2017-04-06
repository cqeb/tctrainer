      <div class="panel panel-default" id="forms">
        <div class="panel-heading"><h1><?php __('TriCoreTraining'); ?></h1></div>
        
        <div class="panel-body">

         <?php if ($session->read('flash')) { ?>
         <div class="<?php echo $statusbox; ?>">
         <?php echo $session->read('flash'); $session->delete('flash'); ?>
         </div><br />
         <?php } ?>
        
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

         <br /><br /><br /><br /><br />
        </div>
      </div>         

<?php
      $this->js_addon = "";
	  
	  __('January', true);
	  __('February', true);
	  __('March', true);
	  __('April', true);
	  __('May', true);
	  __('June', true);
	  __('July', true);
	  __('August', true);
	  __('September', true);
	  __('October', true);
	  __('November', true);
	  __('December', true);
	  
?>