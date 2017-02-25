<?php
    include_once "include/configure.php";
    include_once "include/new_configure.php";
    class Encode {
        static private $salt;
        static private $new_salt;

        static public function Init() {
            self::$salt     = Configure::$SALT;
            self::$new_salt = NewConfigure::$SALT;
        }

        static public function Hash($msg) {
            $msg = self::$salt.$msg;
            $msg = trim($msg);
            $msg = stripslashes($msg);
            $msg = htmlspecialchars($msg);
            return md5($msg);
        }

        static public function Hash_with_new_salt($msg) {
            $msg = self::$new_salt.$msg;
            $msg = trim($msg);
            $msg = stripslashes($msg);
            $msg = htmlspecialchars($msg);
            return md5($msg);
        }
    }
    Encode::Init();
?>
