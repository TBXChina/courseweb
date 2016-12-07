

$(function(){
	var curIndex=0;
	var maxPage = 4;
	var timeInterval=8000; 
	var arr=new Array();
	arr[0]="1.jpg";
	arr[1]="2.jpg";
	arr[2]="3.jpg";
	arr[3]="4.jpg";
	arr[4]="5.jpg";
	var obj=$("#cover_obj");
	setInterval(changeImg,timeInterval);
	function changeImg() {
	var obj=$("#cover_obj");
	obj.css("background-image","url(images/"+arr[curIndex]+")").fadeOut(0);
	if (curIndex==maxPage) {
	curIndex=0;
		}
	else {
	curIndex+=1;
		}
	obj.css("background-image","url(images/"+arr[curIndex]+")").fadeIn(2000);
	$("div.highlight_tip").children()
						 .eq(curIndex).addClass("current")
					     .siblings().removeClass("current");

	}



	//蓝色点
	var $choose_point = $(".highlight_tip").find("span");

		$choose_point.eq(0).click(function(){
			curIndex=0;
			//var obj=$("#cover_obj");
			obj.css("background-image","url(images/"+arr[curIndex]+")");
			$("div.highlight_tip").children()
							  .eq(0).addClass("current")
							  .siblings().removeClass("current");

		})

		$choose_point.eq(1).click(function(){
			curIndex=1;
			//var obj=$("#cover_obj");
			obj.css("background-image","url(images/"+arr[curIndex]+")");
			$("div.highlight_tip").children()
							  .eq(1).addClass("current")
							  .siblings().removeClass("current");

		})

		$choose_point.eq(2).click(function(){
			curIndex=2;
			//var obj=$("#cover_obj");
			obj.css("background-image","url(images/"+arr[curIndex]+")");
			$("div.highlight_tip").children()
							  .eq(2).addClass("current")
							  .siblings().removeClass("current");

		})

		$choose_point.eq(3).click(function(){
			curIndex=3;
			//var obj=$("#cover_obj");
			obj.css("background-image","url(images/"+arr[curIndex]+")");
			$("div.highlight_tip").children()
							  .eq(3).addClass("current")
							  .siblings().removeClass("current");

		})

		$choose_point.eq(4).click(function(){
			curIndex=4;
			//var obj=$("#cover_obj");
			obj.css("background-image","url(images/"+arr[curIndex]+")");
			$("div.highlight_tip").children()
							  .eq(4).addClass("current")
							  .siblings().removeClass("current");

		})

})
