
                   <h1><?php __('Password forgotten'); ?></h1>

                   <?php echo $this->element('js_error'); ?>

                   <?php echo $form->create('User', array('action' => 'password_forgotten'));?>
                   <fieldset>
                   <legend><?php __('Enter your e-mail to reset your password.'); ?></legend>

                   <?php if ($session->check('Message.flash')) { ?>
                   <div class="<?php echo $statusbox; ?>">
                   <?php $session->flash(); ?>
                   </div><br />
                   <?php } ?>

<?php

if ( $status != 'sent' )
{

      echo $form->input('email',
           array(
           'before' => '',
           'after' => '',
           'between' => '',
           'maxLength' => 255,
           'class' => 'required',
           'label' => __('Your e-mail', true),
           'error' => array( 
              'notempty' => __('You have to enter an e-mail', true)
           )
      ));

?>
                <br />
<?php      
      
      //create the reCAPTCHA form.
      $recaptcha->display_form('echo');
      
      //hide an e-mail address
      //$recaptcha->hide_mail('tri@schremser.com','echo');

?>
                 <br />

                 <?php echo $form->end(__('Send',true));?>

<?php } ?>
                 </fieldset>

<?php if ( $_SERVER['HTTP_HOST'] == 'localhost' ) { ?>
For DEBUGGING (only localhost):
<a href="<?php echo Configure::read('App.serverUrl'); ?>/users/password_reset/transaction_id:<?php echo $transaction_id?>">click to reset your password</a>
<br /><br />
<?php } ?>

<?php $this->js_addon = ''; ?>
