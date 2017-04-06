<div class="panel panel-warning">
      <div class="panel-heading"><?php _e('Sidebar'); ?></div>
            <div class="panel-body">

<?php
/**
 * @package WordPress
 * @subpackage Default_Theme
 */
?>
  <!--<div id="sidebar" role="complementary">-->

	<ul class="list-unstyled">
    
      <?php   /* Widgetized sidebar, if you have the plugin installed. */
          if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar() ) : ?>
      
          <?php get_search_form(); ?>
      

      <?php if ( is_404() || is_category() || is_day() || is_month() ||
            is_year() || is_search() || is_paged() ) {
      ?> 


      <?php /* If this is a 404 page */ if (is_404()) { ?>
      <?php /* If this is a category archive */ } elseif (is_category()) { ?>
      <p><?php _e('You are currently browsing the archives for the category'); ?> (<?php single_cat_title(''); ?>).</p>

      <?php /* If this is a daily archive */ } elseif (is_day()) { ?>
      <p><?php _e('You are currently browsing the blog archives'); ?> (<a href="<?php bloginfo('url'); ?>/"><?php bloginfo('name'); ?></a>)
      <?php _e('for the day'); ?> <?php the_time('l, F jS, Y'); ?>.</p>

      <?php /* If this is a monthly archive */ } elseif (is_month()) { ?>
      <p><?php _e('You are currently browsing the blog archives'); ?> (<a href="<?php bloginfo('url'); ?>/"><?php bloginfo('name'); ?></a>)
      <?php _e('for'); ?> <?php the_time('F, Y'); ?>.</p>

      <?php /* If this is a yearly archive */ } elseif (is_year()) { ?>
      <p><?php _e('You are currently browsing the blog archives'); ?> (<a href="<?php bloginfo('url'); ?>/"><?php bloginfo('name'); ?></a>)
      <?php _e('for the year'); ?> <?php the_time('Y'); ?>.</p>

      <?php /* If this is a search result */ } elseif (is_search()) { ?>
      <p><?php _e('You have searched the blog archives'); ?> (<a href="<?php bloginfo('url'); ?>/"><?php bloginfo('name'); ?></a>)
      <?php _e('for'); ?> <strong>'<?php the_search_query(); ?>'</strong>. <?php _e('If you are unable to find anything in these search results, you can try one of these links.'); ?></p>

      <?php /* If this set is paginated */ } elseif (isset($_GET['paged']) && !empty($_GET['paged'])) { ?>
      <p><?php _e('You are currently browsing the blog archives'); ?> (<a href="<?php bloginfo('url'); ?>/"><?php bloginfo('name'); ?></a>)</p>

      <?php } ?>

     
    <?php }?>
    

      <?php wp_list_pages('title_li=<h3>' . __('Pages') . '</h3>' ); ?>

      <h3><?php _e('Archives'); ?></h3>
        <?php wp_get_archives('type=monthly'); ?>
      

      <?php wp_list_categories('show_count=1&title_li=<h3>' . __('Categories') . '</h3>'); ?>
    
    
      <?php /* If this is the frontpage */ if ( is_home() || is_page() ) { ?>
        <?php wp_list_bookmarks(); ?>

        <h3><?php _e('Meta'); ?></h3>
        <ul>
          <li><?php wp_register(); ?></li>
          <li><?php wp_loginout(); ?></li>
          <li><?php wp_meta(); ?></li>
        </ul>
        
      <?php } ?>

      <?php endif; ?>
    
	</ul>

  <?php include( $_SERVER['DOCUMENT_ROOT'] . '/blog/wp-content/themes/tricoretraining/sidebar.inc.php' ); ?>

  <!--</div>-->
        </div>
            <div class="panel-footer"></div>
</div>