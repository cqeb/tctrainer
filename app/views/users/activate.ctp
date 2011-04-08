
                   <h1><?php __('Enter the World of TriCoreTraining.com'); ?></h1>

                   <?php echo $this->element('js_error'); ?>

                   <div class="messagebox">
                   <?php __('Your account is activated now!'); ?>
                   </div><br />

                   <?php //echo $form->create('User', array('action' => 'login'));?>

                   <fieldset>
                   <legend><?php __('Log in and start forming your body'); ?></legend>

                   <?php if ($session->check('Message.flash')) { ?>
                   <div id="statusbox ok">
                   <?php $session->flash(); ?>
                   </div><br />
                   <?php } ?>

                   <?php echo $html->link(__('Log into the world of TriCoreTraining.', true), array('controller' => 'users', 'action' => 'login')); ?>
                   
                   </fieldset>

<?php

      $this->js_addon = <<<EOE
<script type="text/javascript">

        // facebox box
        //$('a[rel*=facebox]').facebox();

});

</script>

EOE;

?>