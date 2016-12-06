<?php
    include_once "include/module/module.php";
    include_once "include/configure.php";
    include_once "include/common/log.php";
    include_once "include/common/fun.php";
    include_once "include/common/table_manager.php";

    //Login Form
    class LoginFormModule implements Module {
        private $spaceNum;
        static private $USERNAME = "LoginForm_Username";
        static private $PASSWORD = "LoginForm_Password";

        public function __construct($spaceNum) {
            $this->spaceNum = $spaceNum;
        }

        public function Display() {
            //decide whether password is correct
            if (isset($_POST[self::$USERNAME]) &&
                isset($_POST[self::$PASSWORD])) {
                $username = Fun::ProcessUsername($_POST[self::$USERNAME]);
                $password = Fun::ProcessPassword($_POST[self::$PASSWORD]);
                Log::Echo2Web($username);
                Log::Echo2Web($password);
                $tableManager = TableManagerFactory::Create(Configure::$USERTABLE);
                $propArray = Array("id", "password");
                $valueArray = Array($username, $password);
                if ($tableManager->Exist($propArray, $valueArray) ) {
                    Log::Echo2Web("login success");
                } else {
                    Log::Echo2Web("login failed");
                }
            }
            //display the form
            $prefix = Fun::NSpaceStr($this->spaceNum);
            $str    = $prefix."<form action = \"".
                      htmlspecialchars($_SERVER["PHP_SELF"]).
                      "\" method = \"post\">\n";
            $str   .= $prefix."   Username: <input type = \"text\" name = \"".
                       self::$USERNAME.
                       "\" placeholder = \"Student ID\" required><br>\n";
            $str   .= $prefix."   Password: <input type = \"password\" name = \"".
                      self::$PASSWORD.
                      "\" placeholder = \"Default Password is your Student ID\" required><br>\n";
            $str   .= $prefix."   <input type = \"submit\" value = \"Sign in\">\n";
            $str   .= $prefix."</form>\n";
            Log::Echo2Web($str);
        }
    }
?>
