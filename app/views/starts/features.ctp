
                   <h1><?php __('TriCoreTraining Features'); ?></h1>

                   <?php echo $this->element('js_error'); ?>

                   <fieldset>
                   <legend><?php __('Gain speed, lose weight'); ?></legend>

                   <?php if ($session->read('flash')) { ?>
                   <div class="<?php echo $statusbox; ?>">
                   <?php echo $session->read('flash'); $session->delete('flash'); ?>
                   </div><br />
                   <?php } ?>


<table summary="<?php __('All possible subscriptions'); ?>">
<colgroup>
          <col class="colA">
          <col class="colB">
          <col class="colC">
</colgroup>
<thead>
<tr>
    <th><?php __('Features'); ?></th>
    <th style="width:25%"><?php __('Free'); ?></th>
</tr>
</thead>
<tbody>
<tr class="odd">
    <td><b><?php __('Interactive training plan'); ?></b></td>
    <td style="text-align:center"><b>X</b></td>
</tr>
<tr>
    <td><?php __('Community'); ?></td>
    <td style="text-align:center">X</td>
</tr>
<tr class="odd">
    <td><?php __('Settings'); ?></td>
    <td style="text-align:center">X</td>
</tr>
<tr>
    <td><?php __('Training logbook'); ?></td>
    <td style="text-align:center">X</td>
</tr>
<tr class="odd">
    <td><?php __('Define competitions'); ?></td>
    <td style="text-align:center">X</td>
</tr>
<tr>
    <td><?php __('Statistics'); ?></td>
    <td style="text-align:center">X</td>
</tr>
<tr class="odd">
    <td><?php __('Blog'); ?></td>
    <td style="text-align:center">X</td>
</tr>
<tr>
    <td colspan="2">&nbsp;</td>
</tr>
<!--
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
-->

</tbody>
</table>

<?php

//__('Signup FREE and get training plans for triathlon, biking and running for 1 month FREE. Then you can upgrade to PREMIUM for less than 3 coffees a month!');
__('Signup and get your training plans for triathlon, biking and running for FREE.');

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
        //$('a[rel*=facebox]').facebox();

});

</script>

EOE;

?>