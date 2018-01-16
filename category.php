<?php get_header();?>
<div class="main">
	<div class="posts">		<?php $category = get_the_category()[0];		$category_list_id = $category -> category_parent ? $category -> category_parent : $category -> cat_ID;?>		<nav class="sub-category">			<ul>				<?php wp_list_categories("title_li=&hide_title_if_empty=true&child_of=".$category_list_id."&current_category=".$category -> cat_ID); ?>			</ul>		</nav>
	<?php if (have_posts()) : $i = 1;?>		
		<nav class="breadcrumbs">
			<?php if(function_exists('cmp_breadcrumbs')) cmp_breadcrumbs();?>
		</nav>		<?php if ( category_description() ):?>
			<div class="category-description">
				<?php echo category_description();?> 
			</div>		<?php endif;?>
		<?php while (have_posts()) : $i++; the_post();?>
	<article class="article <?php if($i%2 == 1){ echo 'odd';}?>">
		<a href="<?php the_permalink(); ?>">			<div class="article-thumb">
				<?php dysis_post_thumbnail(); ?>
			</div>		</a>
		<div class="article-content">
			<?php the_title( sprintf( '<a href="%s" rel="bookmark"><h1>', esc_url( get_permalink() ) ), '</h1></a>' );?>
			<p class="small"><em><i class="fa fa-clock-o"></i>&nbsp;<?php the_time('Y-m-d H:i') ?></em></p>
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