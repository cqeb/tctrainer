
<div class="tools">
<b>
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
<?php if ( $locale != 'eng' || $locale == '' ) { ?>
<?php echo $html->link(__('English', true),array('controller' => 'starts', 'action' => 'index', 'code' => "eng")) . ' | '; ?>
<?php } ?>
<?php if ( $locale != 'deu' ) { ?>
<?php echo $html->link(__('Deutsch', true),array('controller' => 'starts', 'action' => 'index', 'code' => "deu")) . ' | '; ?>
<?php } ?>
<?php if ( $locale != 'fra' ) { ?>
<?php echo $html->link(__('Francais', true),array('controller' => 'starts', 'action' => 'index', 'code' => "fra")) . ' | '; ?>
<?php } ?>
<!--
<?php if ( $locale != 'zho' ) { ?>
<?php echo $html->link(__('Chinese', true),array('controller' => 'starts', 'action' => 'index', 'code' => "zho")) . ' | '; ?>
<?php } ?>
-->
</b>

</div> 
