
                   <h1><?php __('Send message'); ?></h1>

                   <?php echo $this->element('js_error'); ?>

                   <?php echo $form->create('User', array('action' => 'send_message')); ?>

                   <fieldset>
                   <legend><?php __('Send messages to specific users'); ?></legend>

                   <?php if ($session->check('Message.flash')) { ?>
                   <div class="<?php echo $statusbox; ?>">
                   <?php $session->flash(); ?>
                   </div><br />
                   <?php } ?>

<?php

echo $form->input('subject',
     array(
     'before' => '',
     'after' => '',
     'between' => '',
     'maxLength' => 255,
     'class' => 'required',
     'label' => __('Subject', true)
));

?>


<?php
__('Message');

echo $form->textarea('message',
                  array(
                  'rows' => '5',
                  'cols' => '45'
           ));


echo "<br /><br />";
echo $form->submit(__('Send', true));
echo "<br />";

?>
                 </fieldset>

<?php
      echo $form->end();
?>

<?php

      $this->js_addon = <<<EOE
<script type="text/javascript">
/** initiate JQuery **/
\$(document).ready(function() {

}
</script>
EOE;

?>