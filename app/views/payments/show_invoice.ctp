      <div class="panel panel-default" id="forms">
        <div class="panel-heading"><h1><?php __('Payments - Invoice'); ?></h1></div>
        
        <div class="panel-body">

             <?php echo $this->element('js_error'); ?>

             <?php if ($session->read('flash')) { ?>
             <div class="alert">
             <?php echo $session->read('flash'); $session->delete('flash'); ?>
             </div><br />
             <?php } ?>

             <?php if ( $error ) { ?>
             <div class="alert alert-danger">
             <?php echo $error; ?>
             </div><br />
             <?php } ?>

             <?php echo $form->create('Payment', array('action' => '#','class' => 'form-horizontal')); ?>
             <fieldset>
             <legend><?php __('Invoice Details'); ?></legend>

             <div class="form-group">
             <b>TriCoreTraining - <?php __('Club'); ?></b><br />
             Gonzagagasse 11/25<br />
             A-1010 <?php __('Vienna, Austria'); ?><br />
             <br /><br />
             <b><?php echo $userobject['firstname'] . ' ' . $userobject['lastname']; ?></b><br />
             <?php echo $userobject['address']; ?><br />
             <?php echo $userobject['zip'] . '-' . $userobject['city'] . ', ' . $userobject['country']; ?><br />
             <br /><br />
             </div>

             <div style="margin: 0px;" class="block" id="tables">
              
             <table summary="<?php __('TriCoreTraining.com Invoice'); ?>" class="table table-striped table-bordered table-condensed">
             <caption><?php __('TriCoreTraining.com Invoice') ?> <?php __('No.'); ?> <?php echo $data['invoice']; ?> (<?php __('Date'); echo ':'; ?> <?php echo $unitcalc->check_date($data['created']); ?>)</caption>
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
             <tbody>
             <tr class="odd">
                  <td><?php __('Trainingplan'); ?></td>
                  <td>
                  <?php echo $data['timeinterval']; ?> <?php __('month(s)'); ?><br />
                  <?php __('From'); ?> <?php echo $data['paid_from']; ?> <?php __('to'); ?> <?php echo $data['paid_to']; ?></td>
                  <td class="currency"><?php echo $data['currency'] . ' ' . sprintf('%.2f', $data['price']); ?></td>
             </tr>
             <tr>
                  <td></td>
                  <td><?php __('We are not allowed to charge VAT as a club.'); ?></td>
             </tr>
             </tbody>
             <tr class="total">
                  <th><?php __('Total'); ?></th>
                  <td></td>
                  <th class="currency"><?php echo $data['currency'] . ' ' . $data['price']; ?></th>
             </tr>
             </table>
              
             <?php echo $html->link(__('Back to list of payments',true),array('controller' => 'payments', 'action' => 'show_payments'))?>
             <br /><br />
             </div>

             </fieldset>

<?php
      echo $form->end();
?>
        </div>
      </div>

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