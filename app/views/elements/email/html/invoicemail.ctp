
<?php echo $this->element('email/newsletter_header'); ?>

 <table cellspacing="0" cellpadding="4" bgcolor="#FFAE00" width="100%">
    <tr>
       <td>
          <h2><?php __('Hi'); ?> <?php echo $user['User']['firstname']; ?>,</h2>
       </td>
    </tr>
 </table>

 <p><i><?php __('thanks for trusting TriCoreTraining.'); ?></i></p>

<p>

<!--<div style="margin: 0px;" class="block" id="tables">-->

<b>TriCoreTraining</b><br />
Klaus-M. Schremser GmbH,<br />
Gruene Gasse 35,<br />
A-2351 Wiener Neudorf, <?php __('Austria'); ?><br />
https://tricoretraining.com<br />
<br /><br />
<b><?php echo $user['User']['firstname'] . ' ' . $user['User']['lastname']; ?></b><br />
<?php echo $user['User']['address']; ?><br />
<?php echo $user['User']['zip'] . '-' . $user['User']['city'] . ', ' . $user['User']['country']; ?>
<br /><br />

<table class="main" summary="TriCoreTraining <?php __('Invoice'); ?>">
<caption>
TriCoreTraining <?php __('Invoice'); ?> <?php __('No.'); ?> <?php echo $invoice; ?><br />
<?php __('Date'); echo ':'; ?> <?php echo $created; ?>
</caption>
<colgroup>
          <col class="colA">
          <col class="colB">
          <col class="colC">
</colgroup>
<thead>
<tr class="tab">
    <th colspan="3" class="table-head">TriCoreTraining <?php __('plan'); ?></th>
</tr>
<tr class="tab">
    <th class="tab"><?php __('Product'); ?></th>
    <th class="tab"><?php __('Interval'); ?></th>
    <th class="currency"><?php __('Price'); ?></th>
</tr>
</thead>
<tfoot>
<tr class="total">
    <th class="tab"><?php __('Total'); ?></th>
    <td class="tab"></td>
    <th class="currency"><?php echo $currency . ' ' . $price; ?></th>
</tr>
</tfoot>
<tbody>
<tr class="odd">
    <th class="tab"><?php __('Trainingplan'); ?></th>
    <td class="tab"><?php echo $timeinterval; ?> <?php __('month(s)'); ?></td>
    <td class="currency"><?php echo $currency . ' ' . $price; ?></td>
</tr>
</tbody>
</table>
<br /><br />
<?php __('Previous period:'); ?> <?php echo $paid_from; ?> <?php __('to'); ?> <?php echo $paid_to; ?><br />
<?php __('New period:'); ?> <?php echo $paid_new_from; ?> <?php __('to'); ?> <?php echo $paid_new_to; ?><br />
</p>
 
<!--<p class="more"><?php __('Please'); ?> <a href="<?php echo Configure::read('App.hostUrl'); echo Configure::read('App.serverUrl'); ?>/users/<?php echo $transaction_id?>"><?php __('Continue to train.'); ?></a></p>-->

<p><?php __('20% VAT included!'); ?></p>
<br />

<?php echo $this->element('email/newsletter_footer'); ?>
