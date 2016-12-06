<?php
    include_once "include/configure.php";
    class Encode {
        static private $salt;

        static public function Init() {
            self::$salt = Configure::$SALT;
        }

        static public function Hash($msg) {
            $msg = self::$salt.$msg;
            $msg = trim($msg);
            $msg = stripslashes($msg);
            $msg = htmlspecialchars($msg);
            return md5($msg);
        }
    }
    Encode::Init();
?>
