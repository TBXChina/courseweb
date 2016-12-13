
$(function(){
  //Hello part
  var signOut = $(".recent").find("input").eq(0);
  var Change = $(".recent").find("input").eq(2);
  signOut.addClass("button blue small");
  Change.addClass("button red small");
  //h3 color and font-size
  $(".comment-border").find("h3").each(function(){
    $(this).css({"color":"#2AD2C9","font-size":"25pt"})
  });
  $(".comment-extra").find("h3").each(function(){
    $(this).css({"color":"#000","font-size":"20pt"})
  });
  $(".warning").each(function(){
    $(this).css({"color":"#F00","font-size":"15pt"})
  });
  $(".comment-list").find("h3").css("padding","20px");
  $(".comment-list").find("h3").eq(1).css("padding","30px");
  //Distribute New Assignment part
  var DistributeInput = $("#distribute").find("input");
  DistributeInput.eq(DistributeInput.length-1).addClass("button green");
  //Add News in Login Page part
  var ListInput = $("#list").find("input");
  ListInput.eq(ListInput.length-1).addClass("button green");
  //Export Submitted Homework part
  var ExportInput = $("#export").find("input");
  ExportInput.eq(ExportInput.length-1).addClass("button green");
  //Assignments part
  var AssignmentsInput = $("#assignments").find("input");
  AssignmentsInput.eq(AssignmentsInput.length-2).addClass("button green");
  AssignmentsInput.eq(AssignmentsInput.length-1).addClass("button red");
  //Query part
  var QueryInput = $("#query").find("input");
  QueryInput.eq(QueryInput.length-1).addClass("button green small");
  //Change Student Password part
  var ChanStuPassInput = $("#ChanStuPass").find("input");
  ChanStuPassInput.eq(ChanStuPassInput.length-1).addClass("button red small");
  //Insert New User part
  var InsertNewUserInput = $("#InsertNewUser").find("input");
  InsertNewUserInput.eq(InsertNewUserInput.length-1).addClass("button green small");
  //Delete Student User part
  var DelInput = $("#del").find("input");
  DelInput.eq(DelInput.length-1).addClass("button red small");
  //Reset All System part
  var ResetInput = $("#reset").find("input");
  ResetInput.eq(ResetInput.length-1).addClass("button red small");


})
