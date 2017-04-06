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

                  <?php if (have_posts()) : while (have_posts()) : the_post(); ?>

      <div class="panel panel-default">  
        <div class="panel-heading"><h2><?php the_title(); ?></h2></div>      
        <div class="panel-body">

                  <div class="post" id="post-<?php the_ID(); ?>">

                      <?php the_content('<p class="serif">' . __('Read the rest of this page') . ' &raquo;</p>'); ?>
			                <br /><br />
                      <?php wp_link_pages(array('before' => '<p><strong>' . __('Pages') . ':</strong> ', 'after' => '</p>', 'next_or_number' => __('number'))); ?>
                  
                  </div>

        </div>
      </div>
                  <?php endwhile; endif; ?>

      <div class="panel panel-default">  
        <div class="panel-body">

                  <?php edit_post_link(__('Edit this entry.'), '<p>', '</p>'); ?>

                  <?php comments_template(); ?>
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
