<?php
    include_once "module.php";
    include_once "include/log.php";
    include_once "include/authentication.php";

    //session module, directly concern with authentication
    class SessionModule implements Module {
        public function Display() {
            $authentication = new Authentication();
            //$authentication->SetLegalRole(Admin::GetRole());
            if ( $authentication->Permission(Admin::GetRole()) ) {
                Log::DebugEcho("You are Admin");
            } else if ( $authentication->Permission(Student::GetRole()) ) {
                Log::DebugEcho("You are Student");
            } else {
                Log::DebugEcho("You are Guest");
            }
        }
    }
?>
