<?php
    include_once "include/service/service.php";
    include_once "include/common/log.php";
    include_once "include/common/authentication.php";

    //session module, directly concern with authentication
    class SessionService implements Service {
        public function Run() {
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
