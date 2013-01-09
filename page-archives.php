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
#issues-archive h1{
	font-weight: bold;
	font-size: 2em;
	text-align: center;
	
}
#issues-archive ul{
	list-style: none;
	margin: 50px 0 0 0;
	padding: 0;
	text-align: center;
}
#issues-archive ul li{
	box-shadow: 3px 3px 2px #AAA;
	width:  335px;
	float: left;
	display: block;
	padding: 20px;
	border: 1px solid #CCC;
	background: #F6F6F6;
	margin-right: 20px;
}
#issues-archive ul li a.title{
	font-size: 24px;
	font-weight: bold;
	color: black;
}
</style>

<section id="primary">
<div id="issues-archive" role="main">

<h1>Archives</h1>
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



</div><!-- #content -->
</section><!-- #primary -->
<?php //get_sidebar(); 
?>
<?php get_footer(); ?>