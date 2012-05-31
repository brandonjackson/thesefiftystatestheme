<?php
/**
 * The template for displaying content in the single.php template
 *
 * @package WordPress
 * @subpackage Twenty_Eleven
 * @since Twenty Eleven 1.0
 */
?>
			<div class="item" <?php if($wp_query->post_count==1){ echo "style='border-bottom: none;'"; }?>>
				<a class="article-title" href="<?php the_permalink();?>">
					<?php the_title(); ?>
				</a>
				<a href="<?php the_permalink();?>" class="author">
					By <?php the_author();?>
				</a>
				<div class='entry-summary'>
					<?php the_excerpt();?>
				</div>
			</div>

