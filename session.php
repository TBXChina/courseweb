<?php
    include_once "include/common/user.php";
    include_once "include/common/log.php";
    session_start();
    if ( isset($_SESSION["USER"]) ) {
        $user = $_SESSION["USER"];
        Log::Echo2Web($user->GetId());
        Log::Echo2Web($user->GetName());
        Log::Echo2Web($user->GetPassword());
        Log::Echo2Web($user->GetRole());
    }
?>
