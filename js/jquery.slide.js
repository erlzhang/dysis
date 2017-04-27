/*jQuery.slide.js
Author: Erl
Author URI: http://erl.im/
*/
(function($){
	$.fn.extend({
		"slide" : function(options){
			options.margin = options.margin || 0;
			$.fn.slide = {
				"item" : this.find(options.item) || "img",
				"list" : this.find(options.list),
				"width" : 0,
				"index" : 0,
				"left" : 0,
				"onoff" : 0
			}
			
			for (var i=0,len=$.fn.slide.item.length;i<len;i++){
				$.fn.slide.width += $.fn.slide.item.eq(i).width() + options.margin*2;
			}
			
			this.find(options.list).width($.fn.slide.width);

			function slideLeft(){
				$("#slide-next").show();
				if($.fn.slide.left == 0){
					return;
				}
				$.fn.slide.index--;
				var current_width = $.fn.slide.item.eq($.fn.slide.index).width();
				$.fn.slide.left = $.fn.slide.left + current_width + options.margin*2;
				if($.fn.slide.left > 0){
					$.fn.slide.left = 0;
					$("#slide-prev").hide();
				}
				$.fn.slide.list.animate({
					"margin-left" : $.fn.slide.left
				});
			}
			
			function slideRight(){
				$("#slide-prev").show();
				if($.fn.slide.left == $.fn.slide.container.width() - $.fn.slide.width){
					return;
				}
				var current_width = $.fn.slide.item.eq($.fn.slide.index).width();
				$.fn.slide.left = $.fn.slide.left - current_width - options.margin*2;
				if( $.fn.slide.left + $.fn.slide.width < $.fn.slide.container.width()){
					$.fn.slide.left = $.fn.slide.container.width() - $.fn.slide.width;
					$("#slide-next").hide();
				}
				$.fn.slide.index++;
				$.fn.slide.list.animate({
					"margin-left" : $.fn.slide.left
				});
			}
			
			function mouseSlide(event){
				event = event || window.event;
				event.preventDefault();
				//var direction = event.wheelDelta && (event.wheelDelta > 0 ? "mouseup" : "mousedown");
				if(event.wheelDelta && event.wheelDelta>0){
					slideLeft();
				}else{
					slideRight();
				}
			}
			this.append("<span id=\"slide-prev\" style=\"display:none\"><i class=\"fa fa-chevron-left\"></i></span><span id=\"slide-next\" style=\"display:none\"><i class=\"fa fa-chevron-right\"></i></span>");
			
			$("#slide-prev").on("click",slideLeft);
			$("#slide-next").on("click",slideRight);
			if($.fn.slide.width > this.width() && window.innerWidth > 800 ){
				$("#slide-next").show();
				//this[0].addEventListener("mousewheel",mouseSlide);
				$.fn.slide.onoff = 1;
			}
			
			$.fn.slide.container = $(this)
			
			$(window).resize(function(){
				console.log(window.innerWidth);
				if($.fn.slide.width > $.fn.slide.container.width() ){
					if ($.fn.slide.onoff == 0 && window.innerWidth > 800){
						$("#slide-prev").show();
						$("#slide-next").show();
						$.fn.slide.onoff = 1;
					}
				}else{
					if ($.fn.slide.onoff == 1 && window.innerWidth < 800){
						$("#slide-prev").hide();
						$("#slide-next").hide();
						$.fn.slide.onoff = 0;
					}
				}
			});
			
			//手势
			var touchtimes = 0,touchx = [];
			this[0].addEventListener('touchstart',function(event){
				touchtimes ++ ;
				touchx[touchtimes] = event.changedTouches[0].clientX;		
			});  
			this[0].addEventListener('touchend',function(event){
				touchtimes ++ ;
				touchx[touchtimes] = event.changedTouches[0].clientX;
				if( touchx[touchtimes] > touchx[touchtimes-1] ){
					slideLeft();
				}
				if( touchx[touchtimes] < touchx[touchtimes-1] ){
					slideRight();
				}
				
			});  
		}
	});
	
})(jQuery);
