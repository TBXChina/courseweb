$(function(){
  //UpLoad
  var upLoadInput = $(".desc form").find("input").eq(4);
  upLoadInput.addClass("button green");
  //homework lists :Download and Delete
  var downloadInput = $("#list").find("input").eq(1);
  var DeleteInput = $("#list").find("input").eq(2);
  downloadInput.addClass("button green");
  DeleteInput.addClass("button red");
  //Assignments :Download
  var AssignmentsdownloadInput = $("#assignments").find("input").eq(3);
  AssignmentsdownloadInput.addClass("button green");
  //Hello part
  var signOut = $(".recent").find("input").eq(0);
  var Change = $(".recent").find("input").eq(2);
  signOut.addClass("button blue small");
  Change.addClass("button red small");
  //h3 color and font-size
  $(".comment-list").find("h3").each(function(){
    $(this).css({"color":"#2AD2C9","font-size":"25pt"})
  });
  $(".comment-list").find("h3").eq(1).css("padding","28px");
})
