<?php
    include_once "fun.php";

    interface Module {
        public function Display();
    }

    //Login Form
    class LoginFormModule implements Module {
        private $spaceNum;
        static private $USERNAME = "LoginForm_USERNAME";
        static private $PASSWORD = "LoginForm_PASSWORD";
        public function __construct($spaceNum) {
            $this->spaceNum = $spaceNum;
        }
        public function Display() {
            $prefix = Fun::NSpaceStr($this->spaceNum);
            $str = $prefix."<form action = ".
                   htmlspecialchars($_SERVER["PHP_SELF"]).
                   " method = \"post\">\n";
            $str .= $prefix."   Username: <input type = \"text\" name = \"".
                    self::$USERNAME.
                    "\" placeholder = \"Student ID\" required><br>\n";
            $str .= $prefix."   Password: <input type = \"text\" name = \"".
                    self::$PASSWORD.
                    "\" placeholder = \"Default Password is your Student ID\" required><br>\n";
            $str .= $prefix."   <input type = \"submit\" value = \"Sign in\">\n";
            $str .= $prefix."</form>\n";
            echo $str;

            if (isset($_POST[self::$USERNAME]) &&
                isset($_POST[self::$PASSWORD])) {
                echo $_POST[self::$USERNAME]."<br>";
                echo $_POST[self::$PASSWORD]."<br>";
            }
        }
    }
?>
