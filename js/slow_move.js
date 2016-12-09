$(function(){
  $("#askSubmit").on("click",function(e){
    e.preventDefault();
    var offsetH = $("#submit").offset().top;
    $("body").animate({"scrollTop":offsetH},1000);
  });
  $("#askList").on("click",function(e){
    e.preventDefault();
    var offsetH = $("#list").offset().top;
    $("body").animate({"scrollTop":offsetH},1600);
  });
  $("#askAssignments").on("click",function(e){
    e.preventDefault();
    var offsetH = $("#assignments").offset().top;
    $("body").animate({"scrollTop":offsetH},1600);
  });

  $(".askLogIn").on("click",function(e){
    e.preventDefault();
    var offsetH = $("#log_in").offset().top;
    $("body").animate({"scrollTop":offsetH},1000);
  });
  $(".askRecentNews").on("click",function(e){
    e.preventDefault();
    var offsetH = $("#recent_news").offset().top;
    $("body").animate({"scrollTop":offsetH},1200);
  });
  $(".askContact").on("click",function(e){
    e.preventDefault();
    var offsetH = $("#contact").offset().top;
    $("body").animate({"scrollTop":offsetH},1600);
  });

})
