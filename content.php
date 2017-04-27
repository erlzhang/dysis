<div class="main main-content">
	<div class="content-wrap">
	<?php if (have_posts()) : ?> 
	<?php while (have_posts()) : the_post(); ?>
		<nav class="breadcrumbs">
			<?php if(function_exists('cmp_breadcrumbs')) cmp_breadcrumbs();?>
		</nav>
		<article class="content">
			<header class="content-header">
				<h1><?php the_title(); ?></h1>
				<p class="small"><em><i class="fa fa-clock-o"></i>&nbsp;&nbsp;<?php the_time('Y-m-d H:i') ?></em><?php edit_post_link('编辑','<em><i class="fa fa-pencil-square-o"></i>','</em>'); ?></p>
			</header>
			<?php the_content(); ?>  
			<footer class="content-footer">
				<span class="tags"><?php the_tags('', '', ''); ?></span>
				<div class="post-options">
					<li class="post-like">
					<?php $postlike = get_post_meta( $post->ID, "post_like",true);?>
						<span id="icon-heart-number" class="icon-number" <?php if( !$postlike ){ echo "style=\"opacity:0;\"";} ?>><?php echo $postlike;?></span>
						<i class="fa fa-heart fa-fw<?php $name = "wp_erlimpostlike_".$post->ID; if($_COOKIE[$name] == 1){echo " post-like-on";}?>" onclick="addLike(<?php echo $post->ID;?>);" ></i>
					</li>
				</div>
			</footer>
		</article>
		<?php 
			the_post_navigation( array(
				'prev_text'                  => __( '<i class="fa fa-long-arrow-left"></i>&nbsp;&nbsp;%title' ),
				'next_text'                  => __( '%title&nbsp;&nbsp;<i class="fa fa-long-arrow-right"></i>' ),
				'in_same_term'               => true,
				'screen_reader_text' => __( 'Continue Reading' ),
			) );
		?>
		<?php comments_template(); ?>
		<?php endwhile; ?>
		<?php endif; ?> 