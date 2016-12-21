<!DOCTYPE html>
<body>
<?php
    include_once "include/common/user.php";
    include_once "include/module/user_manager_module.php";
    $user = UserFactory::Create("admin", "root");
    $m = new UserManagerModule(2, $user);
    $m->Display();
?>
</body>
