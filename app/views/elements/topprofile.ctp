
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

<?php if ( $language != 'eng' || $language == '' ) { ?>
<?php echo $html->link('English',array('controller' => 'starts', 'action' => 'index', 'code' => "eng")) . ' | '; ?>
<?php } ?>
<?php if ( $language != 'deu' ) { ?>
<?php echo $html->link('Deutsch',array('controller' => 'starts', 'action' => 'index', 'code' => "deu")) . ' | '; ?>
<?php } ?>
</b>

</div> 
