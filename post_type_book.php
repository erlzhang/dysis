<?php   
add_action('init', 'book_custom_init');   
function book_custom_init()    
{   
  $labels = array(   
    'name' => '小说',
    'singular_name' => '小说',
    'add_new' => '添加新小说',
    'add_new_item' => '添加新小说',
    'edit_item' => '编辑小说',
    'new_item' => '新小说',
    'view_item' => '查看小说',
    'search_items' => '搜索小说',
    'not_found' =>  'Not Found',
    'not_found_in_trash' => 'not_found_in_trash',
    'parent_item_colon' => '',
    'menu_name' => '小说'
  );   
  $args = array(   
    'labels' => $labels,
    'publicly_queryable' => true,
    'show_ui' => true,
    'show_in_menu' => true,
	'menu_icon'=>'dashicons-format-gallery',
    'query_var' => true,
    'rewrite' => true,
    'has_archive' => true,
    'supports' => array('title','editor','author','excerpt','thumbnail')
  );    
  register_post_type('book',$args);
}
?>
