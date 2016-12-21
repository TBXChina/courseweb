<?php
    include_once "include/module/module.php";
    include_once "include/common/log.php";
    include_once "include/common/fun.php";
    include_once "include/common/web.php";
    include_once "include/common/user.php";

    //user manager
    class UserManagerModule implements Module {
        private $spaceNum;
        private $user;

        //button
        static private $QUERYBUTTON      = "UserManager_Query";
        static private $CHANGEPWDBUTTON  = "UserManager_Change";
        static private $IMPORTBUTTON     = "UserManager_Import";
        static private $DELETEUSERBUTTON = "UserManager_Delete";
        static private $RESETBUTTON      = "UserManager_Reset";

        //user
        static private $USERID           = "UserManager_id";
        static private $USERNAME         = "UserManager_name";
        static private $USERPWD          = "UserManager_pwd";
        static private $USERROLE         = "UserManager_role";

        public function __construct($spaceNum, $user) {
            $this->spaceNum = $spaceNum;
            $this->user     = $user;
        }

        static public function GetQueryButton() {
            return self::$QUERYBUTTON;
        }

        static public function GetChangePasswordButton() {
            return self::$CHANGEPWDBUTTON;
        }

        static public function GetImportUserButton() {
            return self::$IMPORTBUTTON;
        }

        static public function GetDeleteUserButton() {
            return self::$DELETEUSERBUTTON;
        }

        static public function GetResetButton() {
            return self::$RESETBUTTON;
        }

        static public function GetUserID() {
            return self::$USERID;
        }

        static public function GetUserName() {
            return self::$USERNAME;
        }

        static public function GetUserPassword() {
            return self::$USERPWD;
        }

        static public function GetUserRole() {
            return sefl::$USERROLE;
        }

        public function Display() {
            $prefix = Fun::NSpaceStr($this->spaceNum);
            //query homework
            $str  = $prefix."<h3>Query Student's Submitted Homework</h3>\n";
            $str .= $prefix."<form action = \"".
                    Web::GetCurrentPage()."\" method = \"post\">\n";
            $str .= $prefix."    <input type = \"text\" name = \"".
                    self::$USERID."\" placeholder = \"Student ID\" required>\n";
            $str .= $prefix."    <input type = \"submit\" name = \"".
                    self::$QUERYBUTTON."\" value = \"Query\">\n";
            $str .= $prefix."</form>\n";
            Log::RawEcho($str);

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

            //insert user
            $str  = $prefix."<h3>Insert New User</h3>\n";
            $str .= $prefix."<form action = \"".
                    Web::GetCurrentPage()."\" method = \"post\">\n";
            $str .= $prefix."    <input type = \"text\" name = \"".
                    self::$USERID."\" placeholder = \"User ID\" required>\n";
            $str .= $prefix."    <input type = \"text\" name = \"".
                    self::$USERNAME."\" placeholder = \"User Name\" required>\n";
            $str .= $prefix."    <input type = \"password\" name = \"".
                    self::$USERPWD."\" placeholder = \"User Password\" required><br>\n";
            $str .= $prefix."    <input type = \"radio\" name = \"".
                    self::$USERROLE."\" value = \"".
                    Student::GetRole()."\" checked = \"true\" required>".
                    Student::GetRole()."\n";
            $str .= $prefix."    <input type = \"radio\" name = \"".
                    self::$USERROLE."\" value = \"".
                    Admin::GetRole()."\" required>".
                    Admin::GetRole()."<br>\n";
            $str .= $prefix."    <input type = \"submit\" name = \"".
                    self::$IMPORTBUTTON."\" value = \"Import\">\n";
            $str .= $prefix."</form>\n";
            Log::RawEcho($str);

            //delete user
            $str  = $prefix."<h3>Delete User<br><span>Warning: This process is irreversible!</span></h3>\n";
            $str .= $prefix."<form action = \"".
                    Web::GetCurrentPage()."\" method = \"post\">\n";
            $str .= $prefix."    <input type = \"text\" name = \"".
                    self::$USERID."\" placeholder = \"User ID\" required>\n";
            $str .= $prefix."    <input type = \"submit\" name = \"".
                    self::$DELETEUSERBUTTON."\" value = \"Delete\">\n";
            $str .= $prefix."</form>\n";
            Log::RawEcho($str);

            //reset sytem
            if ( Admin::GetRole() == $this->user->GetRole() &&
                 "root" == $this->user->GetId() ) {
                $str  = $prefix."<h3>Reset All System<br><span>Waring: It is very dangerous, use very carefully!</span></h3>\n";
                $str .= $prefix."<form action = \"".
                        Web::GetCurrentPage()."\" method = \"post\">\n";
                $str .= $prefix."    <input type = \"submit\" name = \"".
                        self::$RESETBUTTON."\" value = \"Reset System\">\n";
                $str .= $prefix."</form>\n";
                Log::RawEcho($str);
            }
        }
    }
?>
