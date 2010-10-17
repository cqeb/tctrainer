
                   <h1><?php __('Secure Paypal Payment Notification'); ?></h1>

                   <?php echo $this->element('js_error'); ?>

                   <?php if ($session->check('Message.flash')) { ?>
                   <div class="messagebox">
                   <?php $session->flash(); ?>
                   </div><br />
                   <?php } ?>

                   <?php if ( $error != '' ) { ?>
                   <div class="errorbox">
                   <?php echo $error; ?>
                   </div><br />
                   <?php } ?>

                   <?php //echo $form->create('Payment', array('action' => 'initiate')); ?>
                   <fieldset>
                   <legend><?php __('Initiate Payment'); ?></legend>

                   </fieldset>

<?php
                   //echo $form->end();
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