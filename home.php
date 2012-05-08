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
			<div id="content" class="home" role="main">
			
			<div id="map"></div>
			
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
						
			<div class="item">
				<a class="article-title" href="<?php the_permalink();?>">
					<?php the_title(); ?>
				</a>
				<a href="<?php the_permalink();?>" class="author">
					By <?php the_author();?>
				</a>
			</div>
<?php } $i++; ?>

				<?php endwhile; ?>
				</div>
				<div class="right">
				
				<?php /* Start the Loop */ $i = 1; ?>
				<?php while ( have_posts() ) : the_post(); ?>

					<?php if($i%2==0){
						/* Include the Post-Format-specific template for the content.
						 * If you want to overload this in a child theme then include a file
						 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
						 */
						//get_template_part( 'content', get_post_format() );
						?>
						
			<div class="item">
				<a class="article-title" href="<?php the_permalink();?>">
					<?php the_title(); ?>
				</a>
				<a href="<?php the_permalink();?>" class="author">
					By <?php the_author();?>
				</a>
			</div>
<?php } $i++; ?>

				<?php endwhile; ?>
</div>
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
			
			</div>

			</div><!-- #content -->
		</section><!-- #primary -->
  <div id="tooltip">
  	<h3>StateNameHere</h3>
  	<a href="#" class="state-link">Click state to view articles</a><!--<span id="article-count">0</span> Articles</a>-->
  </div>

<?php get_footer(); ?>

<script src="<?php echo bloginfo('template_directory');?>/js/raphael-min.js"></script>
<script src="<?php echo bloginfo('template_directory');?>/js/us-map-svg-3.js"></script>


    <script>
  jQuery(function(){
  
  	var mouseX = 0;
  	var mouseY = 0;
  	var hovering = 0;
  	
	
	jQuery(document).mousemove(function(e){
      mouseX = e.pageX;
      mouseY = e.pageY;
      if(hovering){
      	jQuery("a#xy").text(mouseX+","+mouseY);
      }
   	}); 

  
    var R = Raphael("map", 800, 505),
      attr = {
      "fill": "#E3E3E3",
      "stroke": "#fff",
      "stroke-opacity": "1",
      "stroke-linejoin": "round",
      "stroke-miterlimit": "4",
      "stroke-width": "0.75",
      "stroke-dasharray": "none"
    },
    usRaphael = {};
    var mapPosition = jQuery("#map").position();
    var mapX = mapPosition.left;
    var mapY = mapPosition.top;
    
    function stateTooltip(st){
    	if(st.active==1){
    	bounds = st.getBBox();
    	bottomCenterX = (bounds.x+bounds.x2)/2 + mapX;
    	bottomCenterY = bounds.y2 + mapY;
    	
    	middleRightX = bounds.x2 + mapX;
    	middleRightY = (bounds.y+bounds.y2)/2 + mapY;
    	
    	// bottomCenter Tooltip Position:
    	// tooltipX = bottomCenterX - jQuery("#tooltip").width()/2; // top left
    	// tooltipY = bottomCenterY;
    	
    	// middleRight Tooltip Position
    	tooltipX = middleRightX;
    	tooltipY = middleRightY - jQuery("#tooltip").innerHeight()/2;
    	
    	jQuery("#tooltip").css({
    		"left":tooltipX,
    		"top":tooltipY
    	});
    	jQuery("#tooltip h3").text(st.name);
    	jQuery("#tooltip #article-count").text(Math.round(Math.random()*2));
    	jQuery("#tooltip").addClass("active");
    	jQuery("#tooltip").fadeIn();
    }
    };
    
    var active = [ "ak","al","az","ca","fl","ga","ma","ny","or","pa","tn","tx","wi","wy" ];

    //Draw Map and store Raphael paths
    for (var state in usMap) {
      usRaphael[state] = R.path(usMap[state].path).attr(attr);
    }
    
    //Do Work on Map
    for (var state in usRaphael) {
      usRaphael[state].color = Raphael.getColor();
      
      (function (st, state) {
		st.name = usMap[state].name;
        st[0].style.cursor = "pointer";

//         st[0].onmouseover = function () {
//           st.animate({fill: st.color}, 500);
//           st.toFront();
//           R.safari();
//         };
// 
//         st[0].onmouseout = function () {
//           st.animate({fill: "#E3E3E3"}, 500);
//           st.toFront();
//           R.safari();
//         };

		st[0].onclick = function(){
			window.location.href="http://www.thesefiftystates.org/state/"+st.name.replace(/\s+/g, '-');
		};
        st[0].onmouseover = function () {
    	  stateTooltip(st);
          st.toFront();
          st.g = st.glow({opacity: 0,color: "#FFF"});
          R.safari();
        };

// tooltip tutorial: http://return-true.com/examples/map-orig.html
        st[0].onmouseout = function () {
         // jQuery("#tooltip").removeClass("active");
          st.g.remove();
          st.toFront();
          R.safari();
        };
                   

      })(usRaphael[state], state);
    }


    function insertState()
    {
    	state = active.pop();
    	// Palette: #13638F,#C20712
    	colors = ["#ED2632","#C20712","#ff8088"];//"#FF3E49"];
    	darkRed = "#C20712";
    	mediumRed = "#ED2632";
    	lightRed = "#FF3E49";
    	randomColor = colors[Math.round(Math.random()*2)];
    	//randomColor = "url('img/stripe_dense.png')"
    	usRaphael[state].active = 1;
    	usRaphael[state].color = randomColor;
    	usRaphael[state].animate({fill:randomColor},500);
    	if(active.length>0) setTimeout(insertState,50);
    }
    insertState();
  });
  
</script>