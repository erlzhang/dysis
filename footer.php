				<div class="footer">
					© 2017 Erl
				</div>
			</div>
		</div>
		<?php wp_footer();?>
		<?php if(is_home()) :?>
		<script>
			$.ajax({
				url : Myajax.ajaxurl,
				data : 'action=get_gallery',
				type: 'get',
				success:function(data){
					$(".pic_list").html(data);
					$(".photography").slide({
						item : "figure",
						list : ".pic_list",
						margin : 0.17
					});
				}
			});
			$(function() {
				$("img.post_thumbmail").lazyload({
					effect : "fadeIn"
				});
			});
		</script>
		<?php endif;?>
		<?php if( is_single() && !has_post_format('gallery') ) :?>
		<script>
			showContentCatalog();hljs.initHighlightingOnLoad();
		</script>
		<?php endif;?>
	</body>
</html>