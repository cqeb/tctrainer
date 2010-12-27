
                   <h1><?php __('Enter the World of TriCoreTraining.com'); ?></h1>

                   <?php echo $this->element('js_error'); ?>

                   <div class="messagebox">
                   <?php __("You HAVE TO agree to our terms of service! That's the way you protect our rights :)."); ?>
                   </div><br />

                   <?php //echo $form->create('User', array('action' => 'login'));?>

                   <fieldset>
                   <legend><?php __('Then start forming your body'); ?></legend>

<!--<div class="messagebox" style="overflow:auto; width: 420px; height: 100px;">-->
<span style="font-size: 12px;white-space: pre;">
<?php echo $this->element('tos'); ?>
</span>
<!--</div>-->

                   </fieldset>

<?php

      $this->js_addon = <<<EOE
<script type="text/javascript">

        // facebox box
        $('a[rel*=facebox]').facebox();

});

</script>

EOE;

?>