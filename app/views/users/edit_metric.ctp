      <div class="panel panel-default" id="forms">
        <div class="panel-heading"><h1><?php __('Settings'); ?></h1></div>
        
        <div class="panel-body">

         <?php echo $this->element('js_error'); ?>

         <?php echo $form->create('User', array('action' => 'edit_metric', 'type' => 'file','class' => 'form-horizontal')); ?>
         <fieldset>
         <legend><?php __('Set your personal metrics'); ?></legend>

         <?php if ($session->read('flash')) { ?>
         <div class="<?php echo $statusbox; ?>">
         <?php echo $session->read('flash'); $session->delete('flash'); ?>
         </div><br />
         <?php } ?>

<div class="form-group">
<?php

echo $form->input('unit', array(
           'before' => '',
           'after' => '',
           'between' => '',
           'class' => 'required form-control',
           'options' => array(
                     'metric' => __('Metric (Kilometres, Kilograms, Centimeters)', true),
                     'imperial' => __('Imperial (Miles, Pounds, Feet)', true)
           )));
?>
</div>
<div class="form-group">
<?php

echo $form->input('unitdate', array(
           'before' => '',
           'after' => '',
           'class' => 'required form-control',
           'between' => '',
           'label' => __('Date format',true),
           'options' => array(
                     'ddmmyyyy' => __('DD.MM.YYYY', true),
                     'mmddyyyy' => __('MM.DD.YYYY', true),
                     'yyyymmdd' => __('YYYY-MM-DD', true)
           )));

echo $form->hidden('id');

?>
<br />
</div>
<?php

echo $form->submit(__('Save',true),array('class' => 'btn btn-primary'));

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

/** initiate JQuery **/

\$(document).ready(function() {

        // facebox box
        //$('a[rel*=facebox]').facebox();

});

</script>

EOE;

?>