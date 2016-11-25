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
					</div>
				</div>
				<div class="photolist">
					<ul>
					<?php 
					if ( get_post_gallery() ) :
					$gallery = get_post_gallery( get_the_ID(), false );
					foreach( $gallery['src'] AS $src ){?>
						<li><img src="<?php echo $src;?>" /></li>
						<?php
					}endif;?>
					</ul>
				</div>
				<?php endwhile; ?>
				<?php endif; ?> 
			