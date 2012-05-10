
                   <h1><?php __('Coupon'); ?></h1>

                   <?php echo $this->element('js_error'); ?>

                   <?php echo $form->create('Start', array('action' => 'coupon')); ?>
                   <fieldset>
                   <legend><?php __('Get rid of your weight and gain speed.'); ?></legend>

                   <?php if ($session->read('flash')) { ?>
                   <div class="<?php echo $statusbox; ?>">
                   <?php echo $session->read('flash'); $session->delete('flash'); ?>
                   </div><br />
                   <?php } ?>

<?php __('You received your coupon code from'); ?> <b><?php if ( isset( $partner ) && $partner != '' ) echo $partner; else __('our partner',true); ?></b>.
<?php __('Please enter your code here and then register yourself. We will check your coupon code and then prolong your PREMIUM membership.'); ?>

<br /><br />

<?php

echo $form->input('coupon',
     array(
     'before' => '',
     'after' => '',
     'between' => '',
     'maxLength' => 7,
     'error' => array( 
             'notempty' => __('Enter your coupon code',true)
     ),
     'label' => __('Coupon Code', true)
));

echo $form->hidden('partner');

echo $form->submit(__('Save', true));

?>
                 <br />

                 </fieldset>

<?php
      echo $form->end();

      $this->js_addon = <<<EOE
<script type="text/javascript">

/** initiate JQuery **/

\$(document).ready(function() {

});

</script>

EOE;

?>