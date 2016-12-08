$(function(){
  //UpLoad
  var upLoadInput = $(".desc form").find("input").eq(4);
  upLoadInput.addClass("button").addClass("green");
  //homework lists :Download and Delete
  var downloadInput = $("#list").find("input").eq(1);
  var DeleteInput = $("#list").find("input").eq(2);
  downloadInput.addClass("button").addClass("green");
  DeleteInput.addClass("button").addClass("red");
  //Assignments :Download
  var AssignmentsdownloadInput = $("#assignments").find("input").eq(3);
  AssignmentsdownloadInput.addClass("button").addClass("green");
  //Hello part
  var signOut = $(".recent").find("input").eq(0);
  var Change = $(".recent").find("input").eq(2);
  signOut.addClass("button").addClass("blue").addClass("small");
  Change.addClass("button").addClass("red").addClass("small");
  //h3 color and font-size
  $(".comment-list").find("h3").each(function(){
    $(this).css("color","#2AD2C9").css("font-size","25pt");
  });
  $(".comment-list").find("h3").eq(1).css("padding","28px");
})
