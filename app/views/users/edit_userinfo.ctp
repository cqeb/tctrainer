      <div class="panel panel-default" id="forms">
        <div class="panel-heading"><h1><?php __('Settings'); ?></h1></div>
        
        <div class="panel-body">

                   <?php echo $this->element('js_error'); ?>

                   <?php echo $form->create('User', array('action' => 'edit_userinfo','class' => 'form-horizontal')); ?>
                   <fieldset>
                   <legend><?php __('Fill in your personal information'); ?></legend>

                   <?php if ($session->read('flash')) { ?>
                   <div class="<?php echo $statusbox; ?>">
                   <?php echo $session->read('flash'); $session->delete('flash'); ?>
                   </div><br />
                   <?php } ?>

<div class="form-group">

<?php

echo $form->hidden('id');

echo $form->input('firstname',
     array(
     'before' => '',
     'after' => '',
     'between' => '',
     'maxLength' => 255,
     'class' => 'required form-control',
     'error' => array(
          'length' => __('Minimum of two characters',true), 
          'notempty' => __('Enter your firstname',true)
     ),
     'label' => __('Firstname', true)
));

?>
</div>

<div class="form-group">
<?php

echo $form->input('lastname',
     array(
     'before' => '',
     'after' => '',
     'between' => '',
     'class' => 'required form-control',
     'maxLength' => 255,
     'error' => array(
          'length' => __('Minimum of two characters',true), 
          'notempty' => __('Enter your lastname',true)
     ),
     'label' => __('Lastname', true)
));

?>
</div>

<div class="form-group">
<?php

echo $form->input('gender',
     array(
     'before' => '<label style="font-weight:bold;" class="gender" for="gender">' . __('Gender', true) . '</label>',
     'after' => '',
     'between' => '',
     'class' => 'required checkbox',
     'legend' => false,
     'default' => 'm',
     'type' => 'radio',
     'multiple' => true,
     'options' => array('m' => __('male', true), 'f' => __('female', true))
));

?>
</div>

<div class="form-group">
<?php

echo $form->input('email',
     array(
     'before' => '',
     'after' => '',
     'between' => '',
     'class' => 'required form-control',
     'maxLength' => 255,
     'label' => __('Email', true),
     'error' => array( 
        'notempty' => __('Enter your email', true)
     )
));

?>

<span id="usernameLoading"><img src="<?php echo Configure::read('App.serverUrl'); ?>/img/indicator.gif" alt="Ajax Indicator" /></span>
<span id="usernameResult"></span>

</div>

<div class="form-group">
<?php

echo $form->input('birthday',
     array(
     'before' => '',
     'after' => '',
     'between' => '',
     'class' => 'required form-control',
     'minYear' => '1930',
     'maxYear' => '1995',
     'label' => __('Birthday', true)
));


?>
</div>

<div class="form-group">
<?php

echo $form->input('notifications',
                  array(
                  'before' => __('Stop notifying me', true),
                  'after' => '',
                  'between' => '',
                  'class' => 'required',
                  'label' => '',
                  'legend' => false,
                  'type' => 'checkbox',
                  //'multiple' => false,
                  'options' => array(
                            '1' => __('Yes',true),
                            '0' => __('No',true)
                  )
));

?>
</div>

<div class="form-group">
<a name="recommendation"></a>
<?php

echo '<div class="alert alert-info">';
__('We would be very happy if you write a review (recommendation) about TriCoreTraining. Thank you.');
echo '</div>';
echo $form->textarea('myrecommendation',
                  array(
                  'rows' => '5',
                  'cols' => '45'
           ));


echo "<br />";

?>
</div>

<?php

if ( isset( $userobject ) ) {
?>
<div>
<b><?php __('My profile image'); ?> (<a target="_blank" href="http://www.gravatar.com">gravatar.com</a>)</b><br /><br />
<img width="69" height="69" alt="<?php echo $userobject['firstname'] . ' ' . $userobject['lastname']; ?>" src="http://0.gravatar.com/avatar/<?php echo md5( $userobject['email'] ); ?>?s=69&d=identicon" />
</div><br />
<?php
}

echo $form->submit(__('Save', true),array('class' => 'btn btn-primary'));

echo "<br />";

?>

                 </fieldset>

<?php
      echo $form->end();
?>
    </div>
  </div>

<?php

      $this->js_addon = <<<EOE
<script type="text/javascript">


function finishAjax(id, response) {
         \$('#usernameLoading').hide();
         \$('#'+id).html(unescape(response));
         \$('#'+id).fadeIn();
}

/** initiate JQuery **/

\$(document).ready(function() {

        // check email availability
        \$('#usernameLoading').hide();

	\$('#UserEmail').blur(function(){
                   \$('#usernameLoading').show();
                   \$.post("
EOE;
      $this->js_addon .= Configure::read('App.serverUrl');
      $this->js_addon .= <<<EOF
/users/check_email", {
                       checkuseremail: \$('#UserEmail').val(),
                       checkuserid: \$('#UserId').val()
                   }, function(response){
                       //\$('#usernameResult').fadeOut();
                       setTimeout("finishAjax('usernameResult', '"+escape(response)+"')", 400);
                   });
                return false;
	});

        // facebox box
        //\$('a[rel*=facebox]').facebox();

});

</script>
EOF;

?>