
                   <h1><?php __('Payments - Invoice'); ?></h1>

                   <?php echo $this->element('js_error'); ?>

                   <?php if ($session->check('Message.flash')) { ?>
                   <div class="messagebox">
                   <?php $session->flash(); ?>
                   </div><br />
                   <?php } ?>

                   <?php if ( $error ) { ?>
                   <div class="errorbox">
                   <?php echo $error; ?>
                   </div><br />
                   <?php } ?>

                   <?php //echo $form->create('Payment', array('action' => 'initiate')); ?>
                   <fieldset>
                   <legend><?php __('Invoice Details'); ?></legend>

                   <b>TriCoreTraining - <?php __('Association'); ?></b><br />
                   Gonzagagasse 11/25<br />
                   A-1010 <?php __('Vienna, Austria'); ?><br />
                   <br /><br />
                   <b><?php echo $userobject['firstname'] . ' ' . $userobject['lastname']; ?></b><br />
                   <?php echo $userobject['address']; ?><br />
                   <?php echo $userobject['zip'] . '-' . $userobject['city'] . ', ' . $userobject['country']; ?><br />
                   <br /><br />
                   
                   <div style="margin: 0px;" class="block" id="tables">
                    
                   <table summary="<?php __('TriCoreTraining.com Invoice'); ?>">
                   <caption><?php __('TriCoreTraining.com Invoice') ?> <?php __('No.'); ?> <?php echo $data['invoice']; ?></caption>
                   <!--
                   <colgroup>
                              <col class="colA">
                              <col class="colB">
                              <col class="colC">
                   </colgroup>
                   -->
                   <thead>
                   <tr>
                        <th colspan="3" class="table-head"><?php __('TriCoreTraining-Plan'); ?></th>
                   </tr>
                   <tr>
                        <th><?php __('Product'); ?></th>
                        <th><?php __('Interval'); ?></th>
                        <th class="currency"><?php __('Price'); ?></th>
                   </tr>
                   </thead>
                   <tfoot>
                   <!--
                   <tr>
                        <th><?php __('Subtotal'); ?></th>
                        <td></td>
                        <th class="currency"><?php echo $currency . ' ' . $price; ?></th>
                   </tr>
                   -->
                   <tr class="total">
                        <th><?php __('Total'); ?></th>
                        <td></td>
                        <th class="currency"><?php echo $data['currency'] . ' ' . $data['price']; ?></th>
                   </tr>
                   </tfoot>
                   <tbody>
                   <tr class="odd">
                        <th><?php __('Trainingplan'); ?></th>
                        <td>
                        <?php echo $data['timeinterval']; ?> <?php __('month(s)'); ?><br />
                        <?php __('From'); ?> <?php echo $data['payed_from']; ?> <?php __('to'); ?> <?php echo $data['payed_to']; ?></td>
                        <td class="currency"><?php echo $data['currency'] . ' ' . $data['price']; ?></td>
                   </tr>
                   <tr>
                        <th></th>
                        <td><?php __('We are not allowed to charge VAT as an association.'); ?></td>
                   </tr>
                   </tbody>
                   </table>
                    
                   <?php echo $html->link(__('Back to list of payments',true),array('controller' => 'payments', 'action' => 'show_payments'))?>
                    
                   <br /><br />
                    
                   </div>
    
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