<?php get_header();?>
	 <div class="main novel-index">
		<div class="novel-left">
		<?php if (have_posts()) : ?> 
		<?php while (have_posts()) : the_post(); ?>
				<?php
				$dir = ABSPATH.'wp-content/novel/'.$post->post_name;
				$chapters = scandir($dir);
				$chapter_number = count($chapters)-2;
				?>
			<div class="novel-header">
				<h1><?php the_title(); ?></h1>
				<?php the_content(); ?>
				
				<script>
				var chapterURL = "<?php bloginfo('url'); ?>/wp-content/novel/<?php echo $post->post_name;?>/",count = <?php echo $chapter_number;?>;
				</script>
			</div>
			<div class="toggle-novel-catalog" id="toggle-novel-catalog"><i class="fa fa-th-large"></i><em>章节</em></div>
			<div class="novel-catalog">
				<div class="novel-catalog-inner">
					<h3><span id="novel-catalog-off" class="mobile-off"><i class="fa fa-angle-left"></i></span>选择章节</h3>
					<?php 
					for ( $i = 1; $i <= $chapter_number ; $i++){
						echo '<a href="#'.$i.'" onclick="showChapter('.$i.')">'.$i.'</a>';
					}
					?>
				</div>
			</div>
			<?php endwhile; ?>
			<?php endif; ?> 
		</div>
		<div class="novel-right">
			<article class="content">
				<h1>Chapter <span id="chapter-title-id"></span></h1>
				<div class="chapter-content" id="chapter-content">
				</div>
				<nav class="chapter-nav-links" id="chapter-nav-links">
				</nav>
			</article>
		</div>
		<?php wp_footer();?>
	</body>
</html>
