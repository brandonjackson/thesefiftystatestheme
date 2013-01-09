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
						
<article class="item clearfix">
	<div class="state" id="state-<?php echo get_the_ID();?>" rel="<?php echo $state; ?>"></div>
	<div class="info">
		<a class="article-title" href="<?php the_permalink();?>">
			<?php the_title(); ?>
			<span class="author">By <?php the_author();?></span>
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
</article>