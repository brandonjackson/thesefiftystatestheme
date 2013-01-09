<?php
/**
 * The template for displaying Category Archive pages.
 *
 * @package WordPress
 * @subpackage Twenty_Eleven
 * @since Twenty Eleven 1.0
 */

get_header(); ?>

		<section id="primary">
			<div role="main">
			
			

			<?php if ( have_posts() ) : ?>

				<header class="page-header">
					<h1 class="entry-title"><?php
						printf( __( '%s', 'twentyeleven' ), '<span>' . single_cat_title( '', false ) . '</span>' );
					?></h1>

					<?php
						$category_description = category_description();
						if ( ! empty( $category_description ) )
							echo apply_filters( 'category_archive_meta', '<div class="category-archive-meta">' . $category_description . '</div>' );
					?>
				</header>

				<?php twentyeleven_content_nav( 'nav-above' ); ?>
				<div class="content-list">
				<?php /* Start the Loop */ ?>
				<?php while ( have_posts() ) : the_post(); ?>
				
				

			<?php 
																
					/* FIND STATE SLUG */
					$id = get_the_ID();
					$terms = get_the_terms($id,'state');
					if($terms != false){
						$state_obj = array_pop($terms);//->slug;		
						$state = $state_obj->slug;//print_r($state_obj);
					} else {
						$state = 'ct';
					}
					?>
						
			<div class="item clearfix">
				<div class="state" id="state-<?php echo get_the_ID();?>" rel="<?php echo $state; ?>"></div>
				<div class="info">
					<a class="article-title" href="<?php the_permalink();?>">
						<?php the_title(); ?>
					</a>
					<a href="<?php the_permalink();?>" class="author">
						By <?php the_author();?>
					</a>
					<p class='excerpt clearfix'>
					<?php 	$excerpt = get_the_excerpt();
							$str = wordwrap($excerpt, 80);
							$str = explode("\n", $str);
							$excerpt = $str[0] . '...';
							echo $excerpt; 
					?>
					</p>
				</div>
			</div>
				<?php endwhile; ?>
							</div>


				<?php twentyeleven_content_nav( 'nav-below' ); ?>

			<?php else : ?>

				<article id="post-0" class="post no-results not-found">
					<header class="entry-header">
						<h1 class="entry-title"><?php _e( 'Nothing Found', 'twentyeleven' ); ?></h1>
					</header><!-- .entry-header -->

					<div class="entry-content">
						<p><?php _e( 'Apologies, but no results were found for the requested archive. Perhaps searching will help find a related post.', 'twentyeleven' ); ?></p>
						<?php get_search_form(); ?>
					</div><!-- .entry-content -->
				</article><!-- #post-0 -->

			<?php endif; ?>

			</div><!-- #content -->
		</section><!-- #primary -->

<script src="<?php echo bloginfo('template_directory');?>/js/raphael-min.js"></script>
<script src="<?php echo bloginfo('template_directory');?>/js/us-map-svg-3.js"></script>

<script>
jQuery(function(){

});
</script>
<script src="<?php echo bloginfo('template_directory');?>/js/states.js"></script>

<?php get_footer(); ?>
