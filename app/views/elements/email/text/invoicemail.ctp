
<?php __('Aloha'); ?> <?php echo $user['User']['firstname']; ?>,
       
<?php __('thanks for your trust in TriCoreTraining.com.'); ?>

*TriCoreTraining.com <?php __('Invoice'); ?> <?php __('No.'); ?> <?php echo $invoice; ?>*

<?php __('Product'); ?> | <?php __('Interval'); ?>  | <?php __('Price'); ?>
<?php __('Total'); ?>                                 <?php echo $currency . ' ' . $price; ?>

<?php __('Trainingplan'); ?> | <?php echo $timeinterval; ?> <?php __('month(s)'); ?> | <?php echo $currency . ' ' . $price; ?>

<?php __('Previous period:'); ?> <?php echo $payed_from; ?> <?php __('to'); ?> <?php echo $payed_to; ?>
<?php __('New period:'); ?> <?php echo $payed_new_from; ?> <?php __('to'); ?> <?php echo $payed_new_to; ?>

<?php __('Yours, Clemens'); ?>

<?php echo $this->element('email/newsletter_text_footer'); ?>

