<?php
get_header(); ?>

		<section id="primary">
			<div id="content" class="home" role="main">
			<h1 id="intro-text">Stories from coast to coast.</h1>
			<div id="map"></div>
						
			<div class="archive-list">

				<?php 
				$issues_cat = get_category_by_slug('issues');
				$categories = get_categories( array( 
					'orderby' => 'slug',
					'order' => 'DESC',
					'hide_empty' =>true,
					'number' => 2,
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
				endforeach; ?>
			
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
  <div id="tooltip">
  	<h3>StateNameHere</h3>
  	<a href="#" class="state-link"><span id="article-count">0 Articles</span></a>
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
    	jQuery("#tooltip").hide();
	if(st.active!=1){
		return;
	}
	bounds = st.getBBox();
	bottomCenterX = (bounds.x+bounds.x2)/2 + mapX;
	bottomCenterY = bounds.y2 + mapY;
	
	middleRightX = bounds.x2 + mapX;
	middleRightY = (bounds.y+bounds.y2)/2 + mapY;
	
	// bottomCenter Tooltip Position:
	// tooltipX = bottomCenterX - jQuery("#tooltip").width()/2; // top left
	// tooltipY = bottomCenterY;
	
	// Set x-axis biases
	var xBias = 0;
	switch(st.abbreviation){
		case "ca":
			xBias = 35; break;
		case "ny":
			xBias = 15; break;
		case "ak":
			xBias = 35; break;
	}
	
	// middleRight Tooltip Position
	tooltipX = middleRightX - 3 - xBias;
	tooltipY = middleRightY - jQuery("#tooltip").innerHeight()/2;
	
	// Set position
	jQuery("#tooltip").css({
		"left":tooltipX,
		"top":tooltipY
	});
	
	// Add Title
	jQuery("#tooltip h3").text(st.name);
	
	// Include article count (inflect if plural)
	if(st.count==1){
		jQuery("#tooltip #article-count").text("1 Story");
	} else{
		jQuery("#tooltip #article-count").text(st.count+' Stories');
	}

	jQuery("#tooltip").addClass("active");
	jQuery("#tooltip").fadeIn(250);
    };
    
    var active = [<?php $terms=get_terms('state',array('hide_empty'=>true));
if  ($terms) {
  foreach ($terms  as $term ) {
  	echo json_encode(array( 
  		"abbreviation" => $term->slug,
  		"name" => $term->name, 
  		"count"=>$term->count)).',';
  }
}
?>];

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
			window.location.href="<?php home_url('/');?>state/"+state;
		};
        st[0].onmouseover = function (){
    	  stateTooltip(st);
          st.toFront();
          st.g = st.glow({opacity: 0,color: "#FFF"});
          R.safari();
        };

// tooltip tutorial: http://return-true.com/examples/map-orig.html
        st[0].onmouseout = function (){
          st.g.remove();
          st.toFront();
          R.safari();
        };

      })(usRaphael[state], state);
    }
    
    jQuery("#map").mouseleave(function(){
    	jQuery("#tooltip").hide();
    });

    function insertState()
    {
    	stateObject = active.pop();
    	state = stateObject.abbreviation;
    	// Palette: #13638F,#C20712
    	colors = ["#ED2632","#C20712","#ff8088"];//"#FF3E49"];
    	darkRed = "#C20712";
    	mediumRed = "#ED2632";
    	lightRed = "#FF3E49";
    	randomColor = colors[Math.round(Math.random()*2)];
    	//randomColor = "url('img/stripe_dense.png')"
    	usRaphael[state].active = 1;
    	usRaphael[state].count = stateObject.count;
    	usRaphael[state].abbreviation = stateObject.abbreviation;
    	usRaphael[state].color = randomColor;
    	usRaphael[state].animate({fill:randomColor},500);
    	if(active.length>0) setTimeout(insertState,50);
    }
    insertState();
  });
  
</script>

<script src="<?php echo bloginfo('template_directory');?>/js/states.js"></script>
