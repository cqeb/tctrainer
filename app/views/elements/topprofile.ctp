
<div class="tools">
<?php if ( !isset( $session_userid ) ) { ?>

<!--<?php echo $html->link(__('Sign in',true),array('controller' => 'users', 'action' => 'login'))?>--> 

<?php } else { ?>

<?php echo $html->link(__('Home',true),array('controller' => 'users', 'action' => 'index'))?>
<!--
 | 
<?php echo $html->link(__('Edit profile',true),array('controller' => 'users', 'action' => 'edit_userinfo'))?>
-->
 | 
<?php if ( isset ( $userobject ) ) { echo $userobject['firstname']; } ?>
 | 
<?php echo $html->link(__('Sign out',true), array('controller' => 'users', 'action' => 'logout')); ?> 
 | 
<?php } ?>

<a href="/blog/<?php if ( $locale != 'eng' || $locale == '' ) { ?>de/<?php } else { ?>en/<?php } ?>"><?php __('Blog'); ?></a>
  |
<?php if ( $locale != 'eng' || $locale == '' ) { ?>
<?php echo $html->link(__('English', true),array('controller' => 'users', 'action' => 'change_language', 'code' => "eng")); ?>
<?php } ?>
<?php if ( $locale != 'deu' ) { ?>
<?php echo $html->link(__('Deutsch', true),array('controller' => 'users', 'action' => 'change_language', 'code' => "deu")); ?>
<?php } ?>

<!--<?php echo $locale; ?>-->
</div> 
