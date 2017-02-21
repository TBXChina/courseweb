<?php
    include_once "include/common/user.php";
    include_once "include/common/log.php";
    include_once "include/common/web.php";
    include_once "include/service/session_service.php";
    include_once "include/module/homework_list_module.php";
    include_once "include/service/download_service.php";
    include_once "include/module/assignments_module.php";

    $sessionService = new SessionService(Web::GetCurrentPage());
    $sessionService->Run();
    //if login, get user
    $user = $sessionService->GetLegalUser();
    if ( is_null($user) ) {
        Web::Jump2Web(Web::GetLoginPage());
    }

    //services
    //1. homework list download
    $homeDir = $user->GetStoreDir();
    $downloadService_4_homeworlist = new DownloadService(HomeworkListModule::GetDownloadButton(),
                                                         HomeworkListModule::GetFileName(),
                                                         $homeDir);
    $downloadService_4_homeworlist->Run();
    //2. assignment download
    $assignDir = Configure::$ASSIGNMENTDIR;
    $downloadService_4_assigments = new DownloadService(AssignmentsModule::GetDownloadButton(),
                                                        AssignmentsModule::GetFileName(),
                                                        $assignDir);
    $downloadService_4_assigments->Run();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Student Console</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

    <!-- stylesheets -->
    <link href="css/style.css" rel='stylesheet' type='text/css' />
    <link href="css/TW.css" rel="stylesheet" type='text/css'>
    <link href="css/OS.css" rel='stylesheet' type='text/css'>
    <link href="css/bootstrap.css" rel='stylesheet' type='text/css' />
    <link href="css/font_icon/css/pe-icon-7-stroke.css" rel="stylesheet"  type='text/css'/>
    <link href="css/font_icon/css/helper.css" rel="stylesheet" type='text/css'/>
    <link href="css/discuss_board.css" rel='stylesheet' type='text/css' />

    <!-- emoji -->
    <link rel="stylesheet" href="css/emoji.css" type='text/css'/>

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
    <script src="js/discuss_board.js" type="text/javascript"></script>
    <script src="js/browser.js" type="text/javascript"></script>
    <script>
        getOs();
    </script>
    <?php
        include_once "include/service/discuss_board_js_service.php";
        Log::RawEcho("<!-- Ajax -->\n");
        $url = "/courseweb/ajax_discuss_board.php";
        $discussBoard_JS_Service = new DiscussBoard_JS_Service(4, $user, $url);
        $discussBoard_JS_Service->Run();
    ?>
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
                    <li><a href="#"><?php Log::RawEcho($user->GetName()); ?></a></li>
                    <li><a href="#submit" id="askSubmit">SUBMIT</a></li>
                    <li><a href="#list" id="askList">LIST</a></li>
                    <li><a href="#assignments" id="askAssignments">ASSIGNMENTS</a></li>
                </ul>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>

    <div class="single">
        <div class="container">
            <!-- middle -->
            <div class="col-md-8 single-main">
                <div class="single-grid">
                    <img src="images/6.jpg" alt="cover image"/>
                </div>

                <ul class="comment-list"  id="submit">
                    <h3 class="post-author_head">Submit homework</h3>
                    <li>
                        <div class="desc">
                            <?php
                                include_once "include/module/submit_module.php";
                                include_once "include/service/upload_service.php";
                                Log::RawEcho("<!-- Submit Form -->\n");
                                $assignDir = Configure::$ASSIGNMENTDIR;
                                $submitModule = new SubmitModule(32, $assignDir, $user);
                                $submitModule->Display();

                                //start up upload service
                                $saveDir = $user->GetStoreDir();
                                $uploadService = new UploadService(SubmitModule::GetUploadButton(),
                                                                   SubmitModule::GetFileName(),
                                                                   SubmitModule::GetSaveFileName(),
                                                                   $saveDir);
                                if ( true == $uploadService->Run() ) {
                                    Log::Echo2Web("<p>Upload success</p>");
                                }
                            ?>

                            <div class = "man-info">
                                <?php
                                    include_once "include/module/notices_module.php";
                                    Log::RawEcho("<!-- Notices -->\n");
                                    $noticesModule = new NoticesModule(36);
                                    $noticesModule->Display();
                                ?>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    </li>
                </ul>

                <ul class="comment-list"  id="list">
                    <h3 class="post-author_head">Your homework lists</h3>
                    <li>
                        <?php
                            include_once "include/module/homework_list_module.php";
                            include_once "include/service/delete_service.php";
                            $homeDir = $user->GetStoreDir();
                            //need start up download and delete service
                            //1. download, must start up at the top
                            /* download service code at the top */
                            //2. delete
                            $deleteService = new DeleteService(HomeworkListModule::GetDeleteButton(),
                                                               HomeworkListModule::GetFileName(),
                                                               $homeDir);
                            if ( true == $deleteService->Run() ) {
                                Log::Echo2Web("<p>Delete File success.</p>");
                            }
                            Log::RawEcho("<!-- homework lists -->\n");
                            $homeworkListModule = new HomeworkListModule(24, $homeDir);
                            $homeworkListModule->Display();
                        ?>
                    </li>
                </ul>

                <ul class="comment-list"  id="assignments">
                    <h3>Assignments</h3><br/>
                    <div>
                        <?php
                            include_once "include/module/assignments_module.php";
                            //download service also need to start up at the top
                            /* download service */
                            //display the assignment module
                            Log::RawEcho("<!-- Assignments Module-->\n");
                            $assignDir = Configure::$ASSIGNMENTDIR;
                            $assignmentsModule = new AssignmentsModule(24, $assignDir, $user);
                            $assignmentsModule->Display();
                        ?>
                    </div>
                </ul>
            </div>

            <!-- right -->
            <div class="col-md-4 side-content">
                <div class="recent">
                    <?php
                        include_once "include/module/user_console_module.php";
                        include_once "include/service/user_console_service.php";
                        Log::RawEcho("<!-- user console module -->\n");
                        $userConsoleModule = new UserConsoleModule(20, $user);
                        $userConsoleModule->Display();

                        //start service
                        $userConsoleService = new UserConsoleService(UserConsoleModule::GetSignoutButton(),
                                                                     UserConsoleModule::GetChangePWDButton(),
                                                                     UserConsoleModule::GetNewPassword(),
                                                                     $user);
                        $rs = $userConsoleService->Run();
                        if ( is_bool($rs) && (true == $rs) ) {
                            Log::Echo2Web("Change Password success.");
                        }
                    ?>
                </div>

                <div class="archives">
                    <h3 style="color:#2ad2c9;font-size: 25pt;">Recent News</h3>
                    <?php
                        include_once "include/module/recent_news_module.php";
                        Log::RawEcho("<!-- recent news module -->\n");
                        $recentNewsModule = new RecentNewsModule(20);
                        $recentNewsModule->Display();
                    ?>
                    <br>
                    <h3 id = "discuss_board_title" style="color:#2ad2c9;font-size: 25pt;" onclick = "Switch_DiscussBoard_Display()">+ Discuss Board</h3>
                    <div id = "control_discuss_board_display" style = "display: none;">
                        <?php
                            include_once "include/module/discuss_board_module.php";
                            Log::RawEcho("<!-- discuss board module -->\n");
                            $nums_to_display = 5;
                            $tableClass = "DS_Comment_List";
                            $buttonClass = "DS_Comment_Button";
                            $submitClass = "DS_Comment_Submit";
                            $discussBoardModule = new DiscussBoardModule(24, $nums_to_display, $user,
                                                                         $tableClass,
                                                                         $buttonClass,
                                                                         $submitClass);
                            $discussBoardModule->Display();
                            $info2NextPage = new PassInfoBetweenPage();
                            //pass num to display
                            $info2NextPage->SetInfo(DiscussBoardModule::GetNums2DisplayName(),
                                                    $discussBoardModule->GetNums2Display());
                            //pass user
                            $info2NextPage->SetInfo(DiscussBoardModule::GetUser2NextPageName(),
                                                    $discussBoardModule->GetUser());
                            //pass class
                            $info2NextPage->SetInfo(DiscussBoardModule::GetTableClass2NextPageName(),
                                                    $discussBoardModule->GetTableClass());
                            $info2NextPage->SetInfo(DiscussBoardModule::GetButtonClass2NextPageName(),
                                                    $discussBoardModule->GetButtonClass());
                            $info2NextPage->SetInfo(DiscussBoardModule::GetSubmitClass2NextPageName(),
                                                    $discussBoardModule->GetSubmitClass());
                            //Notice
                            $discussBoardModule->GetNotices();
                        ?>
                    </div>
                </div>
            </div>

            <div class="clearfix"></div>
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
