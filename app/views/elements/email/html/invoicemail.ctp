
<?php echo $this->element('email/newsletter_header'); ?>

 <table cellspacing="0" cellpadding="4" bgcolor="#FFAE00" width="100%">
    <tr>
       <td>
          <h2><?php __('Hello'); ?> <?php echo $user['User']['firstname']; ?>,</h2>
       </td>
    </tr>
 </table>

 <p><i><?php __('thanks for your trust in TriCoreTraining.com.'); ?></i></p>

<p>
<div style="margin: 0px;" class="block" id="tables">

<table summary="TriCoreTraining.com <?php __('Invoice'); ?>">
<caption>TriCoreTraining.com <?php __('Invoice'); ?> <?php __('No.'); ?> <?php echo $invoice; ?></caption>
<colgroup>
          <col class="colA">
          <col class="colB">
          <col class="colC">
</colgroup>
<thead>
<tr>
    <th colspan="3" class="table-head">TriCoreTraining-<?php __('plan'); ?></th>
</tr>
<tr>
    <th><?php __('Product'); ?></th>
    <th><?php __('Interval'); ?></th>
    <th class="currency"><?php __('Price'); ?></th>
</tr>
</thead>
<tfoot>
<tr class="total">
    <th><?php __('Total'); ?></th>
    <td></td>
    <th class="currency"><?php echo $currency . ' ' . $price; ?></th>
</tr>
</tfoot>
<tbody>
<tr class="odd">
    <th><?php __('Trainingplan'); ?></th>
    <td><?php echo $timeinterval; ?> <?php __('month(s)'); ?></td>
    <td class="currency"><?php echo $currency . ' ' . $price; ?></td>
</tr>
</tbody>
</table>
<br /><br />
<?php __('Previous period:'); ?> <?php echo $payed_from; ?> <?php __('to'); ?> <?php echo $payed_to; ?><br />
<?php __('New period:'); ?> <?php echo $payed_new_from; ?> <?php __('to'); ?> <?php echo $payed_new_to; ?><br />
</p>
 
 <!--<p class="more"><?php __('Please'); ?> <a href="<?php echo Configure::read('App.hostUrl'); echo Configure::read('App.serverUrl'); ?>/users/<?php echo $transaction_id?>"><?php __('Continue to train.'); ?></a></p>-->

 <p><?php __('Yours, Clemens'); ?></p>
 <br />

<?php echo $this->element('email/newsletter_footer'); ?>
