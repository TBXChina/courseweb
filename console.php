<?php
    include_once "include/common/user.php";
    include_once "include/common/log.php";
    include_once "include/common/web.php";
    include_once "include/service/session_service.php";

    $sessionService = new SessionService(Web::GetCurrentPage());
    //$sessionService->Run();
?>
<!DOCTYPE html>
<html>
<head>
<title>Submission</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="Probability Theory Submission System"/>

<!-- stylesheets -->
<link href="css/style.css" rel='stylesheet' type='text/css' />
<link href="css/TW.css" rel="stylesheet" type='text/css'>
<link href="css/OS.css" rel='stylesheet' type='text/css'>
<link href="css/bootstrap.css" rel='stylesheet' type='text/css' />
<link href="css/font_icon/css/pe-icon-7-stroke.css" rel="stylesheet"  type='text/css'/>
<link href="css/font_icon/css/helper.css" rel="stylesheet" type='text/css'/>
<!-- button style-->
<link href="css/button.css" rel='stylesheet' type='text/css'>
<!--webfonts-->
<link href='css/googleapis.css' rel='stylesheet' type='text/css'>
<link href='css/italic.css' rel='stylesheet' type='text/css'>
<!--//webfonts-->
<link href="css/style_about.css" rel='stylesheet' type='text/css' />

<!-- scripts -->
<script src="js/jquery-2.1.3.min.js" type="text/javascript"></script>
<script src="js/addClass.js" type="text/javascript"></script>
<script src="js/ajax.js" type="text/javascript"></script>
<script src="js/slow_move.js" type="text/javascript"></script>
</head>

<body>
<!--header-->
    <div class="header">
        <div class="container">
            <div class="header-logo">
                <h1><a href="index.html">Visg</a></h1>
            </div>
            <div class="top-nav">
                <ul class="nav1">
                    <span><a href="index.html" class="house"> </a></span>
                    <li><a href="#">MG1423021</a></li>
                    <li><a href="#submit" id="askSubmit">SUBMIT</a></li>
                    <li><a href="#list" id="askList">LIST</a></li>
                    <li><a href="#assignments" id="askAssignments">ASSIGNMENTS</a></li>
                </ul>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
    <!--//header-->

<div class="single">
     <div class="container">
          <div class="col-md-8 single-main">
              <div class="single-grid">
                    <img src="images/6.jpg" alt="cover image"/>
              </div>
              <ul class="comment-list"  id="submit">
                <h3 class="post-author_head">Submit homework</h3>
                <li>
                <div class="desc">
                   <form enctype="multipart/form-data"
                            action = "/SubmissionSystem/Welcome.php"
                            method = "post">
                            <p>Choose No.</p>
                            <input type="radio" name = "Select" value = "1" required>
                            1&nbsp&nbsp&nbsp<input type="radio" name = "Select" value = "2" required>
                            2&nbsp&nbsp&nbsp<input type="radio" name = "Select" value = "3" required>
                            3&nbsp&nbsp&nbsp
                            <p>Assignment to submit.</p>
                            <input type="file" name="file" id="file" required=""/>
                            <br/>
                            <input type="submit" name = "SubmitHomework" value = "Upload"/>
                        </form>

                    <!-- implement upload function -->
                                        <!-- upload  -->
                        <div class = "man-info">
                            <b>* Notices:</b>
                            <ul>
                                <li>Size < 20.00 MB </li>
                                <li>Type is pdf/zip</li>
                                <li>Uploaded file will be renamed.</li>
                            </ul>
                        </div>
                </div>
                <div class="clearfix"></div>
              </li>
          </ul>
            <ul class="comment-list"  id="list">
            <h3 class="post-author_head">Your homework lists</h3>
            <!-- implement delete function -->
            <li>
                <form action = "/SubmissionSystem/Welcome.php" method = "post">
                    <table border = "1" border-spacing = "100" >
                            <tr>
                                <td align = "center" ><p>Name</p></td>
                                <td align = "center"><p>Upload Time</p></td>
                                <td align = "center"><p>Size MB</p></td>
                            <tr>
                                <td>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
                                    <input type="radio" name = "fileName" value = "mg1423021_No_3.pdf"
                                    required>&nbsp&nbspmg1423021_No_3.pdf&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
                                </td>
                                <td>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp2016-05-20 21:24:05&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
                                </td>
                                <td align = "center">&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp0.39&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
                                </td></tr>
                         </table>
                         <br>
                         <input type = "submit" name = "Download" value = "Download"/>
                         <input type = "submit" name = "Delete"   value = "Delete"/>
                    </form>
                </li>
            </ul>

            <ul class="comment-list"  id="assignments">
                    <h3>Assignments</h3><br/>
              <div>
                     <form action = "/SubmissionSystem/Welcome.php" method = "post">
                         <ul>
                           <li>
                                 <input type="radio"
                                       name = "fileName"
                                       value = "1.《概率论与随机过程》大作业1.pdf"
                                       required>1.《概率论与随机过程》大作业1.pdf
                             </li>
                             <li>
                                 <input type="radio"
                                       name = "fileName"
                                       value = "2.《概率论与随机过程》大作业2.pdf"
                                       required>2.《概率论与随机过程》大作业2.pdf
                             </li>
                             <li>
                                    <input type="radio"
                                       name = "fileName"
                                       value = "3.《概率论与随机过程》大作业3.pdf"
                                       required>3.《概率论与随机过程》大作业3.pdf
                            </li>
            </ul>
                        <br>
                        <input type = "submit" name = "RequirmentDownload" value = "Download"/>
                  </form>
         </div>
         </ul>
          </div>

            <div class="col-md-4 side-content">
                <div class="recent">
                    <h1>Hello, MG1423021</h1><br>
                    <h3>Your Identity is Student</h3>
                    <form action = "/SubmissionSystem/Welcome.php"
                    method = "post">
                    <input type = "submit" name = "Signout" value = "Sign Out"/>
                </form>
                <br>
                <h3>Change Password </h3>
                <form action = "/SubmissionSystem/Welcome.php" method = "post">
                    <input type = "password"
                    name = "NewPassWD"
                    placeholder = "New Password"
                    required style="line-height: 30px;">
                    <input type="submit" Name = "ChangePassWD" value = "Change"/>
                </form>
            </div>
            <!-- php implement change password function -->

            <div class="archives">
                <h3 style="color:#2ad2c9;font-size: 25pt;">Recent News</h3>
                <ul>
                    <li><b>2016-06-06</b><br/>
                        第三次大作业截止时间提前至6月10日，请大家抓紧时间提交大作业。<br>
                    </li>
                    <li><b>2016-05-19</b><br/>
                        第三次大作业已经发布，截止时间是6月18日。<br>
                    </li>
                    <li><b>2016-03-23</b><br/>
                        该系统只发布概率论大作业，需要概率论课件和ppt的同学请下课后到讲台自行拷贝。<br>
                    </li>
                    <li><b>2016-03-21</b><br/>
                        使用360浏览器的同学建议使用极速模式（地址栏最右边有个按钮可以切换。<br>
                    </li>
                    <li><b>2016-03-20</b><br/>
                        浏览效果比较好的是Chrome，Firefox， Edge。<br>
                    </li>
                    <li><b>2016-03-15</b><br/>
                        第二次大作业已经发布，截止日期是4月10日。<br>
                    </li>
                    <li><b>2016-03-15</b><br/>
                        第一次大作业已经发布，截止日期是3月31日。<br>
                    </li>
                    <li><b>2016-03-13</b><br/>
                        用户名和初始密码就是学号，修改后的密码是大小写敏感的。<br>
                    </li>
                    <li><b>2016-03-13</b><br/>
                        本系统不开放注册，有少量同学的学号没有导入系统的，请邮件我们；
                        忘记密码的，请课上联系助教或者直接到电子楼305实验室。<br>
                    </li>
                    <li><b>2016-03-13</b><br/>
                        因时间关系，没有实现更多的功能。任何问题、交流或者发现了bug，
                        请联系我们：probability2016@163.com<br>
                    </li>
                </ul>
            </div>
        </div>
        <div class="clearfix"></div>
    </div>
</div>
</div>



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
