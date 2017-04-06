      <div class="panel panel-default" id="forms">
        <div class="panel-heading"><h1><?php __('Settings'); ?></h1></div>
        
        <div class="panel-body">

         <?php echo $this->element('js_error'); ?>

         <?php echo $form->create('User', array('action' => 'edit_address', 'class' => 'form-horizontal')); ?>
         <fieldset>
         <legend><?php __('Fill in your personal information'); ?></legend>

         <?php if ($session->read('flash')) { ?>
         <div class="<?php echo $statusbox; ?>">
         <?php echo $session->read('flash'); $session->delete('flash'); ?>
         </div><br />
         <?php } ?>


<?php

echo $form->hidden('id');

?>

<hr />

<h3><?php __('Contact data'); ?></h3>

<div class="form-group">
<?php

echo $form->input('address',
     array(
     'before' => '',
     'after' => '',
     'between' => '',
     'class' => 'required form-control',
     'maxLength' => 255,
     'label' => __('Address', true)
));

?>
</div>
<div class="form-group">
<?php
echo $form->input('zip',
     array(
     'before' => '',
     'after' => '',
     'between' => '',
     'class' => 'required form-control',
     'maxLength' => 255,
     'label' => __('ZIP', true)
));
?>
</div>
<div class="form-group">
<?php
echo $form->input('city',
     array(
     'before' => '',
     'after' => '',
     'between' => '',
     'class' => 'required form-control',
     'maxLength' => 255,
     'label' => __('City', true)
));
?>
</div>
<div class="form-group">
<?php
echo $form->input('country',
     array(
     'legend' => false,
     'label' => __('Country', true),
     'before' => '',
     'after' => '',
     'between' => '',
     'class' => 'required form-control',     
     'options' => $countries
));
?>
</div>
<div class="form-group">
<?php
echo $form->input('phonemobile',
     array(
     'before' => '',
     'after' => '',
     'between' => '',
     'class' => 'required form-control',     
     'maxLength' => 255,
     'label' => __('Phone', true)
));

/** not finished **/

echo $form->hidden('id');
echo $form->hidden('emailcheck');
//echo $form->hidden('passwordcheck');

?>
</div>
<br /><br />

<?php

echo $form->submit(__('Save', true),array('class' => 'btn btn-primary'));

?>
                 <br />

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