/*文本目录*/
function showContentCatalog(){
	
	//获取全部h2、h3标题
	var heads=$('.content').find('h2,h3');
	if(heads.length > 0){
		var heights = [];
		var current,currentParent = -1;
		
		//设置目录框架和头部
		var container=document.createElement('div')
		container.className="content-catalog"
		var content="<strong>目录</strong><ul>"
		
		var n=0,c=' class="sub"',s=0
		for(var i=0; i<heads.length;i++){
			heights[i] = heads[i].offsetTop;
			if(heads[i].tagName == "H2"){
				n += 1
				content += '<li data-menu-id="'+n+'"'; 
				next = i+1
				if((next != heads.length) && heads[next].tagName == "H3"){
					content += ' data-has-sub="1"';
					s = 0
				}
				content += '> '+n+'. '+heads[i].innerText;
				content += '</li>';
			}else{
				s += 1
				content += '<li'+c+' data-parent-menu="'+n+'"> '+n+'.'+s+'. '+heads[i].innerText+'</li>';
			}	
		}
		var buttom = $(".content-footer").offset().top;
		heights.push(buttom)
		content += "</ul>";
		container.innerHTML=content;
		$(container).insertAfter(".content");
		
		$(".content-catalog strong").on("click",function(){
			$(container).toggleClass("open");
		})
		
		//注册点击滑动
		$('.content-catalog li').each(function(o){
			$(this).click(function(){
				$('html,body').animate({
					scrollTop : heights[o]
				})
			})
		});

		//滚动监听
		$(window).scroll(function(){
			var thetop = $(window).scrollTop();
			var currentMenu;
			for(var i = 0,len=heights.length; i < len ; i++){
				if( (thetop >= heights[i]) && (thetop <= heights[i+1]) && (current != i)){
					
					current = i;
					//console.log(current)
					
					currentMenu = $('.content-catalog li').eq(current);
					
					$('.content-catalog li').removeClass("current");
					
					currentMenu.addClass("current");
					
					var the_parent = currentMenu.data("parent-menu");
					
					if(!the_parent){
						if(currentMenu.data("has-sub")){
							the_parent = currentMenu.data("menu-id");
						}
					}

					if(the_parent){
						if(the_parent != currentParent){
							if(currentParent > 0){
								$("[data-parent-menu=\""+currentParent+"\"]").slideUp();
							}
							currentParent = the_parent;
							$("[data-parent-menu=\""+currentParent+"\"]").slideDown();
						}	
					}else{
						if(currentParent > 0){	
							$("[data-parent-menu=\""+currentParent+"\"]").slideUp();
							currentParent = -1;
						}
					}

					return; 
				}
			}
		})		
	}
}

/*文章点赞功能*/
function addLike(id){
	var data = {
		action: 'post_like',
		postid: id
	};

	$.post(Myajax.ajaxurl, data, function(response) {
		var likes =  parseInt(response);
		var like_number = document.getElementById("icon-heart-number");
		if( like_number.style.opacity == 0 ){
			like_number.style.opacity = 1;
		}
		like_number.innerHTML = likes;
		console.log(response);
	});
	$(event.target).toggleClass("post-like-on");
}

