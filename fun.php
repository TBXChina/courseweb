<?php
include_once "../include/database.php";

    $dbParam = new DBParam("127.0.0.1", "root", "tbx", "testDB");
    $execSQL = new Database($dbParam);
    $rs = $execSQL->execute("select * from test");
    echo $rs ? 1 : 0;
    echo "<br/>";
    print_r($rs);
    echo "<br/>";

?>
