<?php
    include_once "include/common/user.php";
    include_once "include/common/log.php";
    include_once "include/common/web.php";
    include_once "include/service/session_service.php";
    include_once "include/module/homework_list_module.php";
    include_once "include/service/download_service.php";
    include_once "include/module/assignments_module.php";

    /*
    $sessionService = new SessionService(Web::GetCurrentPage());
    $sessionService->Run();
    //if login, get user
    $user = $sessionService::GetLegalUser();
    if ( is_null($user) ) {
        Web::Jump2Web(Web::GetLoginPage());
    }
    */
    $user = UserFactory::Create("student", 4);
    $user->SetName("testName");

    //services
    //1. homework list download
    $homeDir = $user->GetStoreDir();
    $downloadService_4_homeworlist = new DownloadService(HomeworkListModule::GetDownloadButton(),
                                                         HomeworkListModule::GetFileName(),
                                                         $homeDir);
    $downloadService_4_homeworlist->Run();
    //2. assignment download
    $assignDir = Configure::$SHARED_DIR."/assign";
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
                                    if ( $uploadService->Run() ) {
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
                            $assignDir = Configure::$SHARED_DIR."/assign";
                            $assignmentsModule = new AssignmentsModule(24, $assignDir, $user);
                            $assignmentsModule->Display();
                        ?>
                    </div>
                </ul>
            </div>

            <div class="col-md-4 side-content">
                <div class="recent">
                    <?php
                        include_once "include/module/user_console_module.php";
                        Log::RawEcho("<!-- user console module -->\n");
                        $userConsoleModule = new UserConsoleModule(20, $user);
                        $userConsoleModule->Display();
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
