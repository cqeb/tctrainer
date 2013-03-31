
       <h1><?php __('Subscribe TriCoreTraining PREMIUM membership'); ?></h1>

       <?php echo $this->element('js_error'); ?>

       <?php //echo $form->create('User', array('action' => 'edit_metric', 'type' => 'file')); ?>
       <fieldset>
       <legend><?php __('Gain speed, lose weight'); ?></legend>

       <?php if ($session->read('flash')) { ?>
       <div class="<?php echo $statusbox; ?>">
       <?php echo $session->read('flash'); $session->delete('flash'); ?>
       </div><br />
       <?php } ?>

       <div class="statusbox ok">
       <?php echo __('Your current membership is valid from', true) . ' ' . $paid_from . ' ' . __('to', true) . ' ' . $paid_to; ?>.
       <?php __("You're a"); echo ' '; if ( $pay_member == 'freemember' ) echo __('FREE member'); else echo __('PREMIUM member'); ?>
       </div>

       <br />

<?php

if ( $pay_member == 'freemember' || $_SERVER['HTTP_HOST'] == 'localhost' )
{

?>
	
<table summary="<?php __('All possible subscriptions'); ?>">
<colgroup>
          <col class="colA">
          <col class="colB">
          <col class="colC">
</colgroup>
<thead>
<tr>
    <th colspan="3"><h2><?php __('Click to subscribe to a PREMIUM membership'); ?></h2></th>
</tr>
<?php

$price_array = $unitcalc->get_prices( null, $currency, $userobject );
$price_array_split = $price_array[$currency]['total'];
$price_month_array_split = $price_array[$currency]['month'];

$price1m[$currency] = $price_array_split[0];
$price1pm[$currency] = $price_month_array_split[0];
$price3m[$currency] = $price_array_split[1];
$price3pm[$currency] = $price_month_array_split[1];
$price6m[$currency] = $price_array_split[2];
$price6pm[$currency] = $price_month_array_split[2];
$price12m[$currency] = $price_array_split[3];
$price12pm[$currency] = $price_month_array_split[3];

?>
<tr>
    <td colspan="3">
    <a href="<?php echo Configure::read('App.serverUrl'); ?>/payments/initiate/t:1">
    <b>1 <?php __('month(s)'); __('TriCoreTraining.com plans'); ?></b><br />
    <?php __('for ONLY'); ?> <?php echo $price1m[$currency]; ?> <?php echo $currency; ?> 
    <?php if ( isset( $userobject['inviter'] ) && preg_match('/@/', $userobject['inviter'] ) ) echo '(30% ' . __('discount', true) . ')'; ?>
    </a>
    </td>
</tr>
<!--//
<tr class="odd">
    <td colspan="3">
    <a href="<?php echo Configure::read('App.serverUrl'); ?>/payments/initiate/t:3">
    <b>3 <?php __('month(s)'); __('TriCoreTraining.com plans'); ?></b><br />
    <?php __('for ONLY'); ?> <?php echo $price3m[$currency]; ?> <?php echo $currency; ?> (<?php echo $price3pm[$currency]; ?> <?php echo $currency; ?> <?php __('per month'); ?>)
    <?php if ( isset( $userobject['inviter'] ) && preg_match('/@/', $userobject['inviter'] ) ) echo '(30% ' . __('discount', true) . ')'; ?>
    </a>
    </td>
</tr>
<tr>
    <td colspan="3">
    <a href="<?php echo Configure::read('App.serverUrl'); ?>/payments/initiate/t:6">
    <b>6 <?php __('month(s)'); __('TriCoreTraining.com plans'); ?></b><br />
    <?php __('for ONLY'); ?> <?php echo $price6m[$currency]; ?> <?php echo $currency; ?> (<?php echo $price6pm[$currency]; ?> <?php echo $currency; ?> <?php __('per month'); ?>)
    <?php if ( isset( $userobject['inviter'] ) && preg_match('/@/', $userobject['inviter'] ) ) echo '(30% ' . __('discount', true) . ')'; ?>
    </a>
    </td>
</tr>
//-->
<tr class="odd">
    <td colspan="3">
    <a href="<?php echo Configure::read('App.serverUrl'); ?>/payments/initiate/t:12">
    <b>12 <?php __('month(s)'); __('TriCoreTraining.com plans'); ?></b><br />
    <?php __('for ONLY'); ?> <?php echo $price12m[$currency]; ?> <?php echo $currency; ?> (<?php echo $price12pm[$currency]; ?> <?php echo $currency; ?> <?php __('per month'); ?>)
    <?php if ( isset( $userobject['inviter'] ) && preg_match('/@/', $userobject['inviter'] ) ) echo '(30% ' . __('discount', true) . ')'; ?>
    </a>
    </td>
</tr>
</tbody>
</table>

<?php

}

?>
<table summary="<?php __('All possible subscriptions'); ?>">
<!--<caption><?php __('SUBSCRIPTIONS'); ?></caption>-->
<colgroup>
          <col class="colA">
          <col class="colB">
          <col class="colC">
</colgroup>
<thead>
<tr>
    <th colspan="3" class="table-head"><?php __('SUBSCRIPTIONS'); ?></th>
</tr>
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
</table>

<img alt="<?php __('PAYPAL - secure payment solutions'); ?>" src="<?php echo Configure::read('App.serverUrl'); ?>/img/paypal_logo.gif" />

<?php __('What is PAYPAL? It is a reputable and well-known payment solution provider (owned by e-Bay) and provides creditcard/payment
solutions for websites. You send your necessary confidential payment information via a secure connection (128-bit encrypted SSL-connection)
and provide these confidential data only to PAYPAL and NOT to us (we only receive your payment).'); ?>
<br /><br />
<a target="_blank" href="http://www.paypal.com">&raquo; Paypal-<?php __('Website'); ?> (www.paypal.com)</a>

<br /><br />

<?php __('Your trial period will be added if you subscribe to a PREMIUM membership.'); ?>
<br />

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
        //\$('a[rel*=facebox]').facebox();

});

</script>

EOE;

?>