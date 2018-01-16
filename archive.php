<?php get_header();?>
<div class="main">
	<div class="posts">
	<?php if (have_posts()) :?>
		<nav class="breadcrumbs">
			<?php if(function_exists('cmp_breadcrumbs')) cmp_breadcrumbs();?>
		</nav>
	<?php $i = 1;while (have_posts()) : $i++;the_post();?>
	<article class="article <?php if($i%2 != 0){ echo 'odd';}?>">
		<a href="<?php the_permalink(); ?>"><div class="article-thumb">
		<?php dysis_post_thumbnail(); ?>
		</div></a>
		<div class="article-content">
			<?php the_title( sprintf( '<a href="%s" rel="bookmark"><h1>', esc_url( get_permalink() ) ), '</h1></a>' );?>
			<?php the_excerpt();?>
			 <a href="<?php 
					if(has_post_format('link')){
						echo get_url_in_content( get_the_content() );
					}else{
						the_permalink();
					}
			 ?>" class="more-link">阅读全文</a>
		 </div>
	</article>
		<?php endwhile; ?>
			<?php dysis_posts_pagination(); ?>
			<?php endif;?>
	</div>
<?php get_footer();?>