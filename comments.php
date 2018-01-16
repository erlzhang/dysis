<?php
	if (!empty($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
		die ('请勿直接加载此页。谢谢！');
	if ( post_password_required() ) { ?>
		<p class="nocomments"><?php _e('必须输入密码，才能查看评论！'); ?></p>
	<?php
		return;
	}
?>
<?php if ('open' == $post->comment_status) : ?>
<div id="comments" class="comments-area">
	<div class="response-show-btn" id="response-show-btn"><i class="fa fa-edit"></i></div>
	<div id="respond" class="response">
    <form action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post" id="commentform">
		<div id="bottom-comment-mask" class="bottom-comment-mask"></div>
	  <div class="bottom-comment-bar">
		  <div class="respond-box">
			<div class="comment-author-info">
				<div class="comment-author-avatar">
					<?php 
					if( $user_ID ){
						echo get_avatar($user_ID);
					}else if( '' != $comment_author_email ){
						echo get_avatar($comment_author_email);
					}else{
						echo '<img src="https://secure.gravatar.com/avatar/aae066320acf9cfddf355c97fa345d4c?s=32&d=mm&f=y&r=g" class="avatar" width="40" height="40">';
					}
					?>
				</div>
				<div class="comment-author-tooltip">
					<?php if( $user_ID ) {
						echo "你好，<a href=\"".get_option('siteurl')."/wp-admin/profile.php\">".$user_identity."</a>!&nbsp;&nbsp;&nbsp;&nbsp;<a href=".wp_logout_url(get_permalink())." title=\"退出\" class=\"change-identity\">[ 退出登陆 ]</a>";
					}else{
						echo "你好，<span id=\"current-comment-author\">";
						if( '' != $comment_author ){
							echo $comment_author;
						}else{
							echo "游客";
						}
						echo "</span>！（点击更改信息）";
					}
					?>
				</div>
			</div>
				
					<?php if ( ! $user_ID ): ?>
					<div class="comment-author-input-mask"></div>
					<div class="comment-author-input">
						<div class="comment-author-input-avatar">
							<?php 
							if( $user_ID ){
								echo get_avatar($user_ID);
							}else if( '' != $comment_author_email ){
								echo get_avatar($comment_author_email);
							}else{
								echo '<img src="https://secure.gravatar.com/avatar/aae066320acf9cfddf355c97fa345d4c?s=32&d=mm&f=y&r=g" class="avatar" width="40" height="40">';
							}
							?>
						</div>
						<p class="gray">您的电子邮件不会被公布，带*为必填。</p>
						<li>
							<label for="author"><small><span class="icon icon-user"></span></small></label>
							<input type="text" name="author" id="author" class="input-text" value="<?php echo $comment_author; ?>" size="22" tabindex="1" placeholder="Name*" />
						</li>
						<li>
							<label for="email"><small><span class="icon icon-envelope"></span></small></label>
							<input type="text" name="email" id="email" class="input-text" value="<?php echo $comment_author_email; ?>" size="22" placeholder="Email*" tabindex="2" />
						</li>
						<li>
							<label for="url"><small><span class="icon icon-link"><span></small></label>
							<input type="text" name="url" id="url" class="input-text" value="<?php echo $comment_author_url; ?>" size="22"placeholder="http://"  tabindex="3" />
						</li>
					</div>
					<?php endif;?>
				<textarea name="comment" id="comment" class="textarea" rows="1"  placeholder="要说点什么么……" tabindex="4" rows="1"></textarea>
				<button class="submit" name="submit" type="submit" id="submit" tabindex="5" disabled="disabled"><span class="icon icon-paperplane"></span></button>
				<div class="smiley" id="comment-smiley">
					<?php include("smiley.php");?>
				</div>
			</div>
			<?php comment_id_fields(); ?>
			<?php do_action('comment_form', $post->ID); ?>
			<div class="respond-status">
				<div id="loading" class="loading"><span class="icon icon-spinner icon-spin"></span>&nbsp;&nbsp;正在提交中，请稍候...</div>
				<div id="error" class="warning"></div>
				<div id="success" class="success"><span class="icon icon-check"></span>&nbsp;&nbsp;评论提交成功</div>
				<div id="replying" class="info">回复 <strong id="replying-parent"></strong> 的评论,点击取消回复。</div>
			</div>
		</div>
    </form>
  </div>
	
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
<?php endif; ?>