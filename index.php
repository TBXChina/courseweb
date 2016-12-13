<?php
    include_once "include/configure.php";
    include_once "include/common/log.php";
    include_once "include/common/web.php";
?>
<!DOCTYPE html>
<html>
<head>
<title>Home</title>
<meta name="viewport" content="width=device-width, initial-scale=1"/>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

 <!-- stylesheets -->
<link rel='stylesheet' href="css/bootstrap.css" type='text/css' />
<link rel='stylesheet' href="css/style.css" type='text/css' />
<link rel="stylesheet" href="css/TW.css" type='text/css'/>
<link rel='stylesheet' href="css/OS.css" type='text/css'/>
<link rel="stylesheet" href="css/font_icon/css/pe-icon-7-stroke.css" type='text/css'/>
<link rel="stylesheet" href="css/font_icon/css/helper.css" type='text/css'/>
<link rel='stylesheet' href="css/style_animate_part.css" type='text/css' />
<link rel="stylesheet" href="font_icon/css/pe-icon-7-stroke.css" type='text/css'/>
<link rel="stylesheet" href="font_icon/css/helper.css" type='text/css'/>
<link rel="stylesheet" href="css/owl.carousel.css" type='text/css'/>
<link rel="stylesheet" href="css/owl.theme.css" type='text/css'/>
<link rel="stylesheet" href="css/animate.css" type='text/css'/>
<link rel="stylesheet" href="css/style_contact.css" type='text/css'/>
<link rel='stylesheet' href='css/googleFont.css' type='text/css'/>

<!-- scripts-->
<script src="js/jquery-2.1.3.min.js" type="text/javascript"></script>
<script src="js/modernizr.js" type="text/javascript"></script>
<script src="js/bootstrap.min.js" type="text/javascript"></script>
<script src="js/googleAPI.js" type="text/javascript"></script>
<script src="js/move-top.js" type="text/javascript"></script>
<script src="js/easing.js" type="text/javascript"></script>
<script src="js/interactive.js" type="text/javascript"></script>
<script src="js/responsiveslides.min.js" type="text/javascript"></script>
<script src="js/jquery.actual.min.js" type="text/javascript"></script>
<script src="js/smooth-scroll.js" type="text/javascript"></script>
<script src="js/owl.carousel.js" type="text/javascript"></script>
<script src="js/script.js" type="text/javascript"></script>
<script src="js/slow_move.js" type="text/javascript"></script>
</head>
<body>
<!--header-->
	<div class="header">
		<div class="container">
			<div class="header-logo">
				<h1><a href="<?php Log::RawEcho(Web::GetLoginPage()); ?>">Visg</a></h1>
			</div>
			<div class="top-nav">
				<ul class="nav1">
					<span><a href="<?php Log::RawEcho(Web::GetLoginPage()); ?>" class="house"> </a></span>
					<li><a href="#log_in" class="askLogIn">LOG IN</a></li>
					<li><a href="#recent_news" class="askRecentNews">RECENT NEWS</a></li>
					<li><a href="#contact" class="askContact">CONTACT</a></li>
				</ul>
			</div>
			<div class="clearfix"> </div>
		</div>
	</div>
	<!--//header-->


<!--banner-starts-->
<div class="banner" id="cover_obj">
	<div class="container" class="v_show">
		<div class="banner-main">
			<div  id="top" class="callbacks_container">
				<ul class="rslides" id="slider4">
					<li>
						<div class="banner-top">
							<h1>
								<span>Welcome to</span>
								<span class="an"><?php Log::RawEcho(Configure::$COURSE); ?> Course </span>
								<span>home page!</span>
							</h1>
							<h2></h2>
							<p></p>
							<div class="banner-bottom">
								<div class="banner-left">
									<a href="#log_in" class="get askLogIn">Log In</a>
								</div>
								<div class="banner-left">
									<a href="#contact" class="fut askContact">Contact</a>
									</div>
									<div class="clearfix"> </div>
								</div>
							</div>
						</li>
					</ul>
				</div>
			  <div class="clearfix"> </div>
			</div>
		</div>
		<div class="center">
			<div class="v_caption">
				<div class="highlight_tip">
					<span class="current">1</span>
					<span id = "2">2</span>
					<span id = "3">3</span>
					<span id = "4">4</span>
					<span id = "5">5</span>
			</div>
		</div>
	</div>
</div>
	<!--banner-ends-->

	<!--contact start here-->
<div class="contact" id="log_in">
	<div class="container">
		<div class="contact-main">
			<h3>Log In</h3>
			<div class="contact-right">
			  <form>
			  <!--
				<input type="text" value="UserName : student ID" class="name"
				onFocus="this.value = '';"
				onBlur="if (this.value == '') {this.value = 'UserName : student ID';}">
				-->
				<input type="text" placeholder="UserName : student ID" class="name">
				<input type="text" placeholder="Password : default is your student ID">
			   	<input type="submit" value="Log In">
			 </form>
		   </div>
		  <div class="clearfix"> </div>
		</div>
	</div>
</div>
<!--contact end here-->

<!--recent news start here-->
	<div class = "recent_news" id="recent_news">
		  <h3>Recent News:</h3>
		  	<div class = "recent_news_list">
		 		 <ul>
			 		 <li>2016-06-06.	第三次大作业截止时间提前至6月10日，请大家抓紧时间提交大作业。
					<br></li>
					<li>2016-05-19.	第三次大作业已经发布，截止时间是6月18日。
					<br></li>
					<li>2016-03-23.	该系统只发布概率论大作业，需要概率论课件和ppt的同学请下课后到讲台自行拷贝。
					<br></li>
					<li>2016-03-21.	使用360浏览器的同学建议使用极速模式（地址栏最右边有个按钮可以切换）
					<br></li>
					<li>2016-03-20.	浏览效果比较好的是Chrome，Firefox， Edge。
					<br></li>
					<li>2016-03-15.	第二次大作业已经发布，截止日期是4月10日。
					<br></li>
					<li>2016-03-15.	第一次大作业已经发布，截止日期是3月31日。
					<br></li>
					<li>2016-03-13.	用户名和初始密码就是学号，修改后的密码是大小写敏感的。
					<br></li>
					<li>2016-03-13.	本系统不开放注册，有少量同学的学号没有导入系统的，请邮件我们；
					忘记密码的，请课上联系助教或者直接到电子楼305实验室。
					<br></li>
					<li>2016-03-13.	因时间关系，没有实现更多的功能。任何问题、交流或者发现了bug，
					请联系我们：probability2016@163.com
					<br></li>
				</ul>
		  	</div>
		  </div>
<!--recent news end here-->


<!--real_contact start here-->
<section id="navigation"></section>
        <!-- Contact Area -->
<section id="contact" class="mapWrap">
	<div id="googleMap" style="width:100%;"></div>
	<div id="contact-area">
		<div class="container">
			<div class="row">
				<div class="col-xs-12">
				</div>
				<div class="col-sm-6">
					<div class="moreDetails">
						<h2 class="con-title">Contact Us</h2>
						<p> Lorem ipsum dolor sit amet, consectetur adipisicing elit.
						Voluptatum animi repudiandae nihil aspernatur repellat temporibus
						doloremque sint ea laboriosam, excepturi iure inventore rerum
						voluptatibus, suscipit totam, sit necessitatibus.
						Rerum, blanditiis. </p>
						<ul class="address">
							<li><i class="pe-7s-map-marker"></i><span>1600 Pennsylvania Ave
							NW,<br>Washington, DC 20500,<br>United States</span></li>
							<li><i class="pe-7s-mail"></i><span>example@gmail.com</span></li>
							<li><i class="pe-7s-phone"></i><span>+1-202-555-0144</span></li>
							<li><i class="pe-7s-global"></i><span><a href="#">
							www.themewagon.com</a></span></li>
						</ul>
					</div>
				</div>
			</div>
		</div><!-- container -->
	</div><!-- contact-area -->
</section><!-- contact -->
<!--real_contact end here-->


<!--footer-starts-->
	<div class="footer">
		<div class="container">
			<div class="footer-text">
				<div class="col-md-6 footer-left">
					<p>Copyright &copy; 2016.Visg All rights reserved.</p>
				</div>
				<div class="clearfix"></div>
			</div>
		</div>
	</div>
	<!--footer-end-->

</body>
</html>
