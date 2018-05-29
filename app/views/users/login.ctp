      <div class="panel panel-default" id="forms">
        <div class="panel-heading"><h1><?php __('Manage your training plan'); ?></h1></div>
        
        <div class="panel-body">

          <?php echo $this->element('js_error'); ?>

<?php 
// LOGOUT
if ( $session_userid && $session_useremail ) { ?>
                   <fieldset>
                   <legend><?php __('You are logged in and want to leave?'); ?></legend>

                   <?php echo $html->link(__('Logout', true), array('controller' => 'users', 'action' => 'logout')); ?>

                   </fieldset>
<?php } else { ?>
                   <?php echo $form->create('User', array('action' => 'login', 'class' => 'form-horizontal' )); ?>
                   <fieldset>
                   <legend><?php __('Log in and start shaping your body'); ?></legend>

                   <?php if ($session->read('flash')) { ?>
                   <div class="alert alert-danger">
                   <?php echo $session->read('flash'); $session->delete('flash'); ?>
                   </div><br />
                   <?php } ?>

<div class="form-group">

        <?php if ( !isset( $session_userid ) ) { ?>
        <?php if ($session->read('previous_url')) { 
          //  does not work yet with Facebook
          //$addon = 'previous_url:' . base64_encode($session->read('previous_url')) . '/'; 
          $addon = '';
        } else {
          $addon = '';
        } ?>
        <a href="/trainer/users/login_facebook/<?php echo $addon; ?>"><img alt="<?php __('Login with your Facebook account!'); ?>" src="/trainer/img/fb-signin.jpg"></a> &nbsp;&nbsp; <b><?php __('or'); ?></b><br />
        <?php } ?>
  
</div>

<div class="form-group">

<?php

echo $form->input('email',
     array(
     'maxLength' => 255,
     'class' => 'required form-control',
     'label' => array('class' => 'control-label', 'text' => __('Email', true)),
     'error' => array( 
          'notempty' => __('You have to enter an email', true),
          'wrap' => 'div', 
          'class' => 'text-danger'
     ) 
));
?>

</div>

<div class="form-group">

<?php

echo $form->input('password',
     array(
     'before' => '',
     'after' => '',
     'between' => '',
     'maxLength' => 255,
     'class' => 'required form-control',
     'label' => array('class' => 'control-label', 'text' => __('Password', true)),
     'error' => array( 
        'notempty' => __('You have to enter a password', true),
        'wrap' => 'div', 
        'class' => 'text-danger'         
     ) 
));

if ($session->read('previous_url')) {
  echo $form->hidden('previous_url', array('value' => $session->read('previous_url')));
}
?>
  
    <div class="checkbox remember">
    <?php
    		   echo $form->input('remember_me', array('before' => '', 'after' => '', 'label' => __('Remember me', true), 'type' => 'checkbox'));
    ?>
    </div>

</div>
                  <?php echo $this->Form->submit(__('Sign In', true), array('class'=>'btn btn-primary')); ?>

                  </fieldset>
                  <?php echo $form->end();?>

    <br />
    <?php echo $html->link(__("Can't remember my password?", true),array('controller' => 'users', 'action' => 'password_forgotten'))?>
    <br /><br />

<?php } ?>

        </div>
      </div>


