      <div class="panel panel-default" id="forms">
        <div class="panel-heading"><h1><?php __('Manage your plan!'); ?></h1></div>
        
        <div class="panel-body">

                   <?php echo $this->element('js_error'); ?>

                   <div class="alert">
                   <?php __('Your account is activated now!'); ?>
                   </div><br />

                   <fieldset>
                   <legend><?php __('Sign in and start forming your body'); ?></legend>

                   <?php if ($session->read('flash')) { ?>
                   <div id="alert alert-success">
                   <?php echo $session->read('flash'); $session->delete('flash'); ?>
                   </div><br />
                   <?php } ?>

                   <?php echo $html->link(__('It\'s time to start your training with a goal.', true), array('controller' => 'users', 'action' => 'login'), array('class' => 'btn btn-success')); ?>
                   
                   <br /><br />
                   </fieldset>

        </div>
      </div>

<?php

      $this->js_addon = <<<EOE
<script type="text/javascript">

        // facebox box
        //$('a[rel*=facebox]').facebox();

});

</script>

EOE;

?>