
                   <h1><?php __('Registration finished');?></h1>

                   <?php echo $this->element('js_error'); ?>

                   <?php echo $form->create('User', array('action' => 'add_step3')); ?>

                   <fieldset>
                   <legend><?php __('Thank your for registering at TriCoreTraining.com.'); ?></legend>

                    <?php if ($session->check('Message.flash')) { ?>
                    <div class="statusbox ok">
                    <?php $session->flash(); ?>
                    </div>
                    <br />
                    <?php } ?>

<?php
                   if ( $smtperrors != '' )
                     // never tested
                     echo '<div class="errormessage">' . $smtperrors . '</div>';
?>

                   <?php __('PLEASE do not forget to activate your account! Thank you and happy training!'); ?>
                   <br /><br />
                   <b><?php __('Your FREE membership is valid from'); ?> <?php echo $payed_from; ?> <?php __('to'); ?> <?php echo $payed_to; ?>.</b>

                   <?php if ( $_SERVER['HTTP_HOST'] == 'localhost' ) { ?>
                   <br /><br />
                   For DEBUGGING (only localhost):
                   <br />

<?php

echo $html->link(__('Activate', true), array('controller' => 'users', 'action' => 'activate', 'transaction_id' => $transaction_id));

?>
                  <br />
                  <?php } ?>
                  
                  </fieldset>

<?php
      echo $form->end();
?>

<?php

      $this->js_addon = <<<EOE
<script type="text/javascript">

        // facebox box
        $('a[rel*=facebox]').facebox();

});

</script>

EOE;

?>