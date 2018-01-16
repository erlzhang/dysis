<?php get_header();?>
<div class="main">
	<div class="books">
		<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
		<a href="<?php the_permalink(); ?>">
		<?php $full_image_url = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'full');?>
			<div class="book" style="background-image:url(<?php echo $full_image_url[0];?>">
				<div class="book-header">
					<h1><?php the_title(); ?></h1>
					<?php the_content(); ?>
				</div>
			</div>
		</a>
		<?php endwhile; ?>
		<?php endif;?>
	</div>
<?php get_footer();?>
