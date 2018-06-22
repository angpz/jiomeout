$('.card-create').mouseover(function () {
 	  
 	 $(".card-create").css("display","none");
   $(".card-hide").css("display","block");
}); 

$(".card-hide").mouseleave(function(){
    $(".card-create").css("display","block");
    $(".card-hide").css("display","none");
 });
//phone view create card click 
$('.card-create').on("touchstart", function (e) {
'use strict'; //satisfy code inspectors
var link = $(this); //preselect the link
if (link.hasClass('hover')) {
    return true;
 } 
else {
   link.addClass('hover');
   $('ul > li').not(this).removeClass('hover');
   e.preventDefault();
   $(".card-create").css("display","none");
   $(".card-hide").css("display","block");
   return true; //extra, and to make sure the function has consistent return points
  }
});