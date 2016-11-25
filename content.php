<div class="main main-content">
	<div class="content-wrap">
	<?php if (have_posts()) : ?> 
	<?php while (have_posts()) : the_post(); ?>
		<article class="content">
			<header class="content-header">
				<h1><?php the_title(); ?></h1>
				<p class="small"><em><i class="fa fa-clock-o"></i>&nbsp;&nbsp;<?php the_time('Y-m-d H:i') ?></em></p>
			</header>
			<?php the_post_thumbnail();?>
			<?php the_content(); ?>  
			<footer class="content-footer">
				<span class="tags"><?php the_tags('', '', ''); ?></span>
			</footer>
		</article>
		<?php comments_template(); ?>	
		<?php endwhile; ?>
		<?php endif; ?> 