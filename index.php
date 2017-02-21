<?php
    include_once "include/configure.php";
    include_once "include/common/log.php";
    include_once "include/common/web.php";
    include_once "include/service/session_service.php";

    //start up session service
    $sessionService = new SessionService(Web::GetCurrentPage());
    $sessionService->Run();
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
    <link rel="stylesheet" href="css/font_icon/css/pe-icon-7-stroke.css" type='text/css'/>
    <link rel="stylesheet" href="css/font_icon/css/helper.css" type='text/css'/>
    <link rel='stylesheet' href="css/style_animate_part.css" type='text/css' />
    <link rel="stylesheet" href="font_icon/css/pe-icon-7-stroke.css" type='text/css'/>
    <link rel="stylesheet" href="font_icon/css/helper.css" type='text/css'/>
    <link rel="stylesheet" href="css/owl.carousel.css" type='text/css'/>
    <link rel="stylesheet" href="css/owl.theme.css" type='text/css'/>
    <link rel="stylesheet" href="css/animate.css" type='text/css'/>
    <link rel="stylesheet" href="css/font.css" type='text/css'/>
    <!-- <link rel="stylesheet" href="css/style_contact.css" type='text/css'/> -->

    <!-- emoji -->
    <link rel="stylesheet" href="css/emoji.css" type='text/css'/>

    <!-- scripts-->
    <script src="js/jquery-2.1.3.min.js" type="text/javascript"></script>
    <script src="js/modernizr.js" type="text/javascript"></script>
    <script src="js/bootstrap.min.js" type="text/javascript"></script>
    <!-- <script src="js/googleAPI.js" type="text/javascript"></script> -->
    <script src="js/move-top.js" type="text/javascript"></script>
    <script src="js/easing.js" type="text/javascript"></script>
    <script src="js/interactive.js" type="text/javascript"></script>
    <script src="js/responsiveslides.min.js" type="text/javascript"></script>
    <script src="js/jquery.actual.min.js" type="text/javascript"></script>
    <script src="js/smooth-scroll.js" type="text/javascript"></script>
    <script src="js/owl.carousel.js" type="text/javascript"></script>
    <script src="js/script.js" type="text/javascript"></script>
    <script src="js/slow_move.js" type="text/javascript"></script>
    <script src="js/browser.js" type="text/javascript"></script>
    <script type="text/javascript" src = "http://webapi.amap.com/maps?v=1.3&key=e36412affa2229780f8d052a3249de45"></script>
    <script>
        getOs();
    </script>
</head>

<body>
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
             <?php
                include_once "include/service/login_service.php";
                include_once "include/module/login_form_module.php";
                //start up login service
                Log::RawEcho("   <!-- Login Form -->\n");
                $loginService = new LoginService(LoginFormModule::GetLoginButton(),
                                                 LoginFormModule::GetUserID(),
                                                 LoginFormModule::GetPassword());
                $loginService->Run();
                //display the Login Form
                $loginFormModule = new LoginFormModule(16);
                $loginFormModule->Display();
             ?>
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
            <?php
                include_once "include/module/recent_news_module.php";
                Log::RawEcho("<!-- Recent News ul -->\n");
                $recentNewsModule = new RecentNewsModule(12);
                $recentNewsModule->Display();
            ?>
        </div>
</div>
<!--recent news end here-->

<!-- map -->
<div id="contact">
    <script>
        var map = new AMap.Map('contact', {
                  zoom: 17,
                  center: [118.9615169379,32.1108455072] //Panzhonglai Building Longitude and Latitude
                  });

        var marker = new AMap.Marker({
                     position: [118.9615169379,32.1108455072],
                     map: map
                     });

        //scale rule
        AMap.plugin(['AMap.ToolBar', 'AMap.Scale'], function(){
                   var toolBar = new AMap.ToolBar();
                   var scale   = new AMap.Scale();
                   map.addControl(toolBar);
                   map.addControl(scale);
                   });
    </script>
</div>

<!-- Contact Area -->
<div class="container" id="text">
    <div>
        <div class="moreDetails">
            <h2 class="con-title">Contact Us</h2>
            <p>Authors: <?php Log::RawEcho(Configure::$AUTHORS); ?></p>
            <ul class="address">
                <li>
                    <i class="pe-7s-map-marker"></i>
                    <span>
                        305 Room, Panzhonglai Building,<br>
                        163, Xianlin Avenue,<br>
                        Nanjing, Jiangsu Province, China<br>
                    </span>
                </li>
                <li>
                    <i class="pe-7s-mail"></i>
                    <span>
                        <?php Log::RawEcho(Configure::$COURSE_EMAIL."\n"); ?>
                    </span>
                </li>
                <li>
                    <i class="pe-7s-global"></i>
                    <span>
                        <a href="<?php Log::RawEcho(Configure::$URL); ?>">
                        <?php
                            Log::RawEcho(Configure::$URL."\n");
                        ?>
                        </a>
                    </span>
                </li>
            </ul>
        </div><!-- moreDetails -->
    </div><!-- row -->
</div><!-- container -->

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
