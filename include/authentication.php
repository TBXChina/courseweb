<?php
    include_once "configure.php";
    //User Authentication
    class Authentication {
        static private $ROLE;
        static private $LAST_ACCESS;
        static private $VALID_TIME;

        static public function Init() {
            self::$ROLE         = "AUTHENTICATION_ROLE";
            self::$LAST_ACCESS  = "AUTHENTICATION_LAST_ACCESS";
            self::$VALID_TIME   = Configure::$SESSION_VALID_TIME;
        }

        public function __construct() {
            session_start();
            if ( self::Timeout() ) {
                self::Destroy();
            }
        }

        public function SetLegalRole($user) {
            $_SESSION[self::$ROLE] = $user->GetRole();
            $_SESSION[self::$LAST_ACCESS] = time();
        }
        public function Permission($user) {
            if ( isset($_SESSION[self::$ROLE]) ) {
                return $_SESSION[self::$ROLE] == $user->GetRole();
            } else {
                return false;
            }
        }

        private function Timeout() {
            if ( isset($_SESSION[self::$LAST_ACCESS]) &&
                 time() - $_SESSION[self::$LAST_ACCESS] > self::$VALID_TIME) {
                return true;
            } else {
                return false;
            }
        }

        private function Destroy() {
            if ( isset($_SESSION[self::$ROLE]) ) {
                unset($_SESSION[self::$ROLE]);
            }
            if ( isset($_SESSION[self::$LAST_ACCESS]) ) {
                unset($_SESSION[self::$LAST_ACCESS]);
            }
        }
    }
    Authentication::Init();
?>
