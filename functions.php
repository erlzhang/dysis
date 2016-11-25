<?php

add_filter( 'show_admin_bar', '__return_false' );
//特色图片
add_theme_support( 'post-thumbnails' );

//加载所需css
function _add_theme_css(){
	wp_enqueue_style( 'fontawesome', get_template_directory_uri() . '/css/font-awesome.min.css' );
	wp_enqueue_style( 'themedefault', get_template_directory_uri() . '/style.css' );  
	if(is_home()){
		wp_enqueue_style( 'homepage', get_template_directory_uri() . '/css/index.css' );  
	}
	if( is_single() ){
		if( has_post_format( 'gallery') ){
			wp_enqueue_style( 'theme-gallery', get_template_directory_uri() . '/css/gallery.css' );  
		}else{
			wp_enqueue_style( 'theme-post', get_template_directory_uri() . '/css/post.css' );  
			wp_enqueue_style( 'comments', get_template_directory_uri() . '/css/comment.css' );  
		}
	}
	if( is_category() ){
		if(is_category('5')){
			wp_enqueue_style( 'theme-photography', get_template_directory_uri() . '/css/photography.css' );  
		}else if(is_category('10')){
			wp_enqueue_style( 'theme-portfolio', get_template_directory_uri() . '/css/portfolio.css' );  
		}else{
			wp_enqueue_style( 'theme-article', get_template_directory_uri() . '/css/article.css' );  
		}
	}
	
}
add_action( 'wp_enqueue_scripts', '_add_theme_css'); 

//加载所需js
function _add_theme_script(){
	wp_enqueue_script( 'theme-jquery', get_template_directory_uri() . '/js/jquery.min.js' );
	wp_enqueue_script( 'theme-common', get_template_directory_uri() . '/js/common.js' );
	if(is_home()){
		wp_enqueue_script( 'theme-slide', get_template_directory_uri() . '/js/jquery.slide.js' );
	}
	if(is_single()){
		if( has_post_format( 'gallery') ){
			wp_enqueue_script( 'theme-slide', get_template_directory_uri() . '/js/jquery.slide.js' );
			wp_enqueue_script( 'theme-gallery', get_template_directory_uri() . '/js/gallery.js' );
		}else{
			wp_enqueue_script( 'contentmenu', get_template_directory_uri() . '/js/contentmenu.js' );
			wp_enqueue_script( 'comment', get_template_directory_uri() . '/js/comment.js' );
		}
	}
	wp_localize_script('theme-common','Myajax',array(
				"ajaxurl" => admin_url('admin-ajax.php')
			));
}
add_filter( 'wp_footer', '_add_theme_script'); 

//去除头部不必要信息
function remove_head_things(){
	remove_action( 'wp_head', 'feed_links', 2 ); 
	remove_action( 'wp_head', 'feed_links_extra', 3 );
	remove_action( 'wp_head', 'rsd_link' );
	remove_action( 'wp_head', 'wlwmanifest_link' );
	remove_action( 'wp_head', 'index_rel_link' );
	remove_action('wp_head', 'parent_post_rel_link', 10, 0 );//清除前后文信息
	remove_action('wp_head', 'start_post_rel_link', 10, 0 );//清除前后文信息
	remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0 );
	remove_action( 'wp_head', 'noindex', 1 );
	remove_action( 'wp_head', 'wp_generator' ); //移除WordPress版本
	remove_action( 'wp_head', 'rel_canonical' );
	remove_action( 'wp_head', 'wp_shortlink_wp_head', 10, 0 );
	remove_action( 'template_redirect', 'wp_shortlink_header', 11, 0 );
	remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
	remove_action( 'wp_print_styles', 'print_emoji_styles' );
	remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
	remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
	remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
}
add_action( 'init', 'remove_head_things' );

//文章形式
add_theme_support( 'post-formats', array(
		'gallery','link'
	) );

//图片自适应
function remove_width_attribute( $html ) {
   $html = preg_replace( '/(width|height)="\d*"\s/', "", $html );
   return $html;
}
add_filter( 'post_thumbnail_html', 'remove_width_attribute', 10 );
add_filter( 'image_send_to_editor', 'remove_width_attribute', 10 );
function remove_width_height_attribute($content){ 
	preg_match_all("/<[img|IMG].*?src=[\'|\"](.*?(?:[\.gif|\.jpg|\.png\.bmp]))[\'|\"].*?[\/]?>/", $content, $images); 
	if(!empty($images)) { 
		foreach($images[0] as $index => $value){ 
			$new_img = preg_replace('/(width|height)="\d*"\s/', "", $images[0][$index]); 
			$content = str_replace($images[0][$index], $new_img, $content); 
		} 
	} 
	return $content; 
} 
add_filter('the_content', 'remove_width_height_attribute', 99); 

//增强默认编辑器

function Bing_editor_buttons($buttons){
	$buttons[] = 'fontselect';
	$buttons[] = 'fontsizeselect';
	$buttons[] = 'backcolor';
	$buttons[] = 'underline';
	$buttons[] = 'hr';
	$buttons[] = 'sub';
	$buttons[] = 'sup';
	$buttons[] = 'cut';
	$buttons[] = 'copy';
	$buttons[] = 'paste';
	$buttons[] = 'cleanup';
	$buttons[] = 'wp_page';
	$buttons[] = 'newdocument';
	return $buttons;
}
add_filter("mce_buttons_3", "Bing_editor_buttons");

//gravatar被墙恢复
function get_ssl_avatar($avatar) {
   $avatar = preg_replace('/.*\/avatar\/(.*)\?s=([\d]+)&.*/','<img src="https://secure.gravatar.com/avatar/$1?s=50&d=mm" class="avatar">',$avatar);
   return $avatar;
}
add_filter('get_avatar', 'get_ssl_avatar');

//AJAX评论

if( !is_admin() ){
	add_action('wp_ajax_submit_comment', 'theme_submit_comment');
	add_action('wp_ajax_nopriv_submit_comment', 'theme_submit_comment');
	add_action('wp_ajax_get_avatar', 'ajax_get_avatar');
	add_action('wp_ajax_nopriv_get_avatar', 'ajax_get_avatar');
}

function ajax_get_avatar() {
	$avatar = get_avatar( $_POST['email'] );
	echo $avatar;
	die(); // this is required to return a proper result
}

function theme_submit_comment() {
	$comment = wp_handle_comment_submission( wp_unslash( $_POST ) );
	if ( is_wp_error( $comment ) ) {
		$data = intval( $comment->get_error_data() );
		if ( ! empty( $data ) ) {
			wp_die( '<p id="comment-error">' . $comment->get_error_message() . '</p>', __( 'Comment Submission Failure' ), array( 'response' => $data, 'back_link' => true ) );
		} else {
			exit;
		}
	}?>
	<li id="comment-<?php echo $comment->comment_ID; ?>" class="comment comment-loading"  data-parent="<?php echo $comment->comment_parent;?>">
		<div id="div-comment-<?php echo $comment->comment_ID; ?>" class="comment-body">
			<div class="comment-author vcard">
				<?php echo get_avatar( $comment->comment_author_email );?>			
				<cite class="fn"><?php comment_author_link($comment->comment_ID); ?></cite><span class="says">说道：</span>		
			</div>
			<div class="comment-meta commentmetadata">
				<a href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ); ?>">
				 <?php comment_date('n-j-Y');?></a>		
			</div>
			<?php comment_text($comment->comment_ID); ?>
			<div class="reply"></div>
		</div>
	</li>
<?php 	
	$user = wp_get_current_user();
	do_action( 'set_comment_cookies', $comment, $user );
	die();		
}

?>
