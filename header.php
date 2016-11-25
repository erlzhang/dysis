﻿﻿<!DOCTYPE html>
<html>
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
						<img src="https://erl.im/wp-content/uploads/2016/10/myself.jpg" class="avatar" />
						<?php 
						$admin_email = get_bloginfo ('admin_email');
						$user=get_user_by( 'email', $admin_email );
						$userID=$user->ID;
						?>
						<h3><?php echo $user->display_name;?></h3>
						<p><?php echo get_the_author_meta( 'description', $userID );	?></p>
					</div>
				</div>
				<nav class="menu">
					<li><a href="<?php bloginfo('siteurl'); ?>"><i class="icon fa fa-home fa-fw"></i><span class="menu_title">Home</span></a></li>
					<li><a href="<?php bloginfo('siteurl'); ?>/blog/"><i class="icon fa fa-pencil fa-fw"></i><span class="menu_title">Blog</span></a></li>
					<li><a href="https://erl.im/gallery/"><i class="icon fa fa-camera fa-fw"></i><span class="menu_title">Photography</span></a></li>
					<!--<li><a href=""><i class="icon fa fa-book fa-fw"></i><span class="menu_title">Novel</span></a></li>-->
					<li><a href="<?php bloginfo('siteurl'); ?>/portfolio/"><i class="icon fa fa-code fa-fw"></i><span class="menu_title">Code</span></a></li>
					<li><a href="https://github.com/erlzhang" target="_blank"><i class="icon fa fa-github fa-fw"></i><span class="menu_title">Github</span></a></li>
				</nav>
				<!--<div class="search"><i class="icon fa fa-search fa-fw slide_search"></i>
					<form action="<?php //bloginfo('url'); ?>/">
						<input type="text" class="input-search" placeholder="Search...">
					</form>
				</div>-->
				
				<div class="siderhide">
					 <i class="fa fa-times"></i>
					 <span><i class="fa fa-caret-square-o-left"></i>&nbsp;&nbsp;收回</span>
				</div>
				<div class="sidershow">
					 <i class="fa fa-bars"></i>
					 <i class="fa fa-caret-square-o-right icon"></i>
				</div>
			</div>