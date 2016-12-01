<?php
    include_once "include/module.php";
    $homeDir = "/home/tbx/workspace/doc/";
    $dm = new DownloadModule(HomeworkListModule::GetDownloadButton(),
                             HomeworkListModule::GetFileName(),
                             $homeDir);
    $dm->Display();
?>
<!DOCTYPE html>
<body>
<?php
    $m = new HomeworkListModule(2, $homeDir);
    $m->Display();
?>
</body>
