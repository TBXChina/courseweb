<?php
/*
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
*/
    include_once "include/user.php";
    include_once "include/log.php";
    $user = new Admin(123);
    $user->SetName("tbx");
    $user->SetPwd("aaa");
    Log::DebugEcho($user->Getid());
    Log::DebugEcho($user->GetRole());
    Log::DebugEcho($user->GetName());
    Log::DebugEcho($user->GetPwd());
    
    
?>    
