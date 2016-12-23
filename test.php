<!DOCTYPE html>
<body>
<?php
    include_once "include/common/fun.php";
    include_once "include/common/authentication.php";
    $au = new Authentication();
    if ($au->Permission() ) {
        echo "good";
    } else {
        echo "bad";
    }
    $tool = new Info2NextPage();
//    $tool->SetInfo("name", "info");
    echo $tool->GetInfo("name");
?>
</body>
