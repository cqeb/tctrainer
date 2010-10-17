
                   <h1><?php __('Enter the World of TriCoreTraining.com'); ?></h1>

                   <?php echo $this->element('js_error'); ?>

<?php 

// LOGOUT
if ( $session_userid && $session_useremail ) 
{ 

?>
                   <?php //echo $form->create('User', array('action' => 'login'));?>
                   <fieldset>
                   <legend><?php __('You are logged in and want to leave?'); ?></legend>

                   <?php echo $html->link(__('Logout', true), array('controller' => 'users', 'action' => 'logout')); ?>

                   </fieldset>
                   <?php //echo $form->end();?>

<?php } else { ?>
                   <?php echo $form->create('User', array('action' => 'login'));?>
                   <fieldset>
                   <legend><?php __('Log in and start forming your body'); ?></legend>

                   <?php if ($session->check('Message.flash')) { ?>
                   <div class="errorbox">
                   <?php $session->flash(); ?>
                   </div><br />
                   <?php } ?>

<?php
echo $form->input('email',
     array(
     'before' => '',
     'after' => '',
     'between' => '',
     'maxLength' => 255,
     'class' => 'required',
     'label' => __('E-Mail', true),
     'error' => array( 
          'notempty' => __('You have to enter an e-mail', true)
     ) 
));

echo $form->input('password',
     array(
     'before' => '',
     'after' => '',
     'between' => '',
     'maxLength' => 255,
     'class' => 'required',
     'label' => __('Password', true),
     'error' => array( 
        'notempty' => __('You have to enter a password', true) 
     ) 
));

?>
<br />
<?php
		   echo $form->input('remember_me', array('label' => __('Remember me.', true), 'type' => 'checkbox'));
?>

                   <?php echo $form->end(__('Sign In', true));?>

                   </fieldset>

<?php echo $html->link(__('Can\'t remember your password?', true),array('controller' => 'users', 'action' => 'password_forgotten'))?>

<br /><br /><br />


<?php } ?>

