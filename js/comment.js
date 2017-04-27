﻿/*
AJAX COMMENTS
Theme: Dysis
Author: Erl
Author URI: https://erl.im/
*/
//插件：输入框随宽度自动伸缩
(function (root, factory) {
	'use strict';

	if (typeof define === 'function' && define.amd) {
		// AMD. Register as an anonymous module.
		define([], factory);
	} else if (typeof exports === 'object') {
		// Node. Does not work with strict CommonJS, but
		// only CommonJS-like environments that support module.exports,
		// like Node.
		module.exports = factory();
	} else {
		// Browser globals (root is window)
		root.autosize = factory();
  }
}(this, function () {
	function main(ta) {
		if (!ta || !ta.nodeName || ta.nodeName !== 'TEXTAREA' || ta.hasAttribute('data-autosize-on')) { return; }

		var maxHeight;
		var heightOffset;

		function init() {
			var style = window.getComputedStyle(ta, null);

			if (style.resize === 'vertical') {
				ta.style.resize = 'none';
			} else if (style.resize === 'both') {
				ta.style.resize = 'horizontal';
			}

			// horizontal overflow is hidden, so break-word is necessary for handling words longer than the textarea width
			ta.style.wordWrap = 'break-word';

			// Chrome/Safari-specific fix:
			// When the textarea y-overflow is hidden, Chrome/Safari doesn't reflow the text to account for the space
			// made available by removing the scrollbar. This workaround will cause the text to reflow.
			var width = ta.style.width;
			ta.style.width = '0px';
			// Force reflow:
			/* jshint ignore:start */
			ta.offsetWidth;
			/* jshint ignore:end */
			ta.style.width = width;

			maxHeight = style.maxHeight !== 'none' ? parseFloat(style.maxHeight) : false;
			
			if (style.boxSizing === 'content-box') {
				heightOffset = -(parseFloat(style.paddingTop)+parseFloat(style.paddingBottom));
			} else {
				heightOffset = parseFloat(style.borderTopWidth)+parseFloat(style.borderBottomWidth);
			}

			adjust();
		}

		function adjust() {
			var startHeight = ta.style.height;
			var htmlTop = document.documentElement.scrollTop;
			var bodyTop = document.body.scrollTop;
			
			ta.style.height = 'auto';

			var endHeight = ta.scrollHeight+heightOffset;
			
			if (maxHeight !== false && maxHeight < endHeight) {
				endHeight = maxHeight;
				if (ta.style.overflowY !== 'scroll') {
					ta.style.overflowY = 'scroll';
				}
			} else if (ta.style.overflowY !== 'hidden') {
				ta.style.overflowY = 'hidden';
			}

			ta.style.height = endHeight+'px';

			// prevents scroll-position jumping
			document.documentElement.scrollTop = htmlTop;
			document.body.scrollTop = bodyTop;

			if (startHeight !== ta.style.height) {
				var evt = document.createEvent('Event');
				evt.initEvent('autosize.resized', true, false);
				ta.dispatchEvent(evt);
			}
		}

		// IE9 does not fire onpropertychange or oninput for deletions,
		// so binding to onkeyup to catch most of those events.
		// There is no way that I know of to detect something like 'cut' in IE9.
		if ('onpropertychange' in ta && 'oninput' in ta) {
			ta.addEventListener('keyup', adjust);
		}

		window.addEventListener('resize', adjust);
		ta.addEventListener('input', adjust);

		ta.addEventListener('autosize.update', adjust);

		ta.addEventListener('autosize.destroy', function(style){
			window.removeEventListener('resize', adjust);
			ta.removeEventListener('input', adjust);
			ta.removeEventListener('keyup', adjust);
			ta.removeEventListener('autosize.destroy');

			Object.keys(style).forEach(function(key){
				ta.style[key] = style[key];
			});

			ta.removeAttribute('data-autosize-on');
		}.bind(ta, {
			height: ta.style.height,
			overflow: ta.style.overflow,
			overflowY: ta.style.overflowY,
			wordWrap: ta.style.wordWrap,
			resize: ta.style.resize
		}));

		ta.setAttribute('data-autosize-on', true);
		ta.style.overflow = 'hidden';
		ta.style.overflowY = 'hidden';

		init();		
	}

	// Do nothing in IE8 or lower
	if (typeof window.getComputedStyle !== 'function') {
		return function(elements) {
			return elements;
		};
	} else {
		return function(elements) {
			if (elements && elements.length) {
				Array.prototype.forEach.call(elements, main);
			} else if (elements && elements.nodeName) {
				main(elements);
			}
			return elements;
		};
	}
}));



var comment_content = document.getElementById("comment"),
	author = document.getElementById("author"),
	email = document.getElementById("email"),
	info_mask = $(".comment-author-input-mask"),
	info_input = $(".comment-author-input"),
	avatar = $(".comment-author-avatar"),
	comment_mask = document.getElementById("bottom-comment-mask"),
	submit = document.getElementById("submit"),
	comment_smiley = document.getElementById("comment-smiley");
	
autosize(comment_content);	

function respondOn(){
	comment_content.setAttribute("rows",3);
	comment_content.style.height = "95px";
	$(".bottom-comment-bar").addClass("on");
	comment_smiley.style.height = "auto";
	comment_smiley.style.opacity = 1;
	comment_mask.style.display = "block";
}

function respondOff(){
	comment_smiley.style.opacity = 0;
	comment_smiley.style.height = "0px";
	comment_content.setAttribute("rows",1);
	comment_content.style.height = "45px"
	$(".bottom-comment-bar").removeClass("on");
	comment_mask.style.display = "none";
}

comment_mask.onclick = respondOff;

comment_content.oninput = function(){
	if(this.value != ''){
		submit.disabled = false;
	}else{
		submit.disabled = true;
	}
}


comment_content.onfocus = respondOn;


if(author){
	comment_content.onfocus = function(){
		if(author.value == '' || email.value == ''){
			info_mask.show();
			info_input.addClass("show");
			if(author.value == ''){
				author.focus();
			}else{
				email.focus();
			}
		}else{
			respondOn();
		}
	}
	author.onchange = function(){
		document.getElementById("current-comment-author").innerHTML = author.value;
	}
	email.onchange = function(){
		var data = {
			action: 'get_avatar',
			email: this.value
		};

		$.post(Myajax.ajaxurl, data, function(response) {
			console.log(response);
			avatar.html(response);
			$(".comment-author-input-avatar").html(response);
		});
	}
	avatar.on("click",function(){
		info_mask.show();
		info_input.addClass("show");
	})

	info_mask.click(function(){
		$(this).hide();
		info_input.removeClass("show");
	});
}



addComment = {
	moveForm: function(commId, parentId, respondId, postId, num){
		var reply = document.getElementById("replying"),
			parent = document.getElementById("comment_parent");
		comment_content.focus();
		event.preventDefault();
		$(reply).show()
		$("#replying-parent").html($("#"+commId).find(".fn").html())
		parent.value = parentId;
		reply.onclick = function() {
			parent.value = "0";
			this.style.display = "none";
			this.onclick = null;
			respondOff();
			return false
		};
	}
}
$("#commentform").submit(function(){
	event.preventDefault();
	$("#replying").hide();
	$("#loading").show();
	submit.disabled = true;
	$.ajax({
		url : Myajax.ajaxurl,
		data : $(this).serialize() + '&action=submit_comment',
		type: $(this).attr("method"),
		error:function(request){
			$("#error").html("<p><strong>错误：</strong>服务器通讯失败，请稍后重试。</p>").show();
		},
		success:function(data){
			$("#loading").hide();
			var div = document.createElement("div");
			div.innerHTML = data;
			console.log(data)
			if( $(div).find("#comment-error").length > 0){
				//评论提交失败
				$("#error").html(data).show();
			}else{
				//评论提交成功
				$("#success").show();
				var p = $(data).data("parent");
				var container;
				if(p == 0){
					container = $(".comment-list")
				}else{
					
					if($("#comment-" + p).find("ul.children").length > 0){
						container = $("#comment-" + p).find("ul.children")
					}else{
						container = document.createElement("ul");
						container = $(container);
						container.addClass("children").hide();
						$("#comment-" + p).append(container);
						container.fadeIn();
					}
				}
				container.prepend(data);
				comment_content.value = '';
				respondOff();
				$('html,body').animate({
					scrollTop :$(container).offset().top - 100
				})
			}
			setTimeout(function(){
				$("#success,#error").fadeOut(1000);
			},1500);
		}
	});
});

/*
$(".response-show-btn").click(function(){
	$(".bottom-comment-bar").show();
	if(author.value == '' || email.value == ''){
			info_mask.show();
			info_input.addClass("show");
			if(author.value == ''){
				author.focus();
			}else{
				email.focus();
			}
		}else{
			respondOn();
		}
});
*/





