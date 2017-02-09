<?php
    include_once "include/common/initialization.php";
    include_once "include/common/log.php";

    Log::Echo2Web("<h1>Warning: After setup, don't forget to move setup.php out of the Dir</h1>");
    $user = null;
    $NEED_CHECK_USER = false;
    $init = new Initialization($user, $NEED_CHECK_USER);
    $init->Run();
?>
