<?php
    include_once "include/module/module.php";
    include_once "include/common/log.php";
    include_once "include/common/fun.php";
    include_once "include/common/web.php";

    class ChangeUserInfoModule implements Module {
        private $spaceNum;

        static private $RESETPWDBUTTON   = "ChangeUserInfo_ResetPassword";
        static private $CHANGENAMEBUTTON = "ChangeUserInfo_ChangeName";
        static private $USERID           = "ChangeUserInfo_id";
        static private $USERNAME         = "ChangeUserInfo_name";

        static public function GetResetPasswordButton() {
            return self::$RESETPWDBUTTON;
        }

        static public function GetChangeNameButton() {
            return self::$CHANGENAMEBUTTON;
        }

        static public function GetUserId() {
            return self::$USERID;
        }

        static public function GetUserName() {
            return self::$USERNAME;
        }

        public function __construct($spaceNum) {
            $this->spaceNum = $spaceNum;
        }

        public function Display() {
            $prefix = Fun::NSpaceStr($this->spaceNum);
            //change pwd
            $str  = $prefix."<h3>Change User Info</h3>\n";
            $str .= $prefix."<form action = \"".
                    Web::GetCurrentPage()."\" method = \"post\">\n";
            $str .= $prefix."    <input type = \"text\" name = \"".
                    self::$USERID."\" placeholder = \"User ID\" required>\n";
            $str .= $prefix."    <input type = \"text\" name = \"".
                    self::$USERNAME."\" placeholder = \"New Name\">\n";
            $str .= $prefix."    <input type = \"submit\" name = \"".
                    self::$CHANGENAMEBUTTON."\" value = \"Change Name\">\n";
            $str .= $prefix."    <input type = \"submit\" name = \"".
                    self::$RESETPWDBUTTON."\" value = \"Reset Password\">\n";
            $str .= $prefix."</form>\n";
            $str .= $prefix."<p>*Password will be reseted same as user id</p>\n";
            Log::RawEcho($str);
        }
    }
?>
