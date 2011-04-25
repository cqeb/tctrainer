
                   <h1><?php __('Settings'); ?></h1>

                   <?php echo $this->element('js_error'); ?>

                   <?php echo $form->create('User', array('action' => 'edit_address')); ?>
                   <fieldset>
                   <legend><?php __('Fill in your personal information'); ?></legend>

                   <?php if ($session->check('Message.flash')) { ?>
                   <div class="<?php echo $statusbox; ?>">
                   <?php $session->flash(); ?>
                   </div><br />
                   <?php } ?>

<?php

echo $form->hidden('id');

?>

<hr />
<h3><?php __('Contact data'); ?></h3>

<?php

echo $form->input('address',
     array(
     'before' => '',
     'after' => '',
     'between' => '',
     'class' => 'required',
     'maxLength' => 255,
     'label' => __('Address', true)
));

echo $form->input('zip',
     array(
     'before' => '',
     'after' => '',
     'between' => '',
     'class' => 'required',
     'maxLength' => 255,
     'label' => __('ZIP', true)
));

echo $form->input('city',
     array(
     'before' => '',
     'after' => '',
     'between' => '',
     'class' => 'required',
     'maxLength' => 255,
     'label' => __('City', true)
));

echo $form->input('country',
     array(
     'legend' => false,
     'label' => __('Country', true),
     'before' => '',
     'after' => '',
     'between' => '',
     'class' => 'required',     
     'options' => $countries
));

echo $form->input('phonemobile',
     array(
     'before' => '',
     'after' => '',
     'between' => '',
     'class' => 'required',     
     'maxLength' => 255,
     'label' => __('Phone', true)
));

/** not finished **/

echo $form->hidden('id');
echo $form->hidden('emailcheck');
//echo $form->hidden('passwordcheck');

?>
<br /><br />

<?php

echo $form->submit(__('Save', true));

?>
                 <br />

                 </fieldset>

<?php
      echo $form->end();
?>

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