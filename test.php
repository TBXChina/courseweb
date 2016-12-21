<!DOCTYPE html>
<body>
<?php
    include_once "include/service/export_homework_service.php";
    $s = new ExportHomeworkService("button", "no");
    $s->Run();
?>
</body>
