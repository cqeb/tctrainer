<?php get_header(); ?>


<article>
<div class="container">

	<div class="row">

		<div class="col-xs-12 col-sm-7 col-md-8 col-lg-8">
		
      <div class="panel panel-default" id="forms">
        <div class="panel-heading"><h1><?php _e('Blog of TriCoreTraining.com'); ?></h1></div>
        
        <div class="panel-body">

                   <noscript>
                   <div class="alert alert-danger">
                   <?php _e('Sorry, you have to have JavaScript activated in your browser for this service.'); ?><br />
                   </div>
                   </noscript>

  <?php if (have_posts()) : ?>

    <h2 class="pagetitle"><?php _e('Search Results'); ?></h2>

    <div class="navigation">
      <div class="alignleft"><?php next_posts_link('&laquo; ' . __('Older Entries')) ?></div>
      <div class="alignright"><?php previous_posts_link(__('Newer Entries') . ' &raquo;') ?></div>
    </div>

    <?php while (have_posts()) : the_post(); ?>

      <div <?php post_class() ?>>
        <h3 id="post-<?php the_ID(); ?>"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php _e('Permanent Link to'); ?> <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h3>
        <!--<small><?php the_time('l, F jS, Y') ?></small>-->

        <p class="postmetadata"><?php the_tags(__('Tags') . ': ', ', ', '<br />'); ?> <?php _e('Posted in'); ?> <?php the_category(', ') ?> | <?php edit_post_link(__('Edit'), '', ' | '); ?>  <?php comments_popup_link(__('No Comments') . ' &#187;', '1 ' . __('Comment') . ' &#187;', '% ' . __('Comments') . ' &#187;'); ?></p>
      </div>

    <?php endwhile; ?>

    <div class="navigation">
      <div class="alignleft"><?php next_posts_link('&laquo; '. __('Older Entries')) ?></div>
      <div class="alignright"><?php previous_posts_link(__('Newer Entries') . ' &raquo;') ?></div>
    </div>

  <?php else : ?>

    <h2 class="center"><?php _e('No posts found. Try a different search?'); ?></h2>
    <?php get_search_form(); ?>

  <?php endif; ?>

        </div>
      </div>

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
