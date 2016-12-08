<?php
    include_once "include/service/session_service.php";
    $url = $_SERVER["PHP_SELF"];
    $s = new SessionService($url);
    $s->Run();
?>
