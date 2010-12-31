<?php $currency = 'EUR'; ?>

                   <h1><?php __('TriCoreTraining features'); ?></h1>

                   <?php echo $this->element('js_error'); ?>

                   <?php //echo $form->create('User', array('action' => 'edit_metric', 'type' => 'file')); ?>
                   <fieldset>
                   <legend><?php __('Gain speed, loose weight'); ?></legend>

                   <?php if ($session->check('Message.flash')) { ?>
                   <div class="<?php echo $statusbox; ?>">
                   <?php $session->flash(); ?>
                   </div><br />
                   <?php } ?>

<table summary="<?php __('All possible subscriptions'); ?>">
<!--<caption><?php __('SUBSCRIPTIONS'); ?></caption>-->
<colgroup>
          <col class="colA">
          <col class="colB">
          <col class="colC">
</colgroup>
<thead>
<!--
<tr>
    <th colspan="3" class="table-head"><?php __('SUBSCRIPTIONS'); ?></th>
</tr>
-->
<tr>
    <th><?php __('Features'); ?></th>
    <th style="width:25%"><?php __('Premium'); ?></th>
    <th style="width:25%"><?php __('Free'); ?></th>
</tr>
</thead>
<tbody>
<tr class="odd">
    <td><?php __('Magazine'); ?></td>
    <td style="text-align:center">X</td>
    <td style="text-align:center">X</td>
</tr>
<tr>
    <td><?php __('Community'); ?></td>
    <td style="text-align:center">X</td>
    <td style="text-align:center">X</td>
</tr>
<tr class="odd">
    <td><?php __('Change profile'); ?></td>
    <td style="text-align:center">X</td>
    <td style="text-align:center">X</td>
</tr>
<tr>
    <td><?php __('Training logbook'); ?></td>
    <td style="text-align:center">X</td>
    <td style="text-align:center">X</td>
</tr>
<tr class="odd">
    <td><?php __('Define competitions'); ?></td>
    <td style="text-align:center">X</td>
    <td style="text-align:center">X</td>
</tr>
<tr>
    <td><?php __('Training statistics'); ?></td>
    <td style="text-align:center">X</td>
    <td style="text-align:center">X</td>
</tr>
<tr class="odd">
    <td><?php __('Training schedule'); ?></td>
    <td style="text-align:center">X</td>
    <td style="text-align:center"><b><?php __('No'); ?></b></td>
</tr>
<!--
<tfoot>
<tr class="total">
    <td colspan="3">&nbsp;</td>
</tr>
</tfoot>
-->
<tr>
    <td colspan="3">&nbsp;</td>
</tr>
<tr>
    <td colspan="3">
    <a rel="facebox[.bolder]" href="<?php echo Configure::read('App.serverUrl'); ?>/payments/initiate/t:1">
    <b>1<?php __('-month(s)'); __('TriCoreTraining.com plans'); ?></b><br />
    <?php __('for ONLY'); ?> 9.90 <?php echo $currency; ?>
    </a>
    </td>
</tr>
<tr class="odd">
    <td colspan="3">
    <a rel="facebox[.bolder]" href="<?php echo Configure::read('App.serverUrl'); ?>/payments/initiate/t:3">
    <b>3<?php __('-month(s)'); __('TriCoreTraining.com plans'); ?></b><br />
    <?php __('for ONLY'); ?> 27.00 <?php echo $currency; ?> (9.00 <?php echo $currency; ?> <?php __('per month'); ?>)
    </a>
    </td>
</tr>
<tr>
    <td colspan="3">
    <a rel="facebox[.bolder]" href="<?php echo Configure::read('App.serverUrl'); ?>/payments/initiate/t:6">
    <b>6<?php __('-month(s)'); __('TriCoreTraining.com plans'); ?></b><br />
    <?php __('for ONLY'); ?> 51.00 <?php echo $currency; ?> (8.50 EUR <?php __('per month'); ?>)
    </a>
    </td>
</tr>
<tr class="odd">
    <td colspan="3">
    <a rel="facebox[.bolder]" href="<?php echo Configure::read('App.serverUrl'); ?>/payments/initiate/t:12">
    <b>12<?php __('-month(s)'); __('TriCoreTraining.com plans'); ?></b><br />
    <?php __('for ONLY'); ?> 96.00 <?php echo $currency; ?> (8.00 <?php echo $currency; ?> <?php __('per month'); ?>)
    </a>
    </td>
</tr>
</tbody>
</table>

<img alt="<?php __('PAYPAL - secure payment solutions'); ?>" src="<?php echo Configure::read('App.serverUrl'); ?>/img/paypal_logo.gif" />
<br />
<?php __('All payments will be processed by PAYPAL - a reputable and well-known payment solution provider (owned by e-Bay). Your payment will be processed via a SSL-secured connection and we will not receive your confidential payment information (only the payment itself).'); ?>
<br /><br />

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