<?php
    include_once "include/common/fun.php";
    include_once "include/common/user.php";
    include_once "include/module/discuss_board_module.php";

    $infoFromPre = new PassInfoBetweenPage();
    $user = $infoFromPre->GetInfo(DiscussBoardModule::GetUser2NextPage());
    $m = new DiscussBoardModule(2, $user);
    $m->Display();
?>
