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

<div class="content-list">

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

		<?php endforeach; endforeach;?>			
			</div>
			
<!--
<ul class='issues clearfix'>
<?php foreach ($issues as $issue ) { 
$args = array(
   'numberposts' => 25,
   'orderby' => 'author',
   'tax_query' => array(
	array(
		'taxonomy' => 'issues',
		'field' => 'slug',
		'terms' => $issue->slug
	)
   ),
   'post_status' => 'publish'
);
$articles= get_posts ( $args );
?>

	<li>
		<a class='title' href="<?php echo get_term_link($issue->slug,'issues'); ?>">
			<?php echo $issue->name; ?>
		</a>
		<p>
			<em>from <?php echo $issue->description; ?></em>
		</p>
		<p style='font-style: italic;'>—featuring the work of—</p>
		<?php foreach($articles as $a){ echo get_user_meta($a->post_author,'nickname',true).'&mdash;'; } ?> 
	</li>
<?php } ?>
</ul>
-->


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