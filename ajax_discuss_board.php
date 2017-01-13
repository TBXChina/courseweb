<?php
    include_once "include/common/fun.php";
    include_once "include/common/user.php";
    include_once "include/module/discuss_board_module.php";

    $infoFromPre = new PassInfoBetweenPage();
    $nums_to_display = $infoFromPre->GetInfo(DiscussBoardModule::GetNums2DisplayName());
    $user = $infoFromPre->GetInfo(DiscussBoardModule::GetUser2NextPageName());
    $tableClass = $infoFromPre->GetInfo(DiscussBoardModule::GetTableClass2NextPageName());
    $buttonClass = $infoFromPre->GetInfo(DiscussBoardModule::GetButtonClass2NextPageName());
    $submitClass = $infoFromPre->GetInfo(DiscussBoardModule::GetSubmitClass2NextPageName());
    $m = new DiscussBoardModule(0, $nums_to_display, $user,
                                $tableClass, $buttonClass, $submitClass);
    $m->Display();
?>
