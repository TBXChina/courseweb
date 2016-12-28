<!DOCTYPE html>
<body>
<?php
    include_once "include/configure.php";
    include_once "include/common/table_manager.php";

    echo date("Y-m-d H:i:s", "1482932697");
    $tableManager = TableManagerFactory::Create(Configure::$USERTABLE);
    $sql = "select * from UserTable where not last_access_time =''";
    $rs = $tableManager->Execute($sql);
    print_r($rs);
?>
</body>
