<?php if ( !isset( $userobject ) ) { ?>
<?php echo $html->link(__('Sign in',true),array('controller' => 'users', 'action' => 'login'))?> | 
<?php } else { ?>
<?php echo $html->link(__('Edit profile',true),array('controller' => 'users', 'action' => 'edit_userinfo'))?> | 
<?php echo $html->link(__('Sign out',true), array('controller' => 'users', 'action' => 'logout')); ?> | 
<?php } ?>
