      <div class="panel panel-default" id="forms">
        <div class="panel-heading"><h1><?php __('Password forgotten'); ?></h1></div>
        
        <div class="panel-body">

             <?php echo $this->element('js_error'); ?>

             <?php echo $form->create('User', array('action' => 'password_forgotten', 'class' => 'form-horizontal'));?>

             <fieldset>
             <legend><?php __('Enter your email to reset your password.'); ?></legend>

             <?php if ($session->read('flash')) { ?>
             <div class="<?php echo $statusbox; ?>">
             <?php echo $session->read('flash'); $session->delete('flash'); ?>

             </div><br />
             <?php } ?>

<div class="form-group">             

<?php

if ( $status != 'sent' )
{

      echo $form->input('email',
           array(
           'before' => '',
           'after' => '',
           'between' => '',
           'maxLength' => 255,          
           'class' => 'required form-control',
           'label' => array( 'class' => 'control-label', __('Your email', true) ),
           'error' => array( 
              'notempty' => __('You have to enter an email', true),
              'wrap' => 'span', 
              'class' => 'text-danger'
           )
      ));

?>
</div>

<div class="form-group">

<?php      
      
      //create the reCAPTCHA form.
      //$recaptcha->display_form('echo');
      
      //hide an email address
      //$recaptcha->hide_mail('tri@schremser.com','echo');

?>

</div>

                 <?php echo $this->Form->submit(__('Send',true), array('class'=>'btn btn-primary')); ?>
               

<?php } ?>
                 </fieldset>
                 <?php echo $form->end();?>


<?php if ( $_SERVER['HTTP_HOST'] == LOCALHOST ) { ?>
<br /><br />
For DEBUGGING (only localhost):
<a href="<?php echo Configure::read('App.serverUrl'); ?>/users/password_reset/transaction_id:<?php echo $transaction_id?>">click to reset your password</a>
<br /><br />
<?php } ?>

<?php $this->js_addon = ''; ?>

        </div>
      </div>
