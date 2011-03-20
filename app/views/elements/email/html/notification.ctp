
<?php echo $this->element('email/newsletter_header'); ?>

 <table cellspacing="0" cellpadding="4" bgcolor="#FFAE00" width="100%">
    <tr>
       <td>
          <h2><?php __('Aloha'); ?> Admin,</h2>
       </td>
    </tr>
 </table>

 <p><i><?php __('some notification arrived.'); ?></i></p>
 <p>
<font color="red"><?php

echo $error;

?>
</font>
</p>
<p>
<i>
<?php

foreach ( $user['User'] as $key => $value )
{
	echo $key . " = " . $value . "<br />\n\n";
}

?>
</p>
<p>
<?php

foreach ( $array as $key => $value )
{
	echo $key . " = " . $value . "<br />\n\n";
}

?>
</i>
 </p>
 

<?php echo $this->element('email/newsletter_footer'); ?>
