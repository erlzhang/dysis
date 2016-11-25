<?php
get_header(); 
?>
<div class="main">
	<div class="top">
		<h1><?php echo get_bloginfo('name');?><small><?php echo get_bloginfo('description');?></small></h1>
	</div>
	<div class="photography">
		<div class="pic_list">
			<?php 
			$photography = new WP_Query( 'cat=5&posts_per_page=7' );
			 if ( $photography -> have_posts() ) :
			?>
			<?php while ( $photography -> have_posts() ) : $photography ->the_post();?>
			 
			<a href="<?php the_permalink() ?>">
				<figure>
					<?php the_post_thumbnail();?>
					<figcaption>
						<h2><?php the_title();?></h2>
					</figcaption>
				</figure>
			</a>
			<?php endwhile; endif; wp_reset_query();?>
		</div>
	</div>
	<div class="philography">
			<?php 
			$philography = new WP_Query( 'cat=10&posts_per_page=3' );
			 if ( $philography -> have_posts() ) :
			?>
			<?php while ( $philography -> have_posts() ) : $philography ->the_post();?>
		<a href="<?php 
					if(has_post_format('link')){
						echo get_url_in_content( get_the_content() );
					}else{
						the_permalink();
					}
			 ?>"><div class="panel">
			<div class="panel-thumb"><?php the_post_thumbnail();?>
			</div>
			<div class="panel-content">
				<i class="fa fa-<?php 
				$fa_icon = get_post_meta($post->ID,"fa-icon",true);
				echo $fa_icon
				
				?> panel-icon"></i>
				<h3><?php the_title();?></h3>
				<?php the_excerpt();?>
			</div>
		</div></a>
		<?php endwhile; endif; wp_reset_query();?>
	</div>
	<div class="posts">
		<?php $blog = new WP_Query('cat=1&posts_per_page=2');?>
		<?php if ($blog -> have_posts()) :
			$i = 1;
			while ($blog -> have_posts()) : 
			$i++;
			$blog -> the_post();?>
		<article class="article <?php if($i%2 == 0){ echo 'odd';}?>">
			<a href="<?php the_permalink();?>"><div class="article-thumb"><?php the_post_thumbnail();?>
			</div></a>
			<div class="article-content">
			<?php the_title( sprintf( '<a href="%s" rel="bookmark"><h1>', esc_url( get_permalink() ) ), '</h1></a>' );?>
			<?php the_excerpt();?>
			 <a href="<?php the_permalink();?>" class="more-link">阅读全文</a>
			 </div>
		</article>
			<?php endwhile; endif;  wp_reset_query();?>
		</div>
	</div>
<?php get_footer();?>