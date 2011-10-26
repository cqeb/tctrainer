
                   <h1><?php __('Show your payments'); ?></h1>

                   <?php echo $this->element('js_error'); ?>

                   <?php if ($session->read('flash')) { ?>
                   <div class="statusbox ok">
                   <?php echo $session->read('flash'); $session->delete('flash'); ?>
                   </div><br />
                   <?php } ?>

                   <div class="statusbox">
                   <?php __('This list shows all your invoices for payments proceeded by PAYPAL. If you miss an invoice, please be aware
                   that you receive your invoice at the time your payment is proceeded.'); ?>
                   </div><br />

                   <?php //echo $form->create('User', array('action' => 'login'));?>
                   <fieldset>
                   <legend><?php __('List of payments'); ?></legend>

                   <table>
                   <tr>
                        <th><?php echo $paginator->sort(__('Invoice',true), 'invoice'); ?></th>
                        <th><?php __('Month(s)'); ?></th>
                        <th><?php __('Price'); ?></th>
                        <th><?php __('From-To'); ?></th>
                        <th><?php __('Created'); ?></th>
                        <?php /** <th><?php __('Action'); ?></th>**/ ?>
                   </tr>
                   <?php foreach ($payments as $payment): ?>
                   <tr>
                   <!--    <td><?php echo $payment['Payment']['id']; ?></td>-->
                        <td><?php echo $html->link(__('No.', true) . ' ' . $payment['Payment']['invoice'],"/payments/show_invoice/".$payment['Payment']['id']); ?></td>
                        <td align="center"><?php echo $payment['Payment']['timeinterval']; ?></td>
                        <td><?php echo sprintf('%.2f', $payment['Payment']['price']); ?> <?php echo $payment['Payment']['currency']; ?></td>
                        <td><?php echo $unitcalc->check_date($payment['Payment']['paid_from']); ?> to <br /><?php echo $unitcalc->check_date($payment['Payment']['paid_to']); ?></td>
                        <td><?php echo $unitcalc->check_date($payment['Payment']['created']); ?></td>
                        <?php /** <td><?php echo $html->link('Delete', array('action' => 'delete', 'id' => $payment['Payment']['id']), null, 'Are you sure?' )?></td> **/ ?> 
                   </tr>
                   <?php endforeach; ?>
                   <?php if ( count( $payments ) < 1 ) 
                   {
                   ?>
                   <tr>
                        <td></td><td colspan="4"><?php __('No payments available.'); ?></td>
                   </tr>
                   <?php  
                   } 
                   ?>
                   </table>
                    
                   <?php echo $paginator->numbers(); ?>

                   <br />
                   </fieldset>

                   <?php //echo $form->end();?>

<?php
      $this->js_addon = "";
?>