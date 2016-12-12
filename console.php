<!DOCTYPE html>
<body>
<?php
    include_once "include/common/log.php";
    include_once "include/module/submit_module.php";
    include_once "include/service/upload_service.php";
    include_once "include/common/user.php";

    $user = new Student(154);
    $assignDir = "/usr/local/apache2/htdocs/courseweb";
    $m = new SubmitModule(2, $assignDir, $user);
    $m->Display();

    $saveDir = $user->GetStoreDir();
    $us = new UploadService(SubmitModule::GetUploadButton(),
                            SubmitModule::GetFileName(),
                            SubmitModule::GetSaveFileName(),
                            $saveDir);
    $rs = $us->Run();
    if ( is_null($rs) ) {
        Log::Echo2Web("First");
    } else {
        if ( true == $rs ) {
            Log::Echo2Web("good");
        } else {
            Log::Echo2Web("error");
            Log::Echo2Web(UploadService::UploadLimitsStr());
        }
    }
?>
</body>
