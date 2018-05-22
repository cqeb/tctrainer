
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

<?php if ( $locale != 'eng' || $locale == '' ) { ?>
<?php echo $html->link('English',array('controller' => 'starts', 'action' => 'index', 'code' => "eng")) . ' | '; ?>
<?php } ?>
<?php if ( $locale != 'deu' ) { ?>
<?php echo $html->link('Deutsch',array('controller' => 'starts', 'action' => 'index', 'code' => "deu")) . ' | '; ?>
<?php } ?>
</b>

</div> 
