      <div class="panel panel-default" id="forms">
        <div class="panel-heading"><h1><?php __('Settings'); ?></h1></div>
        
        <div class="panel-body">
                   
                   <?php echo $this->element('js_error'); ?>

                   <?php echo $form->create('User', array('action' => 'edit_user','class' => 'form-horizontal')); ?>
                   <fieldset>
                   <legend><?php __('User profile'); ?></legend>

                   <?php if ($session->read('flash')) { ?>
                   <div class="<?php echo $statusbox; ?>">
                   <?php echo $session->read('flash'); $session->delete('flash'); ?>
                   </div><br />
                   <?php } ?>

                   <?php echo $html->link(__('Back to list of users',true), '/users/list_users/', null) ?>
					         <br /><br />

<div class="form-group">

<?php

echo $form->hidden('id');

echo __('Firstname') . ': ' . $user['firstname'];
echo "<br /><br />";

echo __('Lastname') . ': ' . $user['lastname']; 
echo "<br /><br />";

echo __('Email') . ' <a href="mailto:' . $user['email'] . '">' . $user['email'] . '</a>';
echo "<br /><br />";
 
echo __('Created') . ': ' . $user['created']; 
echo "<br /><br />";

?>
</div>

<div class="form-group">
<?php

echo $form->input('paid_from',
     array(
     'class' => 'required form-control'
));
echo "<br /><br />";

?>
</div>

<div claas="form-group">
<?php
echo $form->input('paid_to',
     array(
     'class' => 'required form-control'
));
echo "<br /><br />";

?>
</div>

<div class="form-group">
<?php
echo $form->input('activated',
                  array(
                  'before' => __('Activated', true),
                  'after' => '',
                  'between' => '',
                  'class' => 'required ',
                  'label' => '',
                  'legend' => false,
                  'type' => 'checkbox',
                  'options' => array(
                            '1' => __('Yes',true),
                            '0' => __('No',true)
                  )
));

?>
</div>

<div class="form-group">
<?php
echo $form->input('deactivated',
                  array(
                  'before' => __('Deactivate user', true),
                  'after' => '',
                  'between' => '',
                  'class' => 'required ',
                  'label' => '',
                  'legend' => false,
                  'type' => 'checkbox',
                  'options' => array(
                            '1' => __('Yes',true),
                            '0' => __('No',true)
                  )
));
?>
</div>

<div class="form-group">
<?php
echo $form->input('canceled',
                  array(
                  'before' => __('Canceled', true),
                  'after' => '',
                  'between' => '',
                  'class' => 'required ',
                  'label' => '',
                  'legend' => false,
                  'type' => 'checkbox',
                  'options' => array(
                            '1' => __('Yes',true),
                            '0' => __('No',true)
                  )
));
?>
</div>

<div class="form-group">
<?php
echo $form->input('advanced_features',
                  array(
                  'before' => __('Beta', true),
                  'after' => '',
                  'between' => '',
                  'class' => 'required ',
                  'label' => '',
                  'legend' => false,
                  'type' => 'checkbox',
                  'options' => array(
                            '1' => __('Yes',true),
                            '0' => __('No',true)
                  )
));

?>
</div>

<div class="form-group">
<?php
echo $form->input('notifications',
                  array(
                  'before' => __('Stop notifying', true),
                  'after' => '',
                  'between' => '',
                  'class' => 'required ',
                  'label' => '',
                  'legend' => false,
                  'type' => 'checkbox',
                  'options' => array(
                            '1' => __('Yes',true),
                            '0' => __('No',true)
                  )
));

?>
</div>

<?php

/** not finished **/

echo $form->hidden('id');

?>
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

/** initiate JQuery **/

\$(document).ready(function() {

        // facebox box
        //\$('a[rel*=facebox]').facebox();

});

</script>
EOE;

?>