$(function(){
  //username
  var username = $(".contact-right").find("input").eq(0);
  username.addClass("name");
  //UpLoad
  var upLoadInput = $(".desc form").find("input").eq(4);
  upLoadInput.addClass("button green");
  //homework lists :Download and Delete
  var list = $("#list").find("input");
  var downloadInput = list.eq(list.length - 2);
  var DeleteInput = list.eq(list.length - 1);
  downloadInput.addClass("button green");
  DeleteInput.addClass("button red");
  //Assignments :Download
  var AssignmentdownloadInput = $("#Assignment_download");
  var AssignmentDeleteInput   = $("#Assignment_delete");
  AssignmentdownloadInput.addClass("button green");
  AssignmentDeleteInput.addClass("button red");
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
