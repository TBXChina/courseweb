<!DOCTYPE html>
<body>
<?php
    include_once "include/module/submit_module.php";
    include_once "include/service/upload_service.php";
    $saveDir = "/home/tbx/workspace/doc";
    $m = new SubmitModule(2);
    $m->Display();

    $us = new UploadService(SubmitModule::GetUploadButton(),
                            SubmitModule::GetFileName(),
                            $saveDir);
    $us->Run();
?>
</body>
