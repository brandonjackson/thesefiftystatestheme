<?php
/**
 * The template for displaying Issues Archive pages.
 *
 * Used to display archive-type pages if nothing more specific matches a query.
 * For example, puts together date-based pages if no date.php file exists.
 *
 */

/* Get Issues Data */
$issues_category = get_category_by_slug('issues');
$categories = get_categories(array(
  'orderby' => 'name',
  'parent'=>$issues_category->cat_ID,
  'order' => 'ASC'
));

/* Display Header */
get_header(); ?>

		<section id="primary">
			<div id="content" role="main">
			
<?php foreach($categories as $category) { ?>
	<div class='issues' id='issue-<?php echo $category->term_id;?>'>
		
	<p>Category: <a href="' . get_category_link( $category->term_id ) . '" title="' . sprintf( __( "View all posts in %s" ), $category->name ) . '" ' . '>' . $category->name.'</a> </p> ';
    echo '<p>Description:'. $category->description . '</p>';
    echo '<p>'. $category->count . '</p>';  } 
?>

			</div><!-- #content -->
		</section><!-- #primary -->

<?php // get_sidebar();
 ?>
<?php get_footer(); ?>