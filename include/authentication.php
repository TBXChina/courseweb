<?php
    //User Authentication
    class 
    class Authentication {
        static private $IDENTITY = "IDENTITY";
        static private $ROLE = "AUTHENTICATION_ROLE";

        public function __construct() {

        }

        public function SetRole($user) {
            $_SESSION[$ROLE] = $user->GetRole();
        }
    }
?>
