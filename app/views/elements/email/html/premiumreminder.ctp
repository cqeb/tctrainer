
<?php echo $this->element('email/newsletter_header'); ?>

 <table cellspacing="0" cellpadding="4" bgcolor="#FFAE00" width="100%">
    <tr>
       <td>
          <h2><?php __('Welcome'); ?> <?php if ( isset( $to_name ) ) echo $to_name; else echo $user['User']['firstname']; ?>,</h2>
       </td>
    </tr>
 </table>

 <p><i><?php __('30 cents a day and you get your professional, interactive training coach.'); ?></i></p>
 
 <p><?php __('Gain speed, loose weight!'); echo '<br /><br />'; __('Go to TriCoreTraining.com and subscribe to a membership for less than 10 bucks a month!'); ?></p>
 
 <p class="more"><a href="<?php echo Configure::read('App.hostUrl'); echo Configure::read('App.serverUrl'); ?>/payments/subscribe_triplans/"><?php __('Yes, I\'ll do!'); ?></a></p>
                           
 <p><?php __('Yours, Clemens'); ?></p>
 <br />
 
<?php echo $this->element('email/newsletter_footer'); ?>
