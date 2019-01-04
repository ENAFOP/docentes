$(document).ready(function(){
  // $("#btn-next-1").on("click", function(){
  	// $("#nav-tab-1").removeClass("active");
  	// $("#nav-tab-2").addClass("active");
  	// $('html, body').animate({scrollTop: 0}, 800);
  // });

  // $("#btn-next-2").on("click", function(){
  	// $("#nav-tab-2").removeClass("active");
  	// $("#nav-tab-3").addClass("active");
  	// $('html, body').animate({scrollTop: 0}, 800);
  // });
  
  $("#btn-prev-2").on("click", function()
  {
	  //alert("click en prev2");
  	$("#nav-tab-2").removeClass("active");
  	$("#nav-tab-1").addClass("active");
  	$('html, body').animate({scrollTop: 0}, 800);
  }); 
});
 $("#btn-prev-5").on("click", function()
  {

  	$("#nav-tab-5").removeClass("active");
  	$("#nav-tab-4").addClass("active");
  	$('html, body').animate({scrollTop: 0}, 800);
  }); 
});

function holi1()
{
	alert("holi");
}