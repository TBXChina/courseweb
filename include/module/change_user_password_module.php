<?php
    include_once "include/module/module.php";
    include_once "include/common/log.php";
    include_once "include/common/fun.php";
    include_once "include/common/web.php";

    class ChangeUserPasswordModule implements Module {
        private $spaceNum;

        static private $CHANGEPWDBUTTON  = "ChangeUserPassword_Change";
        static private $USERID           = "ChangeUserPassword_id";
        static private $USERPWD          = "ChangeUserPassword_pwd";

        static public function GetChangePasswordButton() {
            return self::$CHANGEPWDBUTTON;
        }

        static public function GetUserID() {
            return self::$USERID;
        }

        static public function GetUserPassword() {
            return self::$USERPWD;
        }

        public function __construct($spaceNum) {
            $this->spaceNum = $spaceNum;
        }

        public function Display() {
            $prefix = Fun::NSpaceStr($this->spaceNum);
            //change pwd
            $str  = $prefix."<h3>Change User Password</h3>\n";
            $str .= $prefix."<form action = \"".
                    Web::GetCurrentPage()."\" method = \"post\">\n";
            $str .= $prefix."    <input type = \"text\" name = \"".
                    self::$USERID."\" placeholder = \"Student ID\" required>\n";
            $str .= $prefix."    <input type = \"password\" name = \"".
                    self::$USERPWD."\" placeholder = \"New Password\" required>\n";
            $str .= $prefix."    <input type = \"submit\" name = \"".
                    self::$CHANGEPWDBUTTON."\" value = \"Change\">\n";
            $str .= $prefix."</form>\n";
            Log::RawEcho($str);
        }
    }
?>
