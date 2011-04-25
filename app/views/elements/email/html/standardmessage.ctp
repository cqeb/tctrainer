
<?php echo $this->element('email/newsletter_header_simple'); ?>

 <table cellspacing="0" cellpadding="4" bgcolor="#FFAE00" width="100%">
    <tr>
       <td>
          <h2><?php echo $subject; ?></h2>
       </td>
    </tr>
 </table>

 <p><?php echo $mcontent; ?></p>
                           
<?php echo $this->element('email/newsletter_footer_simple'); ?>
