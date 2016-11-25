<?php get_header();?>
<div class="main">
	<div class="portfolio">
	<?php if (have_posts()) : while (have_posts()) : the_post();?>
	<a href="<?php 
			if(has_post_format('link')){
				echo get_url_in_content( get_the_content() );
			}else{
				the_permalink();
			}
	 ?>"><figure>
		<?php the_post_thumbnail();?>
			<figcaption><?php the_title('<h2>', '</h2>' );?>
		<?php the_excerpt();?></figcaption>
		 </figure></a>
		<?php endwhile; endif;?>
	</div>
<?php get_footer();?>