<?php
    session_start();
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
