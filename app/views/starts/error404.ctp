
                   <h1><?php __('Error (404) - file not found!'); ?></h1>

                   <?php echo $this->element('js_error'); ?>

                   <fieldset>
                   <legend><?php __('Gain speed, loose weight'); ?></legend>

                   <div class="statusbox error">
                   <?php __('Mysteries of the universe - where did this page go? Who knows ... '); ?>
                   </div><br />
                   </fieldset>

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