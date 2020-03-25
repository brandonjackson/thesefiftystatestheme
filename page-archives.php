<?php
/**
 * The template for displaying Archive pages.
 *
 * Used to display archive-type pages if nothing more specific matches a query.
 * For example, puts together date-based pages if no date.php file exists.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Twenty_Eleven
 * @since Twenty Eleven 1.0
 */
 
/* Get Issues Data */

$issues=get_terms('issues',array());

get_header(); ?>

<style>
</style>

<section id="primary">
<div id="archives" role="main">

<h1 class='entry-title'>Archives</h1>

<div class="archive-list">

	<?php 
	$issues_cat = get_category_by_slug('issues');
	$categories = get_categories( array( 
		'orderby' => 'slug',
		'order' => 'DESC',
		'hide_empty' =>true,
		'number' => 50,
		'child_of'=>$issues_cat->cat_ID ));
	
	foreach($categories as $cat): ?>
			
	<a class='issue-heading' href="<?php echo get_category_link($cat->cat_ID);?>"><?php echo $cat->name; ?></a>
	
	<?php
		$posts = get_posts(array(
			'cat'=>$cat->cat_ID,
			'posts_per_page'=>-1
		));
		foreach($posts as $post):
			setup_postdata($post);			
			get_template_part('archive-list-item');
		endforeach;
	endforeach;?>			
</div>


</div><!-- #content -->
</section><!-- #primary -->

	<section class="archival_footer clearfix">

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

		<?php the_widget( 'WP_Widget_Tag_Cloud' ); ?>
		</div>
	</section>
<?php //get_sidebar(); 
?>

<script src="<?php echo bloginfo('template_directory');?>/js/raphael-min.js"></script>
<script src="<?php echo bloginfo('template_directory');?>/js/us-map-svg-3.js"></script>

<script>
jQuery(function(){

});
</script>
<script src="<?php echo bloginfo('template_directory');?>/js/states.js"></script>

<?php get_footer(); ?>