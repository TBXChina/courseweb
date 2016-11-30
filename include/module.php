<?php
    include_once "fun.php";
    include_once "log.php";
    include_once "table_manager.php";
    include_once "user.php";
    include_once "authentication.php";

    interface Module {
        public function Display();
    }

    //session module, directly concern with authentication
    class SessionModule implements Module {
        public function Display() {
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

    //Login Form
    class LoginFormModule implements Module {
        private $spaceNum;
        static private $USERNAME = "LoginForm_USERNAME";
        static private $PASSWORD = "LoginForm_PASSWORD";

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
            $str    = $prefix."<form action = ".
                      htmlspecialchars($_SERVER["PHP_SELF"]).
                      " method = \"post\">\n";
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

    //Show Recent News in <ul>
    class RecentNewsModule implements Module {
        private $spaceNum;
        static private $NEWSTABLE_ID   = "id";
        static private $NEWSTABLE_MSG  = "message";
        static private $NEWSTABLE_TIME = "time";

        public function __construct($spaceNum) {
            $this->spaceNum = $spaceNum;
        }

        public function Display() {
            $tableManager = TableManagerFactory::Create(Configure::$NEWSTABLE);
            $rs = $tableManager->Query();
            if ( is_bool($rs) && false == $rs ) {
                Log::Echo2Web("Error happened in Recent News.");
            }
            print_r($rs);
            $prefix = Fun::NSpaceStr($this->spaceNum);
            $str    = $prefix."<ul>\n";
            $size   = count($rs);
            for ( $i = ($size - 1); $i >= 0; $i-- ) {
                $str .= $prefix."   <li>\n";
                $str .= $prefix."       ".$rs[$i][self::$NEWSTABLE_TIME].". ".
                        $rs[$i][self::$NEWSTABLE_MSG]."<br>\n";
                $str .= $prefix."   </li>\n";
            }
            $str   .= $prefix."</ul>\n";
            Log::Echo2Web($str);
        }
    }

    //Show Student homework
    class HomeworkListModule implements Module {
            private $spaceNum;
            private $homeDir;
            static private $FILENAME = "HOMEWORKLIST_FILENAME";
            static private $DELETE   = "HOMEWORKLIST_DELETE";

            public function __construct($spaceNum, $homeDir) {
                $this->spaceNum = $spaceNum;
                $this->homeDir  = $homeDir;
            }

            public function Display() {
                if ( isset($_POST[self::$DELETE]) && isset($_POST[self::$FILENAME]) ) {
                    Log::Echo2Web($_POST[self::$FILENAME]);
                }

                $RETURN_VALUE_CONTAINT_SUBDIR = false;
                $files = File::LS($this->homeDir, $RETURN_VALUE_CONTAINT_SUBDIR);
                if ( 0 == count($files) ) {
                    return;
                }
                $prefix      = Fun::NSpaceStr($this->spaceNum);
                $str         = $prefix."<form action = ".
                          htmlspecialchars($_SERVER["PHP_SELF"]).
                          " method = \"post\">\n";
                $str        .= $prefix."    <table border = \"1\" border-spacing = \"100\">\n";
                $str        .= $prefix."        <tr>\n";
                $str        .= $prefix."            <td align = \"center\">Name</td>\n";
                $str        .= $prefix."            <td align = \"center\">Upload Time</td>\n";
                $str        .= $prefix."            <td align = \"center\">Size (MB)</td>\n";
                $str        .= $prefix."        </tr>\n";
                foreach ( $files as $f ) {
                    $str    .= $prefix."        <tr>\n";
                    $str    .= $prefix."            <td><input type = \"radio\" name = \"".
                               self::$FILENAME."\" value = \"".
                               $f."\" required>".
                               $f."</td>\n";
                    $str    .= $prefix."            <td>".
                               date("Y-m-d H:i:s", filectime($this->homeDir."/".$f)).
                               "</td>\n";
                    $str    .= $prefix."            <td align = \"center\">".
                               Fun::Byte2MB(filesize($this->homeDir."/".$f)).
                               "</td>\n";
                    $str    .= $prefix."        </tr>\n";
                }
                $str   .= $prefix."    </table><br>\n";
                $str   .= $prefix."    <input type = \"submit\" name = \"".
                          self::$DELETE."\" value = \"Download\">\n";
                $str   .= $prefix."</form>\n";
                Log::Echo2Web($str);
            }
    }
?>
