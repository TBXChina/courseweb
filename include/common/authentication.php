<?php
    include_once "include/configure.php";
    //User Authentication
    class Authentication {
        static private $USER;
        static private $LAST_ACCESS;
        static private $VALID_TIME;

        static public function Init() {
            self::$USER         = "AUTHENTICATION_USER";
            self::$LAST_ACCESS  = "AUTHENTICATION_LAST_ACCESS";
            self::$VALID_TIME   = Configure::$SESSION_VALID_TIME;
        }

        public function __construct() {
            if ( !session_id() ) {
                session_start();
            }
            if ( $this->Timeout() ) {
                $this->Destroy();
            }
        }

        private function AllIsset() {
            if ( !isset($_SESSION[self::$USER]) ) {
                return false;
            }
            if ( !isset($_SESSION[self::$LAST_ACCESS]) ) {
                return false;
            }
            return true;
        }

        public function Permission() {
            if ( $this->AllIsset() ) {
                return true;
            } else {
                return false;
            }
        }

        public function SetLegalUser($user) {
            $_SESSION[self::$USER] = $user;
            $_SESSION[self::$LAST_ACCESS] = time();
        }

        public function GetLegalUser() {
            if ( $this->Permission() ) {
                return $_SESSION[self::$USER];
            } else {
                return null;
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
            $_SESSION = array();
            session_destroy();
        }
    }
    Authentication::Init();
?>
