
<?php echo $this->element('email/newsletter_header'); ?>

 <p><?php __('Hi'); ?> <?php echo $user['User']['firstname']; ?>,</p>

 <p><b><?php __('thanks for trusting TriCoreTraining.'); ?></b></p>

<p>

<b>TriCoreTraining</b><br />
<?php __('Acquired by'); ?> Klaus-M. Schremser GmbH,<br />
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

<p></p>
<br />
<img src="http://www.google-analytics.com/collect?v=1&tid=UA-116688964-1&cid=tct-2351&t=event&ec=email&ea=open&el=invoicemail&cs=tricoretrainingsystem&cm=email&cn=mailopens&cm1=1" />
<?php echo $this->element('email/newsletter_footer'); ?>
