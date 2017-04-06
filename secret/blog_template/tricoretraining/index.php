<?php get_header(); ?>

<article>
<div class="container">

  <div class="row">

    <div class="col-xs-12 col-sm-7 col-md-8 col-lg-8">
    
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

  <?php if (have_posts()) : ?>

    <?php while (have_posts()) : the_post(); ?>

      <div class="panel panel-default">
        <div class="panel-heading">
        <h3><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php _e('Permanent Link to'); ?> <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h3>
        </div>
        
        <div class="panel-body">

      <div <?php post_class() ?> id="post-<?php the_ID(); ?>">
        <p class=" clearfix">
        <div class="entry">
          <?php the_content(__('Read the rest of this entry') . ' &raquo;'); ?>
        </div>

        <p class="postmetadata"><?php the_tags(__('Tags') . ': ', ', ', '<br />'); ?> <?php _e('Posted in'); ?> <?php the_category(', ') ?> | <?php edit_post_link(__('Edit'), '', ' | '); ?>  <?php comments_popup_link(__('No Comments') . ' &#187;', '1 ' . __('Comment') . ' &#187;', '% ' . __('Comments') . ' &#187;'); ?></p>

        <p class="text-right"><a class="btn btn-info" href="<?php the_permalink() ?>"><?php _e('View details'); ?></a></p>
        </p>
      </div>

        </div>
      </div>

    <?php endwhile; ?>

      <div class="panel panel-default">
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

      <div class="panel panel-default">
        <div class="panel-body">

    <h3 class="center"><?php _e('Not Found'); ?></h3>
    <p class="center"><?php _e('Sorry, but you are looking for something that is not here.'); ?></p>
    <?php get_search_form(); ?>

        </div>
      </div>      

  <?php endif; ?>


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
