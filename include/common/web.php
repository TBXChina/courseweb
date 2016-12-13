<?php
    include_once "include/configure.php";
    //some function related to web
    class Web {
        static public function Jump2Web($relativePath) {
            //$url = Configure::$URL."/".$relativePath;
            $url = $relativePath;
            header("Location: $url");
        }

        static public function GetCurrentPage() {
            return htmlspecialchars($_SERVER["PHP_SELF"]);
        }

        static public function GetLoginPage() {
            return Configure::$LOGINPAGE;
        }

        static public function GetConsolePage() {
            return Configure::$CONSOLEPAGE;
        }

        static public function GetAdminConsolePage() {
            return Configure::$ADMINCONSOLEPAGE;
        }
    }
?>
