
<div class="tools">
<a href="/trainer/"><?php __('Home'); ?></a>
 | 
<?php if ( !isset( $session_userid ) ) { ?>
<?php } else { ?>

<?php if ( isset ( $userobject ) ) { echo $userobject['firstname']; } ?>
 | 
<?php echo $html->link(__('Sign out',true), array('controller' => 'users', 'action' => 'logout')); ?> 
 | 
<?php } ?>
<!--
<a href="/blog/<?php if ( $locale != 'eng' || $locale == '' ) { ?>de/<?php } else { ?>en/<?php } ?>"><?php __('Blog'); ?></a>
  |
-->
<b>
<?php if ( $locale != 'eng' || $locale == '' ) { ?>
<?php echo $html->link(__('English', true),array('controller' => 'users', 'action' => 'change_language', 'code' => "eng")); ?>
<?php } ?>
<?php if ( $locale != 'deu' ) { ?>
<?php echo $html->link(__('Deutsch', true),array('controller' => 'users', 'action' => 'change_language', 'code' => "deu")); ?>
<?php } ?>
</b>

</div> 
