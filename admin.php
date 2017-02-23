<?php
    include_once "include/common/user.php";
    include_once "include/common/log.php";
    include_once "include/common/web.php";
    include_once "include/common/fun.php";
    include_once "include/module/export_homework_module.php";
    include_once "include/service/session_service.php";
    include_once "include/service/download_service.php";
    include_once "include/service/export_homework_service.php";
    include_once "include/service/query_homework_service.php";
    include_once "include/module/assignments_module.php";
    include_once "include/service/assignments_service.php";

    $sessionService = new SessionService(Web::GetCurrentPage());
    $sessionService->Run();
    //if login, get user
    $user = $sessionService->GetLegalUser();
    if ( is_null($user) ) {
        Web::Jump2Web(Web::GetLoginPage());
    }

    //services
    //1. export service
    $exportHomeworkService = new ExportHomeworkService(ExportHomeworkModule::GetExportButton(),
                                                       ExportHomeworkModule::GetHomeworkNo());
    $exportHomeworkService->Run();

    //2. download for query students' homework
    //get the storeDir
    $infoFromPrePage = new PassInfoBetweenPage();
    $storeDir = $infoFromPrePage->GetInfo(QueryHomeworkService::GetStoreDir());
    if ( !is_null($storeDir) ) {
        $downloadService_4_queryhomework = new DownloadService(QueryHomeworkService::GetDownloadButton(),
                                                               QueryHomeworkService::GetFileName(),
                                                               $storeDir);
        $downloadService_4_queryhomework->Run();
    }

    //3. download for assignment
    $assignDir = Configure::$ASSIGNMENTDIR;
    $downloadService_4_assigments = new AssignmentsDownloadService(AssignmentsModule::GetDownloadButton(),
                                                                   AssignmentsModule::GetFileName(),
                                                                   $assignDir);
    $downloadService_4_assigments->Run();

    //4. delete for assignment
    $assignmentDir = Configure::$ASSIGNMENTDIR;
    //delete service
    $deleteService_4_assignment = new AssignmentsDeleteService(AssignmentsModule::GetDeleteButton(),
                                                               AssignmentsModule::GetFileName(),
                                                               $assignmentDir);
    $deleteService_4_assignment_result = $deleteService_4_assignment->Run();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin Console</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

    <!-- stylesheets -->
    <link href="css/style.css" rel='stylesheet' type='text/css' />
    <link href="css/bootstrap.css" rel='stylesheet' type='text/css' />
    <link href="css/font_icon/css/pe-icon-7-stroke.css" rel="stylesheet"  type='text/css'/>
    <link href="css/font_icon/css/helper.css" rel="stylesheet" type='text/css'/>
    <link href="css/discuss_board.css" rel='stylesheet' type='text/css' />
    <link href="css/user_manager.css" rel='stylesheet' type='text/css' />
    <link href="css/OS.css" rel='stylesheet' type='text/css' />
    <link href="css/TW.css" rel='stylesheet' type='text/css' />
    <link href="css/googleFont.css" rel='stylesheet' type='text/css' />

    <!-- emoji -->
    <link rel="stylesheet" href="css/emoji.css" type='text/css'/>

    <!-- button style-->
    <link href="css/button.css" rel='stylesheet' type='text/css'>

    <!--webfonts-->
    <link href='css/italic.css' rel='stylesheet' type='text/css'>

    <!--//webfonts-->
    <link href="css/about.css" rel='stylesheet' type='text/css' />
    <link href="css/style_about.css" rel='stylesheet' type='text/css' />

    <!-- scripts -->
    <script src="js/jquery-2.1.3.min.js" type="text/javascript"></script>
    <script src="js/addClassRoot.js" type="text/javascript"></script>
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
                <h1>VISG</h1>
            </div>
            <div class="top-nav">
                <ul class="nav1">
                    <span><a href="<?php Log::RawEcho(Web::GetLoginPage()); ?>" class="house"> </a></span>
                    <li><a href="#distribute" id="askDistribute">DISTRIBUTE</a></li>
                    <li><a href="#addnews" id="askAddnews">ADDNEWS</a></li>
                    <li><a href="#export"  id="askExport">EXPORT</a></li>
                    <li><a href="#assignments" id="askAssignments">ASSIGNMENTS</a></li>
                    <li><a href="#extra" id="askExtra">EXTRA</a></li>
                </ul>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>

    <div class="single">
        <div class="container">
            <div class="col-md-8 single-main">
                <div class="single-grid">
                    <img src="images/6.jpg" alt="cover image"/>
                </div>
                <ul class="comment-list comment-border"  id="distribute">
                    <h3 class="post-author_head">Distribute Assignment</h3>
                    <li>
                        <div class="desc">
                            <?php
                                include_once "include/module/distribute_module.php";
                                include_once "include/service/upload_service.php";
                                include_once "include/service/distribute_service.php";
                                Log::RawEcho("<!-- Distribute Module -->\n");
                                //start up distribute service
                                $saveDir = Configure::$ASSIGNMENTDIR;
                                $distributeService = new DistributeService($user->GetId(),
                                                                           DistributeModule::GetUploadButton(),
                                                                           DistributeModule::GetFileName(),
                                                                           DistributeModule::GetSaveFileName(),
                                                                           $saveDir);
                                if ( $distributeService->run() ) {
                                    Log::Echo2Web("<p>Upload success</p>");
                                }
                                //display the form
                                $distributeModule = new DistributeModule(28);
                                $distributeModule->Display();
                            ?>

                            <div class = "man-info">
                                <?php
                                    include_once "include/module/notices_module.php";
                                    Log::RawEcho("<!-- Notices -->\n");
                                    $noticesModule = new NoticesModule(32);
                                    $noticesModule->Display();
                                ?>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    </li>
                </ul>

                <ul class="comment-list comment-border"  id="addnews">
                    <h3 class="post-author_head">Add News in Login Page</h3>
                    <li>
                        <?php
                            include_once "include/module/add_news_module.php";
                            include_once "include/service/add_news_service.php";
                            Log::RawEcho("<!-- Add News Module -->\n");
                            $newsTextRows = 5;
                            $newsTextCols = 60;
                            $addNewsModule = new AddNewsModule(24, $newsTextRows, $newsTextCols);
                            $addNewsModule->Display();

                            //start up add news service
                            $addNewsService = new AddNewsService(AddNewsModule::GetAddButton(),
                                                                 AddNewsModule::GetNewsText());
                            $rs = $addNewsService->Run();
                            if ( !is_null($rs) ) {
                                if ( true == $rs ) {
                                    Log::Echo2Web("<p>Add News Success</p>");
                                } else {
                                    Log::Echo2Web("<p>Add News Fail</p>");
                                }
                            }
                        ?>
                    </li>
                </ul>

                <ul class="comment-list comment-border" id="export">
                    <h3 class="post-author_head">Export Submitted Homework</h3>
                    <li>
                        <div class="desc">
                            <?php
                                include_once "include/module/export_homework_module.php";
                                Log::RawEcho("<!-- Export Module -->\n");
                                $exportHomeworkModule = new ExportHomeworkModule(28);
                                $exportHomeworkModule->Display();
                                //start up export, will cause download, so need to start on the top
                                /*export code*/
                            ?>
                        </div>
                        <div class="clearfix"></div>
                    </li>
                </ul>

                <ul class="comment-list comment-border"  id="assignments">
                    <h3>Assignments</h3><br/>
                    <div>
                        <?php
                            include_once "include/module/assignments_module.php";
                            include_once "include/service/delete_service.php";
                            Log::RawEcho("<!-- Assignments Module -->\n");
                            $assignmentDir = Configure::$ASSIGNMENTDIR;
                            if ( true == $deleteService_4_assignment_result ) {
                                Log::Echo2Web("<p>Delete File success.</p>");
                            }
                            $assignmentsModule = new AssignmentsModule(24, $assignmentDir, $user);
                            $assignmentsModule->Display();
                        ?>
                    </div>
                </ul>

                <ul class="user_manager_class" id="extra">
                    <?php
                        include_once "include/module/delete_comment_module.php";
                        include_once "include/service/delete_comment_service.php";
                        include_once "include/service/delete_service.php";
                        include_once "include/module/query_homework_module.php";
                        include_once "include/service/query_homework_service.php";
                        include_once "include/module/change_user_info_module.php";
                        include_once "include/service/change_user_info_service.php";
                        include_once "include/module/insert_user_module.php";
                        include_once "include/service/insert_user_service.php";
                        include_once "include/module/delete_user_module.php";
                        include_once "include/service/delete_user_service.php";
                        include_once "include/module/reset_system_module.php";
                        Log::RawEcho("<!-- user manager module -->\n");
                        //delete comment
                        $deleteCommentModule = new DeleteCommentModule(20);
                        $deleteCommentModule->Display();
                        //delete comment service
                        $deleteCommentService = new DeleteCommentService(DeleteCommentModule::GetDeleteCommentButton(),
                                                                         DeleteCommentModule::GetCommentId());
                        if ( true == $deleteCommentService->Run() ) {
                            Log::Echo2Web("delete success.");
                        }

                        //query
                        $queryHomeworkModule = new QueryHomeworkModule(20);
                        $queryHomeworkModule->Display();
                        $queryHomeworkService = new QueryHomeworkService(20,
                                                                         QueryHomeworkModule::GetQueryButton(),
                                                                         QueryHomeworkModule::GetUserID());
                        $queryHomeworkService->Run();
                        //query download and delete service, download start at the top, here is delete service
                        $infoFromPrePage = new PassInfoBetweenPage();
                        $storeDir = $infoFromPrePage->GetInfo(QueryHomeworkService::GetStoreDir());
                        $deleteService_4_queryhomework = new DeleteService(QueryHomeworkService::GetDeleteButton(),
                                                                           QueryHomeworkService::GetFileName(),
                                                                           $storeDir);
                        if ( true == $deleteService_4_queryhomework->Run() ) {
                            Log::Echo2Web("<p>Delete File success.</p>");
                        }

                        //change user info
                        $changeUserInfoModule = new ChangeUserInfoModule(20);
                        $changeUserInfoModule->Display();
                        //service
                        $changeUserInfoService = new ChangeUserInfoService(ChangeUserInfoModule::GetResetPasswordButton(),
                                                                           ChangeUserInfoModule::GetChangeNameButton(),
                                                                           ChangeUserInfoModule::GetUserId(),
                                                                           ChangeUserInfoModule::GetUserName());
                        if ( true == $changeUserInfoService->Run() ) {
                            Log::Echo2Web("<b>*Change User info success</b>");
                        }

                        //insert user
                        $insertUserModule = new InsertUserModule(20);
                        $insertUserModule->Display();
                        //service
                        $insertUserService = new InsertUserService(InsertUserModule::GetImportButton(),
                                                                   InsertUserModule::GetUserId(),
                                                                   InsertUserModule::GetUserName(),
                                                                   InsertUserModule::GetUserPassword(),
                                                                   InsertUserModule::GetUserRole());
                        if ( true == $insertUserService->Run() ) {
                            Log::Echo2Web("Insert new user success.");
                        }

                        //delete user
                        $deleteUserModule = new DeleteUserModule(20);
                        $deleteUserModule->Display();
                        //service
                        $deleteUserService = new DeleteUserService($user,
                                                                   DeleteUserModule::GetDeleteUserButton(),
                                                                   DeleteUserModule::GetUserId());
                        if ( true == $deleteUserService->Run() ) {
                            Log::Echo2Web("Delete user success");
                        }

                        //reset system
                        $resetSystemModule = new ResetSystemModule(20, $user);
                        $resetSystemModule->Display();
                        //the service start up in another page
                    ?>
                </ul>
            </div><!-- col-md-8 single-main -->
            <!-- left part end -->

            <!-- right part start -->
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
            <!-- right part end -->
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
