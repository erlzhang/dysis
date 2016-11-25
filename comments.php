<?php
if ( post_password_required() ) {
	return;
}
?>

<div id="comments" class="comments-area">
	<div id="respond" class="response">
	<?php if ('open' == $post->comment_status) : ?>
    <form action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post" id="commentform">
	  <div class="bottom-comment-bar show <?php if(!$user_ID && ($comment_author_email == '' || $comment_author == '' )){ echo 'forbid';} ?>">
		  <div class="respond-box">
				<div class="comment-author-avatar"><?php 
				if( $user_ID ){
					echo get_avatar($user_ID);
				}else if( '' != $comment_author_email ){
					echo get_avatar($comment_author_email);
				}else{
					echo '<img src="http://secure.gravatar.com/avatar/aae066320acf9cfddf355c97fa345d4c?s=32&d=mm&f=y&r=g" class="avatar" width="50" height="50">';
				}
				?>
				</div>
				<div class="comment-author-info-mask"></div>
				<div class="comment-author-info">
				<?php if ( ! $user_ID ): ?>
					<div class="comment-author-input">
						<li>
							<label for="author"><small><i class="fa fa-user"></i></small></label>
							<input type="text" name="author" id="author" class="input-text" placeholder="Name"  value="<?php echo $comment_author; ?>" size="22" tabindex="1" placeholder="Name*" />
						</li>
						<li>
							<label for="email"><small><i class="fa fa-envelope"></i></small></label>
							<input type="text" name="email" id="email" class="input-text" value="<?php echo $comment_author_email; ?>" size="22" placeholder="Email*" tabindex="2" />
						</li>
						<li>
							<label for="url"><small><i class="fa fa-globe"></i></small></label>
							<input type="text" name="url" id="url" class="input-text" value="<?php echo $comment_author_url; ?>" size="22"placeholder="http://"  tabindex="3" />
						</li>
					</div>
					<?php else : ?>
						<p>你好，<a href="<?php echo get_option('siteurl'); ?>/wp-admin/profile.php"><?php echo $user_identity; ?></a>!&nbsp;&nbsp;<a href="<?php echo wp_logout_url(get_permalink()); ?>" title="退出" class="change-identity"><?php print '<i class="fa fa-sign-out"></i>&nbsp;&nbsp;退出登陆'; ?></a></p>
						
					<?php endif;?>
				</div>
				<div class="respond-status">
					<div id="loading" class="loading"><i class="fa fa-spinner fa-spin"></i>&nbsp;&nbsp;正在提交中，请稍候...</div>
					<div id="error" class="warning"></div>
					<div id="success" class="success"><i class="fa fa-check"></i>&nbsp;&nbsp;评论提交成功</div>
					<div id="replying" class="info">回复 <strong id="replying-parent"></strong> 的评论,点击取消回复。</div>
				</div>
				<textarea name="comment" id="comment" class="textarea" rows="1"  placeholder="要说点什么么……" tabindex="4"></textarea>
				<input class="submit" name="submit" type="submit" id="submit" tabindex="5" value="留言" />
			</div>
			<?php comment_id_fields(); ?>
			<?php do_action('comment_form', $post->ID); ?>
		</div>
    </form>
  </div>
	<?php endif; ?>
	<?php if ( have_comments() ) : ?>
		<ul class="comment-list">
			<?php
				wp_list_comments( array(
					'style'       => 'ul',
					'short_ping'  => true,
					'avatar_size' => 50,
				) );
			?>
		</ul><!-- .comment-list -->
	<?php endif; // have_comments() ?>
</div><!-- .comments-area -->
