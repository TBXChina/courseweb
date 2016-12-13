<?php
    include_once "include/module/module.php";
    include_once "include/configure.php";
    include_once "include/common/log.php";
    include_once "include/common/fun.php";
    include_once "include/common/table_manager.php";

    //Login Form
    class LoginFormModule implements Module {
        private $spaceNum;
        static private $LOGIN    = "LoginForm_Login";
        static private $USERNAME = "LoginForm_Username";
        static private $PASSWORD = "LoginForm_Password";

        public function __construct($spaceNum) {
            $this->spaceNum = $spaceNum;
        }

        static public function GetLoginButton() {
            return self::$LOGIN;
        }

        static public function GetUsername() {
            return self::$USERNAME;
        }

        static public function GetPassword() {
            return self::$PASSWORD;
        }

        public function Display() {
            //display the form
            $prefix = Fun::NSpaceStr($this->spaceNum);
            $str    = $prefix."<form action = \"".
                      htmlspecialchars($_SERVER["PHP_SELF"]).
                      "\" method = \"post\">\n";
            $str   .= $prefix."   <input type = \"text\" name = \"".
                       self::$USERNAME.
                       "\" placeholder = \"Username: Student ID\" required>\n";
            $str   .= $prefix."   <input type = \"password\" name = \"".
                      self::$PASSWORD.
                      "\" placeholder = \"Password: Default password is your Student ID\" required>\n";
            $str   .= $prefix."   <input type = \"submit\" name = \"".
                      self::$LOGIN."\" value = \"Log in\">\n";
            $str   .= $prefix."</form>";
            Log::Echo2Web($str);
        }
    }
?>
