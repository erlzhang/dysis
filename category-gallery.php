<?php get_header();?>
<div class="main">
	<div class="photos">
	<?php if (have_posts()) : ?> 
	<?php while (have_posts()) : the_post(); ?>
		<a href="<?php the_permalink(); ?>"><figure>
			<?php the_post_thumbnail();?>
			<figcaption>
				<p class="small"><time><i class="fa fa-clock-o"></i>&nbsp;&nbsp;<?php the_time('Y-m-d H:i') ?></time></p>
				<h3><?php the_title(); ?></h3>
				<?php the_excerpt();?>
			</figcaption>
		</figure></a>
		<?php endwhile; endif;?>
	</div>
<?php get_footer();?>