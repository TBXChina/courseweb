<?php
    include_once "include/common/web.php";
    session_start();
    include_once "include/service/session_service.php";
    $url = $_SERVER["PHP_SELF"];
    $s = new SessionService($url);
    $s->Run();
?>
<!DOCTYPE html>
<body>
<?php
    include_once "include/module/login_form_module.php";
    include_once "include/service/login_service.php";
    $m = new LoginFormModule(2);
    $m->Display();

    $ls = new LoginService(LoginFormModule::GetLoginButton(),
                           LoginFormModule::GetUsername(),
                           LoginFormModule::GetPassword());
    $ls->Run();
?>
</body>
