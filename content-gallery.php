<?php
 get_header(); 
 ?>
			<div class="main">
				<div class="gallery">
				<?php if (have_posts()) : ?> 
					<?php while (have_posts()) : the_post(); ?>
					<figure class="photo">
					
					</figure>
					<div class="gallery-turn left"><i class="fa fa-angle-left fa-5x"></i></div>
					<div class="gallery-turn right"><i class="fa fa-angle-right fa-5x"></i></div>
					<div class="gallery-caption">
						<h1><?php the_title(); ?></h1>
						<?php the_excerpt();?>
						<?php 
							the_post_navigation( array(
								'prev_text'                  => __( '<span class="icon-mobile"><i class="fa fa-chevron-circle-left"></i></span><span class="icon-pc"><i class="fa fa-long-arrow-left"></i>&nbsp;&nbsp;%title</span>' ),
								'next_text'                  => __( '<span class="icon-mobile"><i class="fa fa-chevron-circle-right"></i><span  class="icon-pc">%title&nbsp;&nbsp;<i class="fa fa-long-arrow-right"></i></span>' ),
								'in_same_term'               => true,
								'screen_reader_text' => __( 'Continue Reading' ),
							) );
						?>
					</div>
				</div>
				<div class="photolist">
					<ul>
					<?php 
					if ( get_post_gallery() ) :
					$gallery = get_post_gallery( get_the_ID(), false );
					$gallery = explode(',',$gallery['ids']);
					foreach( $gallery as $id ){
						$thumb = wp_get_attachment_image_src($id);
						$full = wp_get_attachment_image_src($id,'full');
						echo '<li data-img="'.$full[0].'" data-width="'.$full[1].'" data-height="'.$full[2].'"><img src="'.$thumb[0].'"></li>';
					}
					endif;?>
					</ul>
				</div>
				<?php endwhile; ?>
				<?php endif; ?> 
			