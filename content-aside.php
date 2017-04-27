<div class="main">
	<div class="novel-left">
		<div class="novel-header">
			<h1>乐园 Paradise</h1>
			<p>“只有人，他的寿命不会很长，无论他做什么，都只是一场虚无。”</p>
			<span class="toggle-novel-catalog"><i class="fa fa-th"></i><em>章节列表</em></span>
		</div>
		
		<div class="novel-catalog">
			<?php 
			$chapters = new WP_Query( 'cat=19&posts_per_page=-1&order=ASC' );
			 if ( $chapters -> have_posts() ) :  $cha_ID = 0;
			?>
			<?php while ( $chapters -> have_posts() ) : $chapters ->the_post();?>
			<a href="<?php the_permalink(); ?>">
			<?php 
			echo ++$cha_ID;
			?>
			</a>
			<?php endwhile; endif; wp_reset_query();?>
		</div>
	</div>
	<div class="novel-right">
		<?php if (have_posts()) : ?> 
		<?php while (have_posts()) : the_post(); ?>
		<article class="content">
			<h2><?php the_title(); ?></h2>
			<?php the_content(); ?>  
			<?php 
				the_post_navigation( array(
					'prev_text'                  => __( '<i class="fa fa-long-arrow-left"></i>&nbsp;&nbsp;上一章' ),
					'next_text'                  => __( '下一章&nbsp;&nbsp;<i class="fa fa-long-arrow-right"></i>' ),
					'in_same_term'               => true,
					'screen_reader_text' => __( 'Continue Reading' ),
				) );
				?>
		</article>
		<?php comments_template(); ?>	
		<?php endwhile; ?>
		<?php endif; ?> 
	</div>