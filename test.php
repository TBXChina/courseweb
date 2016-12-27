<!DOCTYPE html>
<body>
<?php
    include_once "include/new_configure.php";
    include_once "include/common/fun.php";
    include_once "include/common/user.php";
    $separator = " ";
    $studentUsers = Fun::ImportUser(Student::GetRole(),
                                       NewConfigure::$STUDENTNAMELISTFILE,
                                         $separator);
    $adminUsers  = Fun::ImportUser(Admin::GetRole(),
                                   NewConfigure::$ADMINNAMELISTFILE,
                                   $separator);
    foreach ($studentUsers as $s) {
        $s->Show();
        Log::Echo2Web("============");
    }

    Log::Echo2Web("Next admin");
    foreach ($adminUsers as $s) {
        $s->Show();
        Log::Echo2Web("============");
    }

    $a = array();
    if (empty($a)) {
        Log::Echo2Web("empty");
    }
?>
</body>
