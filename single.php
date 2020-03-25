<?php
/**
 * The Template for displaying all single posts.
 *
 * @package WordPress
 * @subpackage Twenty_Eleven
 * @since Twenty Eleven 1.0
 */

get_header(); ?>

		<div id="primary">
			<div id="content" role="main">

				<?php while ( have_posts() ) : the_post(); ?>

					<?php get_template_part( 'content', 'single' ); ?>

					<?php comments_template( '', true ); ?>
					
					<nav id="article-nav">
						<h3 class="assistive-text"><?php _e( 'Post navigation', 'twentyeleven' ); ?></h3>
						<div class="prev-article">
							<?php previous_post_link( '%link', '%title', true); ?>
						</div>
						<div class="next-article">
							<?php next_post_link( '%link', '%title', true); ?>
						</div>
					</nav><!-- #nav-single -->

				<?php endwhile; // end of the loop. ?>

			</div><!-- #content -->
		</div><!-- #primary -->

<?php get_footer(); ?>