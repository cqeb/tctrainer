
<?php echo $this->element('email/newsletter_header'); ?>

 <table cellspacing="0" cellpadding="4" bgcolor="#FFAE00" width="100%">
    <tr>
       <td>
          <h2><?php __('Aloha'); ?> <?php if ( isset( $to_name ) ) echo $to_name; else echo $user['User']['firstname']; ?>,</h2>
       </td>
    </tr>
 </table>

 <p><i><?php __("don't be lazy. Do your training and track your workouts!"); ?></i></p>
 
 <p><?php __('Go to'); ?> <a href="http://www.tricoretraining.com" target="_blank">TriCoreTraining.com</a> <?php __('and track your workouts - NOW!'); ?></p>
 
 <p class="more"><a href="<?php echo Configure::read('App.hostUrl'); echo Configure::read('App.serverUrl'); ?>/trainingstatistics/list_trainings/"><?php __("Yes, I'll do!"); ?></a></p>
 
 <p><?php __('Yours, Clemens'); ?></p>
 <br />

 <p class="more"><a href="<?php echo Configure::read('App.hostUrl'); echo Configure::read('App.serverUrl'); ?>/users/edit_userinfo/"><?php __('Stop sending me notifications!'); ?></a></p>
 
<?php echo $this->element('email/newsletter_footer'); ?>