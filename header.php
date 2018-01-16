<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta charset="UTF-8">
		<?php wp_head();?>
		<?php include("seo.php");?>
		<meta name="viewport" content="width=device-width, initial-scale=1">
	</head>
	<body>
		<div class="container">
			<div class="sidebar">
				<div class="author">
					<div class="author_cover">
					</div>
					<div class="author_info">
						<img src="https://erl.im/wp-content/uploads/2017/06/198243_14552_344175_MHz6-1.jpg" class="avatar" />
						<?php 
						$admin_email = get_bloginfo ('admin_email');
						$user=get_user_by( 'email', $admin_email );
						$userID=$user->ID;
						?>
						<h3><?php echo $user->display_name;?></h3>
						<p><?php echo get_the_author_meta( 'description', $userID );	?></p>
						<div class="author_icon">
							<a href="https://github.com/erlzhang" target="_blank"><span class="icon icon-github"></span></a>
							<a href="http://codepen.io/erlzhang/" target="_blank"><span class="icon icon-codepen"></span></a>
							<a href="https://plus.google.com/u/0/112931302489591170966" target="_blank"><span class="icon icon-google-plus"></span></a>
							<a href="mailto:zhangshiyu1992@hotmail.com" target="_blank"><span class="icon icon-envelope"></span></a>
						</div>
					</div>
					
				</div>
				<nav class="menu">					<li><a href="<?php bloginfo('url'); ?>"><span class="icon icon-home3"></span><span class="menu_title">Home</span></a></li>					<li><a href="<?php bloginfo('url'); ?>/blog/"><span class="icon icon-pencil"></span><span class="menu_title">Blog</span></a></li>					<li><a href="<?php bloginfo('url'); ?>/gallery/"><span class="icon icon-camera"></span><span class="menu_title">Photography</span></a></li>					<li><a href="<?php bloginfo('url'); ?>/code/"><span class="icon icon-keyboard"></span><span class="menu_title">Code</span></a></li>
<li><a href="https://erl.design/" target="_blank"><span class="icon icon-window"></span><span class="menu_title">Portfolio</span></a></li>
					<li><a href="<?php bloginfo('url'); ?>/book/"><span class="icon icon-book"></span><span class="menu_title">Novel</span></a></li>
				</nav>
				<!--<div class="search"><i class="icon fa fa-search fa-fw slide_search"></i>
					<form action="<?php //bloginfo('url'); ?>/">
						<input type="text" class="input-search" placeholder="Search...">
					</form>
				</div>-->
				
				<div class="siderhide">					<span class="icon icon-close"></span>					<span class="icon icon-chevron-thin-left"></span>
				</div>
				<div class="sidershow">					 <span class="icon icon-grid"></span>					 <span class="icon icon-chevron-thin-right"></span>
				</div>
			</div>
			<div class="mobile-top">
				<div class="mobile-top-left">
					
				</div>
				<div class="mobile-top-right">
					<h1><?php echo get_bloginfo('name');?><small><?php echo get_bloginfo('description');?></small></h1>
				</div>
			</div>