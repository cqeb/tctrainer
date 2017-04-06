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

  <?php if (have_posts()) : while (have_posts()) : the_post(); ?>

      <div <?php post_class() ?> id="post-<?php the_ID(); ?>">
      <h2><?php the_title(); ?></h2>

      <div class="entry">
        <?php the_content('<p class="serif">' . __('Read the rest of this entry') . ' &raquo;</p>'); ?>

        <?php wp_link_pages(array('before' => '<p><strong>' . __('Pages') . ':</strong> ', 'after' => '</p>', 'next_or_number' => __('number'))); ?>
        <?php the_tags( '<p>' . __('Tags') . ': ', ', ', '</p>'); ?>

        <p class="postmetadata alt">
          <small>
            <?php _e('This entry was posted'); ?>
            <?php /* This is commented, because it requires a little adjusting sometimes.
              You'll need to download this plugin, and follow the instructions:
              http://binarybonsai.com/wordpress/time-since/ */
              /* $entry_datetime = abs(strtotime($post->post_date) - (60*120)); echo time_since($entry_datetime); echo ' ago'; */ ?>
            <!--<?php _e('on'); ?> <?php the_time('l, F jS, Y') ?> <?php _e('at'); ?> <?php the_time() ?>-->
            <?php _e('and is filed under'); ?> <?php the_category(', ') ?>.
            <?php _e('You can follow any responses to this entry through the RSS 2.0 feed.'); ?> <?php post_comments_feed_link('&raquo; RSS 2.0 Feed'); ?>

            <?php if ( comments_open() && pings_open() ) {
              // Both Comments and Pings are open ?>
              <?php _e('You can leave a response'); ?> <a href="#respond">(<?php _e('here'); ?>)</a>, <?php __('or'); ?> <?php _e('trackback from your own site'); ?> <a href="<?php trackback_url(); ?>" rel="trackback">(<?php _e('here'); ?>)</a>

            <?php } elseif ( !comments_open() && pings_open() ) {
              // Only Pings are Open ?>
              <?php _e('Responses are currently closed, but you can trackback from your own site.'); ?> <a href="<?php trackback_url(); ?>" rel="trackback">(<?php _e('here'); ?>)</a>

            <?php } elseif ( comments_open() && !pings_open() ) {
              // Comments are open, Pings are not ?>
              <?php _e('You can skip to the end and leave a response. Pinging is currently not allowed.'); ?>

            <?php } elseif ( !comments_open() && !pings_open() ) {
              // Neither Comments, nor Pings are open ?>
              <?php _e('Both comments and pings are currently closed.'); ?>

            <?php } ?>
            <br /><?php edit_post_link('&raquo; ' . __('Edit this entry'),'','.'); ?>
          </small>
        </p>
      </div>
    </div>

      <ul class="pager">
        <li>
            <a href="#"><?php next_posts_link('&laquo; ' . __('Older Entries')) ?></a>
        </li>
        <li>
            <a href="#"><?php previous_posts_link(__('Newer Entries') . ' &raquo;') ?></a>
        </li>
      </ul>


  <?php comments_template(); ?>

  <?php endwhile; else: ?>

    <p><?php _e('Sorry, no posts matched your criteria.'); ?></p>

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
