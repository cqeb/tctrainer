
<?php echo $this->element('email/newsletter_header'); ?>

 <table cellspacing="0" cellpadding="4" bgcolor="#FFAE00" width="100%">
    <tr>
       <td>
          <h2><?php __('Hello'); ?> <?php echo $user['User']['firstname']; ?>,</h2>
       </td>
    </tr>
 </table>

 <p><i><?php __('don\'t be lazy. Train and track your trainings!'); ?></i></p>
 <p><?php __('Go to'); ?> <a href="http://www.tricoretraining.com" target="_blank">TriCoreTraining.com</a> <?php __('and log your trainings - NOW!'); ?></p>
 <p class="more"><a href="<?php echo Configure::read('App.hostUrl'); echo Configure::read('App.serverUrl'); ?>/trainingstatistics/"><?php __('Yes, I\'ll do!'); ?></a></p>
 
 <p><?php __('Yours, Clemens'); ?></p>
 <br />

<?php echo $this->element('email/newsletter_footer'); ?>
