
<div class="tools">
<b>
<a href="/trainer/"><?php __('Home'); ?></a>
 | 
<?php if ( !isset( $session_userid ) ) { ?>

<?php } else { ?>

    <?php if ( isset ( $userobject ) ) { echo $userobject['firstname']; } ?>
    | 

    <?php if ( $language != 'eng' || $language == '' ) { ?>
        <?php echo $html->link(__('Sign out',true), '/users/logout/code:eng/' ); ?> 
        | 
        <?php echo $html->link('English', '/starts/index/code:eng/') . ' | '; ?>
    <?php } ?>
    <?php if ( $language != 'deu' ) { ?>
        <?php echo $html->link(__('Sign out',true), '/users/logout/code:deu/' ); ?> 
        | 
        <?php echo $html->link('Deutsch', '/starts/index/code:deu/') . ' | '; ?>
    <?php } ?>

<?php } ?>
</b>

</div>
