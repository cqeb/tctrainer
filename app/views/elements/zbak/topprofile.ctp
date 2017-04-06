
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
<?php if ( $locale != 'fre' ) { ?>
<?php echo $html->link('Francais',array('controller' => 'starts', 'action' => 'index', 'code' => "fre")) . ' | '; ?>
<?php } ?>
<?php if ( $locale != 'chi' ) { ?>
<?php echo $html->link(__('中国的', true),array('controller' => 'starts', 'action' => 'index', 'code' => "chi")) . ' | '; ?>
<?php } ?>
<!--//
<?php if ( $locale != 'ice' ) { ?>
<?php echo $html->link(__('íslenskur', true),array('controller' => 'starts', 'action' => 'index', 'code' => "ice")) . ' | '; ?>
<?php } ?>
<?php if ( $locale != 'ron' ) { ?>
<?php echo $html->link(__('Român', true),array('controller' => 'starts', 'action' => 'index', 'code' => "ron")) . ' | '; ?>
<?php } ?>
<?php if ( $locale != 'pol' ) { ?>
<?php echo $html->link(__('Polski', true),array('controller' => 'starts', 'action' => 'index', 'code' => "pol")) . ' | '; ?>
<?php } ?>
-->

</b>

</div> 
