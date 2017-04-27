/*
GALLERY
Theme: Dysis
Author: Erl
Author URI: http://erl.im/
*/


var list = $(".photolist li"),
	gallery = [],
	index = 0;

//创建缩略图按钮
list.each(function(o){
	gallery[o] = {
		src : $(this).data('img'),
		title : $(this).find("p").text(),
		width : $(this).data('width'),
		height : $(this).data('height')
	}
	$(this).click(function(){
		index = o;
		showpic(index);
	})
});

//创建相册
function showpic(index){
	var img = document.createElement("img");
	img.src = gallery[index].src
	img.style.opacity = 0;
	
	//计算图片长宽
	var ow = gallery[index].width,
		oh = gallery[index].height,
		pct = ow / oh,
		width,
		height,
		cw = $(".gallery").width(),
		ch = $(".gallery").height();
	if ( ow > cw ){
		width = cw;
		height = width / pct;
		if ( height > ch ){
			height = ch;
			width = height * pct;
		}
	}else{
		if(oh > ch){
			height = ch;
			width = height * pct;
			if ( width > cw ){
				width = cw;
				height = width / pct;
				
			}
		}else{
			width = ow;
			height = oh;
		}
	}
	
	//图片占位
	var fa = document.createElement('i');
	fa.className = 'fa fa-spinner fa-pulse fa-3x fa-fw loading';
	$(".photo").css({
		"width" : width,
		"height" : height,
		"margin-top" : (ch - height)/2
	}).html(fa).append(img);
	fa.style.opacity = 1;
	
	img.onload = function(){
		fa.style.display = "none";
		img.style.opacity = 1;
	}
	
	if( gallery[index].title){
		var title = "<figcaption>" + gallery[index].title + "</figcaption>";
		$(".photo").append(title);
	}

	list.css("opacity",".5").eq(index).css("opacity",1);
}

showpic(index);

$(".right").click(function(){
	if(index == (list.length-1)){
		index = 0;
	}else{
		index++;
	}
	showpic(index);
})

$(".left").click(function(){
	if(index == 0){
		index = list.length-1;
	}else{
		index--;
	}
	showpic(index);
})

//增加键盘事件 11.10
document.onkeydown = function(event){
	if(event && event.keyCode == 39){
		if(index == (list.length-1)){
			index = 0;
		}else{
			index++;
		}
		showpic(index);
	}
	if(event && event.keyCode == 37){
		if(index == 0){
			index = list.length-1;
		}else{
			index--;
		}
		showpic(index);
	}
}
$(window).load(function(){
	$(".photolist").slide({
		item : "li",
		list : "ul",
		leftbutton : ".slide_left",
		rightbutton : ".slide_right",
		margin :  3
	});
});

//窗口大小改变时重新载入当前图片 11.10
$(window).resize(function(){
	showpic(index);
})


