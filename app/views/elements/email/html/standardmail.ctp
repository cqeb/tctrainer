
<?php echo $this->element('email/newsletter_header'); ?>

 <table cellspacing="0" cellpadding="4" bgcolor="#FFAE00" width="100%">
    <tr>
       <td>
          <h2><?php __('Aloha'); ?> <?php echo $to_name; ?>,</h2>
       </td>
    </tr>
 </table>

 <p><?php echo $mcontent; ?></p>
 <p class="more"><a href="<?php echo Configure::read('App.hostUrl'); ?>"><?php __('Go to TriCoreTraining.com!'); ?></a></p>
                           
 <p><?php __('Yours, Clemens'); ?></p>
 <br />
 
<?php echo $this->element('email/newsletter_footer'); ?>
