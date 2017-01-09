<?php
    include_once "include/service/discuss_board_js_service.php";

    $s = new DiscussBoard_JS_Service(null, "/cousrweb/index.php", 3);
    $s->Run();
?>
