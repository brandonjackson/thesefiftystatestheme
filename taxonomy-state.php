<?php
/**
 * The template for displaying Category Archive pages.
 *
 * @package WordPress
 * @subpackage Twenty_Eleven
 * @since Twenty Eleven 1.0
 */

get_header();
global $wp_query; ?>

		<section id="primary">
			<div id="content" style='width:800px;' role="main">

				<header class="page-header">
					<h1 class="page-title"><?php
						printf( __( 'The State of %s', 'twentyeleven' ), '<span id="state-title">' . single_cat_title( '', false ) . '</span>' );
					?></h1>

					<?php
						$category_description = category_description();
						if ( ! empty( $category_description ) )
							echo apply_filters( 'category_archive_meta', '<div class="category-archive-meta">' . $category_description . '</div>' );
					?>
				</header>

				<?php twentyeleven_content_nav( 'nav-above' ); ?>

				<?php /* Start the Loop */ ?>
			<div class="content-list">

			<?php if ( have_posts() ) : ?>

<div class="left">
				<?php /* Start the Loop */ $i = 1; ?>
				<?php while ( have_posts() ) : the_post(); ?>

					<?php if($i%2==1){
						/* Include the Post-Format-specific template for the content.
						 * If you want to overload this in a child theme then include a file
						 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
						 */
						//get_template_part( 'content', get_post_format() );
						?>
						
			<div class="item" <?php if($wp_query->post_count==1){ echo "style='border-bottom: none;'"; }?>>
				<a class="article-title" href="<?php the_permalink();?>">
					<?php the_title(); ?>
				</a>
				<a href="<?php the_permalink();?>" class="author">
					By <?php the_author();?>
				</a>
				<p><?php the_excerpt();?></p>
			</div>
<?php } $i++; ?>

				<?php endwhile; ?>
				</div>
				<div class="right">
				<?php rewind_posts();?>
				<?php /* Start the Loop */ $i = 1; ?>
				<?php while ( have_posts() ) : the_post(); ?>

					<?php if($i%2==0){
						/* Include the Post-Format-specific template for the content.
						 * If you want to overload this in a child theme then include a file
						 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
						 */
						//get_template_part( 'content', get_post_format() );
						?>
						
			<div class="item" <?php if($wp_query->post_count==2){ echo "style='border-bottom: none;'"; }?>>
				<a class="article-title" href="<?php the_permalink();?>">
					<?php the_title(); ?>
				</a>
				<a href="<?php the_permalink();?>" class="author">
					By <?php the_author();?>
				</a>
				<p><?php the_excerpt();?></p>
			</div>
<?php } $i++; ?>

				<?php endwhile; ?>
				<?php else: ?>
					<div class="entry-content">
						<p style='text-align: center;'>Welcome to the Frontier! We don't have any stories from <?php single_cat_title(); ?> yet. If you have a tale to tell, please let us know. <a href="<?php echo esc_url( home_url( '/' ) ); ?>">Return to the Home Page</a></p>
					</div><!-- .entry-content -->
				
				<?php endif; ?>
</div>
				<?php twentyeleven_content_nav( 'nav-below' ); ?>


			</div><!-- #content -->
		</section><!-- #primary -->

<?php get_footer(); ?>
