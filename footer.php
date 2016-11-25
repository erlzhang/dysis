				<div class="footer">
					@ 2016 Erl All rights reserved.
				</div>
			</div>
		</div>
		<?php wp_footer();?>
		<?php if(is_home()) :?>
		<script>
			$(window).load(function(){
				$(".photography").slide({
					item : "figure",
					list : ".pic_list",
					leftbutton : "#prev",
					rightbutton : "#next"
				});
			});
		</script>
		<?php endif;?>
		<?php if( is_single() && !has_post_format('gallery') ) :?>
		<script>
			showContentCatalog();
		</script>
		<?php endif;?>
	</body>
</html>