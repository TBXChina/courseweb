<!DOCTYPE html>
<body>
<?php
    include_once "include/configure.php";
    include_once "include/common/database.php";

    $host = Configure::$DBHOST;
    $user = Configure::$DBUSER;
    $pwd  = Configure::$DBPWD;
    $name = "NEWTESTNAME";
    $dbParam = new DBParam($host, $user, $pwd, $name);
    //if ( true == Database::CreateDatabase($dbParam) ) {
    if ( true == Database::DropDatabase($dbParam) ) {
        Log::Echo2Web("good");
    } else {
        Log::Echo2Web("bad");
    }
?>
</body>
