
                  <h1><?php __('Upload Selected Garmin Workouts'); ?></h1>

                  <?php echo $this->element('js_error'); ?>

                  <?php echo $form->create('Trainingstatistic', array('action' => 'garmin_import')); ?>
                  <fieldset>
                  <legend></legend>

                  <?php if ($session->read('flash')) { ?>
                  <div class="<?php echo $statusbox; ?>"></div><br />
                  <?php } ?>

                  <?php __('You can import your workouts from http://connect.garmin.com/.'); ?>
                  <?php __('Upload them first, and then enter your garmin username and password. We do not save them!'); ?>

                  <br /><br />
<?php

echo $form->input('username',
     array(
     'before' => '',
     'after' => '',
     'between' => '',
     'maxLength' => 255,
     'class' => 'required',
/**
     'error' => array(
          'length' => __('Minimum of two characters',true), 
          'notempty' => __('Enter your firstname',true)
     ),
**/
     'label' => __('Garmin Connect Username', true)
));

echo $form->input('password',
     array(
     'before' => '',
     'after' => '',
     'between' => '',
     'maxLength' => 255,
     'class' => 'required',
/**
     'error' => array(
          'length' => __('Minimum of two characters',true), 
          'notempty' => __('Enter your firstname',true)
     ),
**/
     'label' => __('Garmin Connect Password', true)
));

echo $form->input('amount', array(
           'before' => '',
           'after' => '',
           'between' => '',
           'class' => 'required',
           /**'label' => __('Number of workouts to import', true)**/
           'options' => array(
                     '1' => 1,
                     '5' => 5,
                     '10' => 10,
                     '15' => 15,
                     '20' => 20,
                     '25' => 25
           )));

echo $form->submit(__('Get activities', true));

?>

    </fieldset>

    <?php echo $form->end(); ?>

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