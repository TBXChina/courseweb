<?php
    include_once "module/login_form_module.php";
    include_once "module/recent_news_module.php";
    include_once "module/session_module.php";
    include_once "module/include/authentication.php";
    include_once "module/include/user.php";

    $se = new SessionModule();
    $se->Display();

    $login = new LoginFormModule(2);
    $login->Display();

    $recent = new RecentNewsModule(2);
    $recent->Display();

?>
