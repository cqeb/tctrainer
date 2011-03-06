
                   <h1><?php __('Subscribe TriCoreTraining-memberships'); ?></h1>

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
    <td><?php __('Magazine'); ?> - <?php __('Blog'); ?></td>
    <td style="text-align:center">X</td>
    <td style="text-align:center">X</td>
</tr>
<tr>
    <td><?php __('Community'); ?></td>
    <td style="text-align:center">X</td>
    <td style="text-align:center">X</td>
</tr>
<tr class="odd">
    <td><?php __('Settings'); ?></td>
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
    <td><?php __('Statistics'); ?></td>
    <td style="text-align:center">X</td>
    <td style="text-align:center">X</td>
</tr>
<tr class="odd">
    <td><b><?php __('Interactive training plan'); ?></b></td>
    <td style="text-align:center"><b>X</b></td>
    <td style="text-align:center"><b><?php __('No'); ?></b></td>
</tr>
<tr>
    <td colspan="3">&nbsp;</td>
</tr>
<?php

$currency = 'EUR';
$userobject = null;
$price_array = $unitcalc->get_prices( null, $currency, $userobject );
$price_array_split = $price_array[$currency]['total'];
$price_month_array_split = $price_array[$currency]['month'];

?>
<tr>
    <td colspan="3">
    <!a rel="facebox[.bolder]" href="<?php echo Configure::read('App.serverUrl'); ?>/payments/initiate/t:1">
    <b>1 <?php __('month(s)'); __('TriCoreTraining.com plans'); ?></b><br />
    <?php __('for ONLY'); ?> <?php echo $price_array_split[0]; echo ' ' . $currency; ?>   
    </a>
    </td>
</tr>
<tr class="odd">
    <td colspan="3">
    <!a rel="facebox[.bolder]" href="<?php echo Configure::read('App.serverUrl'); ?>/payments/initiate/t:3">
    <b>3 <?php __('month(s)'); __('TriCoreTraining.com plans'); ?></b><br />
    <?php __('for ONLY'); ?> <?php echo $price_array_split[1]; echo ' ' . $currency; ?>  
    </a>
    </td>
</tr>
<tr>
    <td colspan="3">
    <!a rel="facebox[.bolder]" href="<?php echo Configure::read('App.serverUrl'); ?>/payments/initiate/t:6">
    <b>6 <?php __('month(s)'); __('TriCoreTraining.com plans'); ?></b><br />
    <?php __('for ONLY'); ?> <?php echo $price_array_split[2]; echo ' ' . $currency; ?>  
    </a>
    </td>
</tr>
<tr class="odd">
    <td colspan="3">
    <!a rel="facebox[.bolder]" href="<?php echo Configure::read('App.serverUrl'); ?>/payments/initiate/t:12">
    <b>12 <?php __('month(s)'); __('TriCoreTraining.com plans'); ?></b><br />
    <?php __('for ONLY'); ?> <?php echo $price_array_split[3]; echo ' ' . $currency; ?>  
    </a>
    </td>
</tr>
</tbody>
</table>

<?php

__('Signup FREE and get training plans for triathlon, biking and running for 1 month FREE. Then you can upgrade to PREMIUM for less than 3 coffees a month!');

?>
<br /><br />
<a href="/trainer/users/register"><button onClick="javascript:top.location.href='/trainer/users/register' value="<?php __('Signup FREE'); ?>"><?php __('Signup FREE'); ?></button></a>

<!--

<img alt="<?php __('PAYPAL - secure payment solutions'); ?>" src="<?php echo Configure::read('App.serverUrl'); ?>/img/paypal_logo.gif" />

<?php __('What is PAYPAL? It is a reputable and well-known payment solution provider (owned by e-Bay) and provides creditcard/payment
solutions for websites. You send your necessary confidential payment information via a secure connection (128-bit encrypted SSL-connection)
and provide these confidential data only to PAYPAL and NOT to us (we only receive your payment).'); ?>
<br /><br />
<?php __('Your trial period will be added if you subscribe to a PREMIUM membership.'); ?>
<br />
-->

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