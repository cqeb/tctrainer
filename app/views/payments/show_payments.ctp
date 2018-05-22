      <div class="panel panel-default" id="forms">
        <div class="panel-heading"><h1><?php __('Display your previous payments'); ?></h1></div>
        
        <div class="panel-body">                   

             <?php echo $this->element('js_error'); ?>

             <?php if ($session->read('flash')) { ?>
             <div class="alert alert-success">
             <?php echo $session->read('flash'); $session->delete('flash'); ?>
             </div><br />
             <?php } ?>

             <div class="alert">
             <?php __('This list displays all your invoices for payments proceeded by our payment provider. If you miss an invoice, please be aware
             that you receive your invoice at the time your payment is processed.'); ?>
             </div><br />

             <?php echo $form->create('User', array('action' => '#','class' => 'form-horizontal'));?>
             <fieldset>
             <legend><?php __('List of payments'); ?></legend>

             <table class="table table-striped table-bordered table-condensed">
             <tr>
                  <th><?php echo $paginator->sort(__('Invoice',true), 'invoice'); ?></th>
                  <th><?php __('Month(s)'); ?></th>
                  <th><?php __('Price'); ?></th>
                  <th><?php __('From-To'); ?></th>
                  <th><?php __('Created'); ?></th>
             </tr>
             <?php foreach ($payments as $payment): ?>
             <tr>
                  <td><?php echo $html->link(__('No.', true) . ' ' . $payment['Payment']['invoice'],"/payments/show_invoice/".$payment['Payment']['id']); ?></td>
                  <td align="center"><?php echo $payment['Payment']['timeinterval']; ?></td>
                  <td><?php echo sprintf('%.2f', $payment['Payment']['price']); ?> <?php echo $payment['Payment']['currency']; ?></td>
                  <td><?php echo $unitcalc->check_date($payment['Payment']['paid_from']); ?> to <br /><?php echo $unitcalc->check_date($payment['Payment']['paid_to']); ?></td>
                  <td><?php echo $unitcalc->check_date($payment['Payment']['created']); ?></td>
             </tr>
             <?php endforeach; ?>
             <?php if ( count( $payments ) < 1 ) 
             {
             ?>
             <tr>
                  <td></td><td colspan="4"><?php __('No invoices available.'); ?></td>
             </tr>
             <?php  
             } 
             ?>
             </table>
              
             <?php echo $paginator->numbers(); ?>

             <br />
             </fieldset>

             <?php echo $form->end();?>

        </div>
      </div>

<?php
      $this->js_addon = "";
?>