<?php
    include_once "../include/database.php";
    include_once "table_manager.php";

    $dbParam = new DBParam("127.0.0.1", "root", "tbx", "testDB");
    $db = new Database($dbParam);

    $manager = new TableManager($db, 'test');
    if ( $manager->Delete("name", "abc") ) {
        echo "good<br>";
    } else {
        echo "bad<br>";
    }
?>
