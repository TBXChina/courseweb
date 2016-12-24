<?php
    include_once "include/common/fun.php";
    include_once "include/common/user.php";
    include_once "include/module/reset_system_module.php";
    include_once "include/service/reset_system_service.php";

    //get the user
    $infoFromPrePage = new PassInfoBetweenPage();
    $user = $infoFromPrePage->GetInfo(ResetSystemModule::GetUser());
    //service
    $resetSystemService = new ResetSystemService(ResetSystemModule::GetResetButton(),
                                                 $user);
    $resetSystemService->Run();
?>
