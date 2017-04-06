<?php get_header(); ?>


<article>
<div class="container">

	<div class="row">

		<div class="col-xs-12 col-sm-7 col-md-8 col-lg-8">
		
<!--
      <div class="panel panel-default">
        <div class="panel-heading"><h1><?php _e('Blog of TriCoreTraining.com'); ?></h1></div>
        
        <div class="panel-body">

                   <noscript>
                   <div class="alert alert-danger">
                   <?php _e('Sorry, you have to have JavaScript activated in your browser for this service.'); ?><br />
                   </div>
                   </noscript>
        </div>
      </div>
-->

      <?php if (have_posts()) : ?>

      <div class="panel panel-default">
        <div class="panel-heading">

      <?php $post = $posts[0]; // Hack. Set $post so that the_date() works. ?>
      <?php /* If this is a category archive */ if (is_category()) { ?>
      <h2 class="pagetitle"><?php _e('Archive for the'); ?> &#8216;<?php single_cat_title(); ?>&#8217; <?php _e('Category'); ?></h2>
      <?php /* If this is a tag archive */ } elseif( is_tag() ) { ?>
      <h2 class="pagetitle"><?php _e('Posts Tagged'); ?> &#8216;<?php single_tag_title(); ?>&#8217;</h2>
      <?php /* If this is a daily archive */ } elseif (is_day()) { ?>
      <h2 class="pagetitle"><?php _e('Archive for'); ?> <?php the_time('F jS, Y'); ?></h2>
      <?php /* If this is a monthly archive */ } elseif (is_month()) { ?>
      <h2 class="pagetitle"><?php _e('Archive for'); ?> <?php the_time('F, Y'); ?></h2>
      <?php /* If this is a yearly archive */ } elseif (is_year()) { ?>
      <h2 class="pagetitle"><?php _e('Archive for'); ?> <?php the_time('Y'); ?></h2>
      <?php /* If this is an author archive */ } elseif (is_author()) { ?>
      <h2 class="pagetitle"><?php _e('Author Archive'); ?></h2>
      <?php /* If this is a paged archive */ } elseif (isset($_GET['paged']) && !empty($_GET['paged'])) { ?>
      <h2 class="pagetitle"><?php _e('Blog Archives'); ?></h2>
      <?php } ?>
        </div>
        
        <div class="panel-body">
        </div>
      </div>

    <?php while (have_posts()) : the_post(); ?>
      <div class="panel panel-default" id="forms">
        <div class="panel-heading"><h3 id="post-<?php the_ID(); ?>"><a href="<?php the_permalink() ?>" rel="bookmark" title="<php _e('Permanent Link to'); ?> <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h3></div>
        
        <div class="panel-body">

        <div <?php post_class() ?>>
        
        <!--<small><?php the_time('l, F jS, Y') ?></small><br /><br />-->

        <div class="entry">
          <?php the_content() ?>
        </div>

        <p class="postmetadata"><?php the_tags('Tags: ', ', ', '<br />'); ?> <?php _e('Posted in'); ?> <?php the_category(', ') ?> | <?php edit_post_link(__('Edit'), '', ' | '); ?>  <?php comments_popup_link(__('No Comments') . ' &#187;', '1 ' . __('Comment') . ' &#187;', '% ' . __('Comments') . ' &#187;'); ?></p>
        </div>

        </div>
      </div>

    <?php endwhile; ?>

      <div class="panel panel-default" id="forms">        
        <div class="panel-body">

      <ul class="pager">
        <li>
            <a href="#"><?php next_posts_link('&laquo; ' . __('Older Entries')) ?></a>
        </li>
        <li>
            <a href="#"><?php previous_posts_link(__('Newer Entries') . ' &raquo;') ?></a>
        </li>
      </ul>

        </div>
      </div>


  <?php else : ?>
        <div class="panel panel-default" id="forms">        
        <div class="panel-body">

  <?php

    if ( is_category() ) { // If this is a category archive
      printf("<h2 class='center'>" . __("Sorry, but there aren't any posts in the") . " %s " . __('category') . " " . __('yet') . ".</h2>", single_cat_title('',false));
    } else if ( is_date() ) { // If this is a date archive
      echo("<h2>" . __("Sorry, but there aren't any posts with this date.") . "</h2>");
    } else if ( is_author() ) { // If this is a category archive
      $userdata = get_userdatabylogin(get_query_var('author_name'));
      printf("<h2 class='center'>" . __("Sorry, but there aren't any posts by") . " %s " . __('yet') . ".</h2>", $userdata->display_name);
    } else {
      echo("<h2 class='center'>" . __("No posts found.") . "</h2>");
    }
    get_search_form();

?>
        </div>
      </div>
<?php
  endif;
?>


		</div>
		<div class="col-xs-12 col-sm-5 col-md-4 col-lg-4">

<div class="panel">
	<div class="panel-body">

  <?php get_sidebar(); ?>

	</div>
</div>

		</div>
	
	</div>

</div>
</article>

<?php get_footer(); ?>
