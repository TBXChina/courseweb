<?php
    include_once "include/module.php";
    $homeDir = "/home/tbx/workspace/doc";
    $dm = new DeleteModule(HomeworkListModule::GetDeleteButton(),
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
