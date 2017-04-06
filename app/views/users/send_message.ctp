      <div class="panel panel-default" id="forms">
        <div class="panel-heading"><h1><?php __('Send message'); ?></h1></div>
        
        <div class="panel-body">

                   <?php echo $this->element('js_error'); ?>

                   <?php echo $form->create('User', array('action' => 'send_message','class' => 'form-horizontal')); ?>

                   <fieldset>
                   <legend><?php __('Send messages to specific users'); ?></legend>

                   <?php if ($session->read('flash')) { ?>
                   <div class="<?php echo $statusbox; ?>">
                   <?php echo $session->read('flash'); $session->delete('flash'); ?>
                   </div><br />
                   <?php } ?>

<a href="/trainer/users/list_users">&raquo; <?php __('List users'); ?></a><br /><br />

<div class="form-group">
<?php

if ( isset( $users_to_send ) ) 
{
	
	echo "<ul>";
	for( $i = 0; $i < count( $users_to_send ); $i++ )
	{
		$dt = ($users_to_send[$i]['users']);
		echo "<li>&quot;" . $dt['firstname'] . ' ' . $dt['lastname'] . ' <b>(' . $dt['yourlanguage'] . ')</b> &lt;' . $dt['email'] . '&gt;</li>';		
	}
	echo "</ul>";
	
	echo $form->hidden('users_to_send', array('value' => serialize($users_to_send)));
}
?>
</div>
<div class="form-group">
<?php
if ( !isset( $noform ) )
{
	echo $form->input('subject',
	     array(
	     'before' => '',
	     'after' => '',
	     'between' => '',
	     'maxLength' => 255,
	     'class' => 'required form-control',
	     'label' => __('Subject', true)
	));

	__('Message');
	echo "<br />";
	
	echo $form->textarea('message',
	                  array(
	                  'rows' => '15',
	                  'cols' => '45'
	           ));
	
	
	echo "<br /><br />";
	echo $form->submit(__('Send', true),array('class' => 'btn btn-primary'));
	echo "<br />";
}

echo $form->hidden('submitted',array('value' => 1));

?>
</div>

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

}
</script>
EOE;

?>