$(function(){
  //top nav slow move
  $(".top-nav ul.nav1 li a").click(function(e){
    e.preventDefault();
    var href = $(this).attr("href");
    var offsetH = $(href).offset().top;
    $("body").animate({"scrollTop":offsetH},1600);
  });
  //cover image
  $(".askLogIn").on("click",function(e){
    e.preventDefault();
    var offsetH = $("#log_in").offset().top;
    $("body").animate({"scrollTop":offsetH},1000);
  });
  $(".askContact").on("click",function(e){
    e.preventDefault();
    var offsetH = $("#contact").offset().top;
    $("body").animate({"scrollTop":offsetH},1600);
  });
})
