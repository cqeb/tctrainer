
<div class="tools">
<?php 
if ( $_SERVER['HTTP_HOST'] == 'localhost' )
{
?>
<a href="/trainer/starts/index/en/u:<?php echo base64_encode("1"); ?>">u:1</a> | 
<a href="/trainer/starts/index/en/ur:<?php echo base64_encode("1"); ?>">ur:1</a> | 
<a href="/trainer/starts/index/en/urm:<?php echo base64_encode("1"); ?>">urm:1</a> | 
<a href="/trainer/starts/index/en/c:<?php echo base64_encode("@gentics.com"); ?>">c:@gentics.com</a> |  	 
 		
<a href="http://test.tricoretraining.com/facebook/login.php" title="/trainer/user/loginfacebook/"><img alt="<?php __('Login with your Facebook account!'); ?>" src="/trainer/img/loginfb.png"></a>
 | 
<?php
}
?>

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
<?php echo $html->link(__('English', true),array('controller' => 'starts', 'action' => 'change_language', 'code' => "eng")); ?>
<?php } ?>
<?php if ( $locale != 'deu' ) { ?>
<?php echo $html->link(__('Deutsch', true),array('controller' => 'starts', 'action' => 'change_language', 'code' => "deu")); ?>
<?php } ?>
</b>

</div> 
