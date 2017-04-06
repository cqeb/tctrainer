      <div class="panel panel-default" id="forms">
        <div class="panel-heading"><h1><?php __('Secure Paypal Payment Notification'); ?></h1></div>
        
        <div class="panel-body">

                   <?php echo $this->element('js_error'); ?>

                   <?php if ($session->read('flash')) { ?>
                   <div class="messagebox">
                   <?php echo $session->read('flash'); $session->delete('flash'); ?>
                   </div><br />
                   <?php } ?>

                   <?php if ( $error != '' ) { ?>
                   <div class="alert alert-danger">
                   <?php echo $error; ?>
                   </div><br />
                   <?php } ?>

                   <fieldset>
                   <legend><?php __('Initiate Payment'); ?></legend>

                   </fieldset>

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