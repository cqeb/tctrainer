
                   <h1><?php __('Subscribe triplans'); ?></h1>

                   <?php echo $this->element('js_error'); ?>

                   <?php echo $form->create('Payment', array('action' => 'unsubscribe_triplans')); ?>
                   <fieldset>
                   <legend><?php __('Gain speed, loose weight'); ?></legend>

                   <?php if ($session->check('Message.flash')) { ?>
                   <div class="<?php echo $statusbox; ?>">
                   <?php $session->flash(); ?>
                   </div><br />
                   <?php } ?>

                   <div class="okbox">
                   <?php __('Your current membership is valid from'); echo ' ' . $payed_from . ' '; __('to'); echo ' ' . $payed_to; ?>.
                   <?php __("You're a"); echo ' '; if ( $pay_member == 'freemember' ) echo __('FREE member'); else echo __('PREMIUM member'); ?>.
                   </div><br />
                   
                   <p>
                   <b><?php echo __('BEFORE you cancel, please tell us here why you want to cancel or get in', true) . ' <a href="mailto:support@tricoretraining.com">' . __('contact with us', true) . '</a> - ' . __('we want to make you HAPPY again!', true); ?></b>
                   </p>

<?php
                   echo $form->textarea('cancellation_reason',
                   array(
                         'rows' => '10',
                         'cols' => '45'
                   ));
                   echo $form->hidden('canceled');
?>
                   <br /><br />
                   <?php __('You will be redirected to Paypal.com and have to unsubscribe there. IMPORTANT! You cancel all payments in the future. Refunding of already payed fees is not possible. The current subscription will automatically end with'); ?><?php echo ' ' . $payed_to; ?>.
                   <br /><br />
<?php
                   $button_url = '/img/btn_unsubscribe_LG.gif';
                   
                   echo $form->submit($button_url);
?>

                   <?php if ( $_SERVER['HTTP_HOST'] == 'localhost' ) { ?>
                   <br /><br />
                   For Debugging (only localhost): PAYPAL - TEST
                   <a href="https://www.paypal.com/cgi-bin/webscr?cmd=_subscr-find&alias=payment@tricoretraining.com" _fcksavedurl="https://www.paypal.com/cgi-bin/webscr?cmd=_subscr-find&alias=payment@tricoretraining.com"><img border="0" src="https://www.paypal.com/en_US/i/btn/btn_unsubscribe_LG.gif" /></a>
                   <br /><br />
                   <?php } ?> 
                   </fieldset>

<?php

                echo $form->end();
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