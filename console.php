<?php
    include_once "include/common/web.php";
    include_once "include/common/log.php";
    include_once "include/service/session_service.php";
    include_once "include/common/user.php";
    $url = $_SERVER["PHP_SELF"];
    $s = new SessionService($url);
    $s->Run();

    $user = $s->GetLegalUser();
    Log::Echo2Web($user->GetId());
    Log::Echo2Web($user->GetName());
    Log::Echo2Web($user->GetPassword());
    Log::Echo2Web($user->GetRole());
?>
