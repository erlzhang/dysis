<?php
get_header(); 
?>
<div class="main">
	<div class="top">
		<h1><?php echo get_bloginfo('name');?><small><?php echo get_bloginfo('description');?></small></h1>
	</div>
	<div class="photography">
		<div class="pic_list">
		</div>
	</div>
	<div class="posts">
		<?php if (have_posts()) :
			$i = 1;
			while (have_posts()) : 
			$i++;
			the_post();?>
		<article class="article <?php if($i%2 != 0){ echo 'odd';}?>">
			<a href="<?php the_permalink();?>"><div class="article-thumb">
			<?php dysis_post_thumbnail();?>
			<img class="post_thumbmail" data-original="<?php echo $thumb;?>" />
			</div></a>
			<div class="article-content">
			<?php the_title( sprintf( '<a href="%s" rel="bookmark"><h1>', esc_url( get_permalink() ) ), '</h1></a>' );?>
			<p class="small"><em><span class="icon icon-calendar"></span>&nbsp;<?php the_time('Y-m-d H:i') ?></em></p>
			<?php the_excerpt();?>
			 <a href="<?php the_permalink();?>" class="more-link">阅读全文</a>
			 </div>
		</article>
			<?php endwhile; ?>
			<?php dysis_posts_pagination(); ?>
			<?php endif; ?>
		</div>
	</div>
<?php get_footer();?>