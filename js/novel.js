/*获取小说章节内容*/
var chapter_content = document.getElementById("chapter-content"),
	chapter_title_id = document.getElementById("chapter-title-id"),
	chapter_nav_links = document.getElementById("chapter-nav-links"),
	chapter_id = 1;

//如果有指定章节数
var hash = document.location.hash.slice(1);
hash = parseInt(hash);
if( (hash != chapter_id) && (hash > 0) && (hash <= count) ){
	chapter_id = hash;
}

//初始化首章
showChapter(chapter_id);

function showChapter(n){
	if(event){
		event.preventDefault();
	}
	document.body.scrollTop = 0;
	chapter_content.style.opacity = 0;
	chapter_content.style.marginTop = "50px";
	chapter_title_id.innerHTML = n;
	document.location.hash = n;
	var url = chapterURL + n + ".txt";
	$.get(url,function(response) {
		var content = "<p>";
		content += response.replace(/\n/g,"</p><p>");
		content += "</p>"
		setTimeout(function(){
			chapter_content.innerHTML = content;
			chapter_content.style.opacity = 1;
			chapter_content.style.marginTop = "0px";
			getNavLink(n)
		},500)
	});
	if( $(".novel-catalog").hasClass("on") ){
		$(".novel-catalog").removeClass("on");
	}
}

//相连章节链接
function getNavLink(n){
	var content = '';
	if(n > 1){
		var prev = n-1;
		content += '<a href="#'+prev+'" onclick="showChapter('+prev+')" class="prev"><i class="fa fa-angle-left"></i>&nbsp;&nbsp;上一章</a>';
	}
	
	if( n < count){
		var next = n+1;
		content += '<a href="#'+next+'" onclick="showChapter('+next+')" class="next">下一章&nbsp;&nbsp;<i class="fa fa-angle-right"></i></a>';
	}
	chapter_nav_links.innerHTML = content;
}

$(".toggle-novel-catalog").click(function(){
	console.log("111");
	$(".novel-catalog").addClass("on");
});

document.getElementById("novel-catalog-off").onclick = function(){
	$(".novel-catalog").removeClass("on");
}