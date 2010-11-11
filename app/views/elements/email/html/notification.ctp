
 <table cellspacing="0" cellpadding="4" bgcolor="#FFAE00">
    <tr>
       <td>
          <h2><?php __('Hello'); ?> Admin,</h2>
       </td>
    </tr>
 </table>

 <p><i><?php __('some notification arrived.'); ?></i></p>
 <p>
<?php

echo $error;
echo '<hr>';
print_r( $user );
echo '<hr>';
print_r( $array );

?>
 </p>
 
 <p><?php __('Yours, Clemens'); ?></p>
