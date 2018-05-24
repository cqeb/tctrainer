      <div class="panel panel-default" id="forms">
        <div class="panel-heading"><h1><?php __('Error (404) - file not found!'); ?></h1></div>
        
        <div class="panel-body">

             <?php echo $this->element('js_error'); ?>

             <fieldset>
             <legend><?php __('We are SOOOOORRRY.'); ?></legend>

             <div class="alert alert-danger">
             <?php __('Mysteries of the universe - where did this page go? Who knows ... '); ?>
             </div><br />
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