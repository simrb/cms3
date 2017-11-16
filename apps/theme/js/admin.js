
$(document).ready( function() {

	// admin menu
	$("#header").click(function() {
		$(".show-menu").toggle(
			function(){
				$(this).css("position","absolute");},
			function(){
				$(this).css("position","absolute");}
		);
	});

	// $("#header").mouseover(function() {
	// 	$(".show-menu").show();
	// });
	
	// $(".show-menu").mouseleave(function() {
	// 	$(".show-menu").hide();
	// });

	// show or hide content pad
	$(".showorhide").next().hide();
	$(".showorhide").click(function(){
  		$(this).next().toggle();
  	});

 

});

