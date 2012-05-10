
<?php __('Aloha'); ?> <?php echo $user['User']['firstname']; ?>,
       

<?php __('thanks for your trust in TriCoreTraining.com.'); ?>

*TriCoreTraining - <?php __('Club'); ?>*
Gonzagagasse 11/25
A-1010 <?php __('Vienna, Austria'); ?>


*<?php echo $userobject['firstname'] . ' ' . $userobject['lastname']; ?>*
<?php echo $userobject['address']; ?>
<?php echo $userobject['zip'] . '-' . $userobject['city'] . ', ' . $userobject['country']; ?>


*TriCoreTraining.com <?php __('Invoice'); ?> <?php __('No.'); ?> <?php echo $invoice; ?> (<?php __('Date'); echo ':'; ?> <?php echo $created; ?>)*

<?php __('Product'); ?> | <?php __('Interval'); ?>  | <?php __('Price'); ?>
<?php __('Total'); ?>                                 <?php echo $currency . ' ' . $price; ?>

<?php __('Trainingplan'); ?> | <?php echo $timeinterval; ?> <?php __('month(s)'); ?> | <?php echo $currency . ' ' . $price; ?>

<?php __('Previous period:'); ?> <?php echo $paid_from; ?> <?php __('to'); ?> <?php echo $paid_to; ?>
<?php __('New period:'); ?> <?php echo $paid_new_from; ?> <?php __('to'); ?> <?php echo $paid_new_to; ?>

<?php echo $this->element('email/newsletter_text_footer'); ?>

