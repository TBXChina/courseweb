<!DOCTYPE html>
<body>
<?php
    include_once "module/submit_module.php";
    include_once "module/upload_module.php";
    $homeDir = "/home/tbx/workspace/doc/";
    $m = new SubmitModule(2, $homeDir);
    $m->Display();

    $um = new UploadModule(SubmitModule::GetUploadButton(),
                           SubmitModule::GetFileName(),
                           $homeDir);
    $um->Display();
?>
</body>
