      <div class="panel panel-default" id="forms">
        <div class="panel-heading"><h1><?php __('Signup finished');?></h1></div>
        
        <div class="panel-body">

                   <?php echo $this->element('js_error'); ?>

                   <?php echo $form->create('User', array('action' => 'add_step3', 'class' => 'form-horizontal')); ?>

                   <fieldset>
                   <legend><?php __('Thank your for signing up on TriCoreTraining.'); ?></legend>

                    <?php if ( $session->read('flash') ) { ?>
                    <div class="alert alert-success">
                    <?php echo $session->read('flash'); $session->delete('flash');  ?>
                    </div>
                    <br />
                    <?php } ?>

<div class="form-group">
<?php
                   if ( $smtperrors != '' )
                     echo '<div class="alert alert-danger">' . $smtperrors . '</div>';
?>
<img alt="<?php __('Activate your account!'); ?>" src="/trainer/img/alert.png" />
                   <b><?php __('PLEASE do not forget to activate your account!'); ?></b><br /><br />
                   <i><?php __('If you can\'t find it, maybe our welcome email landed in your SPAM folder'); ?></i> 
                   <br /><br />
                   <?php __('Thank you and happy training!'); ?>
                   <br /><br />
                   <!--<b><?php __('Your FREE membership is valid from'); ?> <?php echo $paid_from; ?> <?php __('to'); ?> <?php echo $paid_to; ?>.</b>-->

                   <?php if ( $_SERVER['HTTP_HOST'] == LOCALHOST ) { ?>
                   <br /><br />
                   For DEBUGGING (only localhost):
                   <br />
                   <?php echo $html->link(__('Activate', true), '/users/activate/transaction_id:' . $transaction_id . '/'); ?>
                  <br />
                  <?php } ?>
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

</script>

EOE;

?>