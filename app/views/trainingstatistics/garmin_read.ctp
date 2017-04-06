      <div class="panel panel-default" id="forms">
        <div class="panel-heading"><h1><?php __('Upload Selected Garmin Workouts'); ?></h1></div>
        
        <div class="panel-body">

                  <?php echo $this->element('js_error'); ?>

                  <?php echo $form->create('Trainingstatistic', array('action' => 'garmin_import','class' => 'form-horizontal')); ?>
                  <fieldset>
                  <legend></legend>

                  <?php if ($session->read('flash')) { ?>
                  <div class="<?php echo $statusbox; ?>"></div><br />
                  <?php } ?>

                  <?php __('You can import your workouts from http://connect.garmin.com/.'); ?>
                  <?php __('Upload them first, and then enter your garmin username and password. We do not save them!'); ?>

                  <br /><br />
                  <div style="color:red;">SORRY. NOT WORKING YET :(</div><br />

<div class="form-group">                  
<?php

echo $form->input('username',
     array(
     'before' => '',
     'after' => '',
     'between' => '',
     'maxLength' => 255,
     'class' => 'required form-control',
/**
     'error' => array(
          'length' => __('Minimum of two characters',true), 
          'notempty' => __('Enter your firstname',true)
     ),
**/
     'label' => __('Garmin Connect Username', true)
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
/**
     'error' => array(
          'length' => __('Minimum of two characters',true), 
          'notempty' => __('Enter your firstname',true)
     ),
**/
     'label' => __('Garmin Connect Password', true)
));
?>
</div>

<div class="form-group">
<?php 
echo $form->input('amount', array(
           'before' => '',
           'after' => '',
           'between' => '',
           'class' => 'required form-control',
           'default' => 5,
           /**'label' => __('Number of workouts to import', true)**/
           'options' => array(
                     '1' => 1,
                     '5' => 5,
                     '10' => 10,
                     '15' => 15,
                     '20' => 20,
                     '25' => 25
           )));

echo '<br />';

echo $form->submit(__('Get activities', true),array('class' => 'btn btn-primary'));

?>
</div>

    </fieldset>

    <?php echo $form->end(); ?>

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