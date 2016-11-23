<?php
    include_once "include/database.php";
    include_once "include/table_manager.php";
    $dbParam = new DBParam("127.0.0.1", "root", "tbx", "testDB");
    $db = new Database($dbParam);
    $manager = new TableManager($db, "test");
    $prop = Array( "id");
    $value = Array( 2);
    $rs = $manager->Query($prop, $value);
    print_r($rs);
    echo "<br>";
    Log::DebugEcho($_SERVER['SERVER_ADDR']);
?>    
