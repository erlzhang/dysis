
$(".sidershow").on("click",function(){
	$(".sidebar").addClass("open");
	$(".main").addClass("side");
});
$(".siderhide").on("click",function(){
	$(".sidebar").removeClass("open");
	$(".main").removeClass("side");
});
$(".search .slide_search").on("click",function(){
	$(".search").toggleClass("active");
});