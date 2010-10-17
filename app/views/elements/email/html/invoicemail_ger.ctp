<pre>
<div style="margin: 0px;" class="block" id="tables">

<table summary="TriCoreTraining.com Invoice">
<caption>TriCoreTraining.com Invoice No. <?php echo $invoice; ?></caption>
<colgroup>
          <col class="colA">
          <col class="colB">
          <col class="colC">
</colgroup>
<thead>
<tr>
    <th colspan="3" class="table-head">TriCoreTraining-Plan</th>
</tr>
<tr>
    <th>Product</th>
    <th>Interval</th>
    <th class="currency">Price</th>
</tr>
</thead>
<tfoot>
<!--
<tr>
    <th>Subtotal</th>
    <td></td>
    <th class="currency"><?php echo $currency . ' ' . $price; ?></th>
</tr>
-->
<tr class="total">
    <th>Total</th>
    <td></td>
    <th class="currency"><?php echo $currency . ' ' . $price; ?></th>
</tr>
</tfoot>
<tbody>
<tr class="odd">
    <th>Trainingplan</th>
    <td><?php echo $timeinterval; ?> month(s)</td>
    <td class="currency"><?php echo $currency . ' ' . $price; ?></td>
</tr>
<!--
<tr>
    <th>Dolor sit</th>
    <td>Nostrud exerci</td>
    <td class="currency">$75.00</td>
</tr>
<tr class="odd">
    <th>Nostrud exerci</th>
    <td>Lorem ipsum</td>
    <td class="currency">$200.00</td>
</tr>
<tr>
    <th>Lorem ipsum</th>
    <td>Dolor sit</td>
    <td class="currency">$64.00</td>
</tr>
<tr class="odd">
    <th>Dolor sit</th>
    <td>Nostrud exerci</td>
    <td class="currency">$36.00</td>
</tr>
-->
</tbody>
</table>

Old period: <?php echo $payed_from; ?> to <?php echo $payed_to; ?>

New period: <?php echo $payed_new_from; ?> to <?php echo $payed_new_to; ?>


Text for invoice .... TODO

</pre>
