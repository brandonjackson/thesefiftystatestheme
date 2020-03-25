<?php
/**
 * The template for displaying 404 pages (Not Found).
 *
 * @package WordPress
 * @subpackage Twenty_Eleven
 * @since Twenty Eleven 1.0
 */

get_header(); ?>

	<div id="primary">
		<div id="content" role="main">

			<article id="post-0" class="post error404 not-found">
				<header class="entry-header">
					<h1 class="entry-title">Page Not Found</h1>
				</header>

				<div class="entry-content">
					<p><?php _e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching, or one of the links below, can help.', 'twentyeleven' ); ?></p>

					<?php get_search_form(); ?>

					<?php the_widget( 'WP_Widget_Recent_Posts', array( 'number' => 5), array( 'widget_id' => '404' ) ); ?>

					<div class="widget">
						<h2 class="widgettitle">Issues</h2>
						<ul>
						<?php $issues_cat = get_category_by_slug('issues');
						wp_list_categories( array( 'orderby' => 'count', 'order' => 'DESC', 'show_count' => 0, 'title_li' => '', 'number' => 10, 'child_of'=>$issues_cat->cat_ID ) ); ?>
						</ul>
					</div>
					<div class="widget" style="margin-right: 0;">

					<?php
					/* translators: %1$s: smilie */
					/*$archive_content = '<p>' . sprintf( __( 'Try looking in the monthly archives.', 'twentyeleven' ), convert_smilies( ':)' ) ) . '</p>';
					the_widget( 'WP_Widget_Archives', array('count' => 0 , 'dropdown' => 1 ), array( 'after_title' => '</h2>'.$archive_content ) );*/
					?>

					<?php the_widget( 'WP_Widget_Tag_Cloud' ); ?>
					</div>

				</div><!-- .entry-content -->
			</article><!-- #post-0 -->

		</div><!-- #content -->
	</div><!-- #primary -->

<?php get_footer(); ?>