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
		wp_enqueue_style( 'theme-article', get_template_directory_uri() . '/css/article.css' );  		
	}
	if( is_single() ){
		if ( 'book' == get_post_type() ){
			wp_enqueue_style( 'novel', get_template_directory_uri() . '/css/novel.css' );
		}else if( has_post_format( 'gallery') ){
			wp_enqueue_style( 'theme-gallery', get_template_directory_uri() . '/css/gallery.css' );  
		}else{
			wp_enqueue_style( 'theme-post', get_template_directory_uri() . '/css/post.css' );  
			wp_enqueue_style( 'highlight', get_template_directory_uri() . '/css/tomorrow.css' );  
			wp_enqueue_style( 'comments', get_template_directory_uri() . '/css/comment.css' );  
		}
	}
	if( is_archive() ){
		if( is_post_type_archive( 'book' ) ){
			wp_enqueue_style( 'book', get_template_directory_uri() . '/css/book.css' );  
		}else if(is_category('5')){
			wp_enqueue_style( 'theme-photography', get_template_directory_uri() . '/css/photography.css' );  
		}else{
			wp_enqueue_style( 'theme-article', get_template_directory_uri() . '/css/article.css' );  
		}
	}
	if( is_404() ){
		wp_enqueue_style( '404' , get_template_directory_uri() . '/css/404.css' );  
	}
	
}
add_action( 'wp_enqueue_scripts', '_add_theme_css'); 

//加载所需js
function _add_theme_script(){
	wp_enqueue_script( 'theme-jquery', get_template_directory_uri() . '/js/jquery.min.js' );
	wp_enqueue_script( 'theme-common', get_template_directory_uri() . '/js/common.js' );
	if(is_home()){
		wp_enqueue_script( 'theme-slide', get_template_directory_uri() . '/js/jquery.slide.js' );
		wp_enqueue_script( 'lazyload', get_template_directory_uri() . '/js/jquery.lazyload.min.js' );
	}

	if(is_single()){
		
		if ( 'book' == get_post_type() ){
			wp_enqueue_script( 'novel', get_template_directory_uri() . '/js/novel.js' );
		}else if( has_post_format( 'gallery') ){
			wp_enqueue_script( 'theme-slide', get_template_directory_uri() . '/js/jquery.slide.js' );
			wp_enqueue_script( 'theme-gallery', get_template_directory_uri() . '/js/gallery.js' );
		}else{
			wp_enqueue_script( 'highlight', get_template_directory_uri() . '/js/highlight.pack.js' );
			wp_enqueue_script( 'contentmenu', get_template_directory_uri() . '/js/contentmenu.js' );
			wp_enqueue_script( 'comment', get_template_directory_uri() . '/js/comment.js' );
		}
	}
	wp_localize_script('theme-common','Myajax',array("ajaxurl" => admin_url('admin-ajax.php')));
}
add_filter( 'wp_footer', '_add_theme_script'); 

//小说
include("post_type_book.php");

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
}
add_action( 'init', 'remove_head_things' );

//面包屑导航
function cmp_breadcrumbs() {
	$delimiter = '&frasl;'; // 分隔符
	$before = '<span class="current">'; // 在当前链接前插入
	$after = '</span>'; // 在当前链接后插入
	if ( !is_home() && !is_front_page() || is_paged() ) {
		echo '<div itemscope itemtype="http://schema.org/WebPage" id="crumbs">'.__( '<i class="fa fa-home"></i>' , 'cmp' );
		global $post;
		$homeLink = home_url();
		echo ' <a itemprop="breadcrumb" href="' . $homeLink . '"  title="返回首页">' . __( '首页' , 'cmp' ) . '</a> ' . $delimiter . ' ';
		if ( is_category() ) { // 分类 存档
			global $wp_query;
			$cat_obj = $wp_query->get_queried_object();
			$thisCat = $cat_obj->term_id;
			$thisCat = get_category($thisCat);
			$parentCat = get_category($thisCat->parent);
			if ($thisCat->parent != 0){
				$cat_code = get_category_parents($parentCat, TRUE, ' ' . $delimiter . ' ');
				echo $cat_code = str_replace ('<a','<a itemprop="breadcrumb" ', $cat_code );
			}
			echo $before . '' . single_cat_title('', false) . '' . $after;
		} elseif ( is_day() ) { // 天 存档
			echo '<a itemprop="breadcrumb"  href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time('Y') . '</a> ' . $delimiter . ' ';
			echo '<a itemprop="breadcrumb"  href="' . get_month_link(get_the_time('Y'),get_the_time('m')) . '">' . get_the_time('F') . '</a> ' . $delimiter . ' ';
			echo $before . get_the_time('d') . $after;
		} elseif ( is_month() ) { // 月 存档
			echo '<a itemprop="breadcrumb"  href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time('Y') . '</a> ' . $delimiter . ' ';
			echo $before . get_the_time('F') . $after;
		} elseif ( is_year() ) { // 年 存档
			echo $before . get_the_time('Y') . $after;
		} elseif ( is_single() && !is_attachment() ) { // 文章
			if ( get_post_type() != 'post' ) { // 自定义文章类型
				$post_type = get_post_type_object(get_post_type());
				$slug = $post_type->rewrite;
				echo '<a itemprop="breadcrumb"  href="' . $homeLink . '/' . $slug['slug'] . '/">' . $post_type->labels->name . '</a> ' . $delimiter . ' ';
				echo $before . get_the_title() . $after;
			} else { // 文章 post
				$cat = get_the_category(); $cat = $cat[0];
				$cat_code = get_category_parents($cat, TRUE, ' ' . $delimiter . ' ');
				echo $cat_code = str_replace ('<a','<a itemprop="breadcrumb" ', $cat_code );
				echo $before . get_the_title() . $after;
			}
		} elseif ( !is_single() && !is_page() && get_post_type() != 'post' ) {
			$post_type = get_post_type_object(get_post_type());
			echo $before . $post_type->labels->singular_name . $after;
		} elseif ( is_attachment() ) { // 附件
			$parent = get_post($post->post_parent);
			$cat = get_the_category($parent->ID); $cat = $cat[0];
			echo '<a itemprop="breadcrumb"  href="' . get_permalink($parent) . '">' . $parent->post_title . '</a> ' . $delimiter . ' ';
			echo $before . get_the_title() . $after;
		} elseif ( is_page() && !$post->post_parent ) { // 页面
			echo $before . get_the_title() . $after;
		} elseif ( is_page() && $post->post_parent ) { // 父级页面
			$parent_id  = $post->post_parent;
			$breadcrumbs = array();
			while ($parent_id) {
				$page = get_page($parent_id);
				$breadcrumbs[] = '<a itemprop="breadcrumb"  href="' . get_permalink($page->ID) . '">' . get_the_title($page->ID) . '</a>';
				$parent_id  = $page->post_parent;
			}
			$breadcrumbs = array_reverse($breadcrumbs);
			foreach ($breadcrumbs as $crumb) echo $crumb . ' ' . $delimiter . ' ';
			echo $before . get_the_title() . $after;
		} elseif ( is_search() ) { // 搜索结果
			echo $before ;
			printf( __( '“ %s ” 的搜索结果', 'cmp' ),  get_search_query() );
			echo  $after;
		} elseif ( is_tag() ) { //标签 存档
			echo $before ;
			printf( __( '%s', 'cmp' ), single_tag_title( '', false ) );
			echo  $after;
		} elseif ( is_author() ) { // 作者存档
			global $author;
			$userdata = get_userdata($author);
			echo $before ;
			printf( __( 'Author Archives: %s', 'cmp' ),  $userdata->display_name );
			echo  $after;
		} elseif ( is_404() ) { // 404 页面
			echo $before;
			_e( 'Not Found', 'cmp' );
			echo  $after;
		}
		if ( get_query_var('paged') ) { // 分页
			if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() )
				echo sprintf( __( ' ( 第 %s 页)', 'cmp' ), get_query_var('paged') );
		}
		echo '</div>';
	}
}

// 评论表情
function classic_smilies_src( $old, $img ) {
	return get_bloginfo('template_directory').'/smiley/'.$img;
}

add_action( 'init', 'classic_smilies_init', 1 );
	
function classic_smilies_init() {

	// put the classic smilies images back
	global $wpsmiliestrans;
	$wpsmiliestrans = array(
	':mrgreen:' => 'icon_mrgreen.png',
	':neutral:' => 'icon_neutral.png',
	':twisted:' => 'icon_twisted.png',
	  ':arrow:' => 'icon_arrow.png',
	  ':shock:' => 'icon_eek.png',
	  ':smile:' => 'icon_smile.png',
	    ':???:' => 'icon_confused.png',
	   ':cool:' => 'icon_cool.png',
	   ':evil:' => 'icon_evil.png',
	   ':grin:' => 'icon_biggrin.png',
	   ':idea:' => 'icon_idea.png',
	   ':oops:' => 'icon_redface.png',
	   ':razz:' => 'icon_razz.png',
	   ':roll:' => 'icon_rolleyes.png',
	   ':wink:' => 'icon_wink.png',
	    ':cry:' => 'icon_cry.png',
	    ':eek:' => 'icon_surprised.png',
	    ':lol:' => 'icon_lol.png',
	    ':mad:' => 'icon_mad.png',
	    ':sad:' => 'icon_sad.png',
	      '8-)' => 'icon_cool.png',
	      '8-O' => 'icon_eek.png',
	      ':-(' => 'icon_sad.png',
	      ':-)' => 'icon_smile.png',
	      ':-?' => 'icon_confused.png',
	      ':-D' => 'icon_biggrin.png',
	      ':-P' => 'icon_razz.png',
	      ':-o' => 'icon_surprised.png',
	      ':-x' => 'icon_mad.png',
	      ':-|' => 'icon_neutral.png',
	      ';-)' => 'icon_wink.png',
	// This one transformation breaks regular text with frequency.
	//     '8)' => 'icon_cool.png',
	       '8O' => 'icon_eek.png',
	       ':(' => 'icon_sad.png',
	       ':)' => 'icon_smile.png',
	       ':?' => 'icon_confused.png',
	       ':D' => 'icon_biggrin.png',
	       ':P' => 'icon_razz.png',
	       ':o' => 'icon_surprised.png',
	       ':x' => 'icon_mad.png',
	       ':|' => 'icon_neutral.png',
	       ';)' => 'icon_wink.png',
	      ':!:' => 'icon_exclaim.png',
	      ':?:' => 'icon_question.png',
	);

	add_filter( 'smilies_src', 'classic_smilies_src', 10, 2 );
	
	// disable any and all mention of emoji's
	remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
	remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
	remove_action( 'wp_print_styles', 'print_emoji_styles' );
	remove_action( 'admin_print_styles', 'print_emoji_styles' );	
	remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
	remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );	
	remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
	add_filter( 'tiny_mce_plugins', 'classic_smilies_rm_tinymce_emoji' );
	add_filter( 'the_content', 'classic_smilies_rm_additional_styles', 11 );
	add_filter( 'the_excerpt', 'classic_smilies_rm_additional_styles', 11 );
	add_filter( 'comment_text', 'classic_smilies_rm_additional_styles', 21 );
}

// filter function used to remove the tinymce emoji plugin
function classic_smilies_rm_tinymce_emoji( $plugins ) {
	return array_diff( $plugins, array( 'wpemoji' ) );
}

function classic_smilies_rm_additional_styles( $content ) {
	return str_replace( 'class="wp-smiley" style="height: 1em; max-height: 1em;"', 'class="wp-smiley"', $content );
}
//文章形式
add_theme_support( 'post-formats', array(
		'gallery'
	) );
	
function exclude_post_formats_from_homepage( $query ) {
	if( $query->is_main_query() && $query->is_home() ) { //判断首页主查询
		$tax_query = array( array( 
			'taxonomy' => 'post_format',
			'field' => 'slug',
			'terms' => array(
				//请根据需要保留要排除的文章形式
				'post-format-gallery'
				),
			'operator' => 'NOT IN',
			) );
		$query->set( 'tax_query', $tax_query );
	}
}
add_action( 'pre_get_posts', 'exclude_post_formats_from_homepage' );
function exclude_category_home( $query ) {  
    if ( $query->is_home ) {//是否首页  
        $query->set( 'cat', '-18' );  //排除的指定分类id  
    }  
    return $query;  
}  
   
add_filter( 'pre_get_posts', 'exclude_category_home' );  
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

//gravatar被墙恢复
function get_ssl_avatar($avatar) {
   $avatar = preg_replace('/.*\/avatar\/(.*)\?s=([\d]+)&.*/','<img src="https://secure.gravatar.com/avatar/$1?s=40&d=mm" class="avatar">',$avatar);
   return $avatar;
}
add_filter('get_avatar', 'get_ssl_avatar');


/***AJAX***/

//首页相册AJAX加载
add_action('wp_ajax_get_gallery', 'ajax_get_gallery');
add_action('wp_ajax_nopriv_get_gallery', 'ajax_get_gallery');
function ajax_get_gallery(){
	$photography = new WP_Query( 'cat=5&posts_per_page=7' );
	if ( $photography -> have_posts() ) {
		while ( $photography -> have_posts() ) {
			$photography -> the_post();
			$thumb = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'full');
			$width = ( $thumb[1] / $thumb[2] )*350;
			?>
			<a href="<?php the_permalink() ?>">
				<figure style="width:<?php echo $width;?>px;height:350px;">
					<?php the_post_thumbnail();?>
					<figcaption>
						<h2><?php the_title();?></h2>
					</figcaption>
				</figure>
			</a>
		<?php }
	}
	wp_reset_query();
	die();
}


//文章喜欢
add_action('wp_ajax_post_like', 'ajax_post_like');
add_action('wp_ajax_nopriv_post_like', 'ajax_post_like');
function ajax_post_like(){
	$id = $_POST['postid'];
	$name = "wp_erlimpostlike_".$id;
	$likes = get_post_meta( $id, "post_like",true);
	if( $_COOKIE[$name] == 1 ){
		$likes = intval($likes) - 1;
		update_post_meta($id,"post_like",$likes);
		setcookie($name,0,time()+3600*24*30);
		setcookie($name,0,time()+3600*24*30,"/");
	}else{
		$likes = intval($likes) + 1;
		update_post_meta($id,"post_like",$likes);
		setcookie($name,1,time()+3600*24*30);
		setcookie($name,1,time()+3600*24*30,"/");
	}
	echo $likes;
	die(); // this is required to return a proper result
}

//AJAX获取用户头像
add_action('wp_ajax_get_avatar', 'ajax_get_avatar');
add_action('wp_ajax_nopriv_get_avatar', 'ajax_get_avatar');
function ajax_get_avatar() {
	$avatar = get_avatar( $_POST['email'] );
	echo $avatar;
	die(); // this is required to return a proper result
}


//ajax提交评论
add_action('wp_ajax_submit_comment', 'theme_submit_comment');
add_action('wp_ajax_nopriv_submit_comment', 'theme_submit_comment');
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
				 <?php comment_date('Y年n月j日 H:i',$comment->comment_ID);?>  <?php comment_time('H:i',$comment->comment_ID);?></a>			
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
