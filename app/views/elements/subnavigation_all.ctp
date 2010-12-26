<ul>
<?php if ( !$session_userid ) { ?>
        <li>&nbsp;</li>
        <li><?php echo $html->link(__('Home',true),array('controller' => 'starts', 'action' => 'index'))?></li>
        <li><?php echo $html->link(__('Register',true),array('controller' => 'users', 'action' => 'register'))?></li>
<?php } ?>
 

<?php if ( $this->name == 'Competitions' ) { ?>
		    <li><?php echo $html->link(__('List competitions',true),array('controller' => 'competitions', 'action' => 'list_competitions'))?></li>
		    <li><?php echo $html->link(__('Add competition',true),array('controller' => 'competitions', 'action' => 'edit_competition'))?></li>
<?php } ?>
<?php if ( $this->name == 'Trainingplans' ) { ?>
		    <li><?php echo $html->link(__('Create training schedule',true),array('controller' => 'trainingplans', 'action' => 'view'))?></li>
<?php } ?>
<?php if ( $this->name == 'Trainingstatistics' ) { ?>
		    <li><?php echo $html->link(__('Track workouts',true),array('controller' => 'trainingstatistics', 'action' => 'list_trainings'))?></li>
		    <!--<li><?php echo $html->link(__('(Add training)',true),array('controller' => 'trainingstatistics', 'action' => 'edit_training'))?></li>-->
		    <li><?php echo $html->link(__('How fit am I? (TRIMP)',true),array('controller' => 'trainingstatistics', 'action' => 'statistics_trimp'))?></li>
		    <li><?php echo $html->link(__('How fast am I? (Formcurve)',true),array('controller' => 'trainingstatistics', 'action' => 'statistics_formcurve'))?></li>
		    <li><?php echo $html->link(__('Can I finish the next competition?',true),array('controller' => 'trainingstatistics', 'action' => 'statistics_competition'))?></li>
        <li><?php echo $html->link(__('How much have I lost?',true),array('controller' => 'trainingstatistics', 'action' => 'statistics_howmuchhaveilost'))?></li>
		    <li><?php echo $html->link(__('What have I achieved?',true),array('controller' => 'trainingstatistics', 'action' => 'statistics_whathaveidone'))?></li>
<?php } ?>
<?php if ( $this->name == 'Users' && $session_userid ) { ?>
		    <li><?php echo $html->link(__('Edit profile',true),array('controller' => 'users', 'action' => 'edit_userinfo'))?></li>
		    <li><?php echo $html->link(__('Edit training info',true),array('controller' => 'users', 'action' => 'edit_traininginfo'))?></li>
		    <li><?php echo $html->link(__('Edit weight goals',true),array('controller' => 'users', 'action' => 'edit_weight'))?></li>
		    <li><?php echo $html->link(__('Change metric',true),array('controller' => 'users', 'action' => 'edit_metric'))?></li>
		    <li><?php echo $html->link(__('Change password',true),array('controller' => 'users', 'action' => 'edit_password'))?></li>
		    <li><?php echo $html->link(__('Edit images (later)',true),array('controller' => 'users', 'action' => 'edit_images'))?></li>
        <li><?php echo $html->link(__('Subscribe',true),array('controller' => 'payments', 'action' => 'subscribe_triplans'))?></li>

<?php } ?>
<?php if ( $this->name == 'Payments' ) { ?>
		    <li><?php echo $html->link(__('Subscribe',true),array('controller' => 'payments', 'action' => 'subscribe_triplans'))?></li>
		    <li><?php echo $html->link(__('Show payments',true),array('controller' => 'payments', 'action' => 'show_payments'))?></li>
		    <li><?php echo $html->link(__('Cancel subscription',true),array('controller' => 'payments', 'action' => 'unsubscribe_triplans'))?></li>
<?php } ?>
<!--
        <li><?php echo $html->link(__('Prices & Register',true),array('controller' => 'users', 'action' => 'add_step1'))?></li>
        <li><?php echo $html->link(__('Login',true),array('controller' => 'users', 'action' => 'login'))?></li>
        <li><?php echo $html->link(__('Logout',true), array('controller' => 'users', 'action' => 'logout')); ?></li>
        <li><?php echo $html->link(__('Password forgotten',true), array('controller' => 'Users', 'action' => 'password_forgotten')); ?></li>
-->
</ul>
<br />