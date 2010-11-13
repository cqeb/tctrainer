
                   <h1><?php __('Change profile'); ?></h1>

                   <?php echo $this->element('js_error'); ?>

                   <?php echo $form->create('User', array('action' => 'edit_metric', 'type' => 'file')); ?>
                   <fieldset>
                   <legend><?php __('Set your personal metrics'); ?></legend>

                   <?php if ($session->check('Message.flash')) { ?>
                   <div class="<?php echo $statusbox; ?>">
                   <?php $session->flash(); ?>
                   </div><br />
                   <?php } ?>
<?php

echo $form->input('unit', array(
           'before' => '',
           'after' => '',
           'between' => '',
           'class' => 'required',
           'options' => array(
                     'metric' => __('Metric (Kilometres, Kilograms, Centimeters)', true),
                     'imperial' => __('Imperial (Miles, Pounds, Feet)', true)
           )));


echo $form->input('unitdate', array(
           'before' => '',
           'after' => '',
           'class' => 'required',
           'between' => '',
           'label' => __('Date format',true),
           'options' => array(
                     'ddmmyyyy' => __('DD.MM.YYYY', true),
                     'mmddyyyy' => __('MM.DD.YYYY', true),
                     'yyyymmdd' => __('YYYY-MM-DD', true)
           )));

echo $form->input('yourlanguage', array(
           'before' => '',
           'after' => '',
           'between' => '',
           'class' => 'required',
           'label' => __('Your preferred language', true),
           'options' => array(
                      'ger' => __('German',true),
                      'eng' => __('English',true)
           )));

/** not finished **/
echo $form->hidden('id');

?>
<br />
<?php

echo $form->submit(__('Save',true));

?>
                 <br />

                 </fieldset>

<?php
      echo $form->end();
?>

<?php

      $this->js_addon = <<<EOE
<script type="text/javascript">

/** initiate JQuery **/

\$(document).ready(function() {

        // facebox box
        $('a[rel*=facebox]').facebox();

});

</script>

EOE;

?>