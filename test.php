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
    include_once "include/configure.php";
    include_once "include/authentication.php";
    include_once "include/user.php";
    echo Configure::$STORE_DIR;
    echo Configure::$AUTHOR;
    echo Configure::$SESSION_VALID_TIME;
    echo "<br>";
    $auth = new Authentication();
    $user = new Admin(12345);
    if ($auth->Permission($user) )
        echo "Permision<br>";
    else
        echo "Not Allow<br>";
?>    
