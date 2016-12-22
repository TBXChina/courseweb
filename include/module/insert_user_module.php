<?php
    include_once "include/module/module.php";
    include_once "include/common/log.php";
    include_once "include/common/fun.php";
    include_once "include/common/web.php";

    class InsertUserModule implements Module {
        private $spaceNum;

        static private $IMPORTBUTTON = "InsertUser_Import";
        static private $USERID       = "InsertUser_id";
        static private $USERNAME     = "InsertUser_name";
        static private $USERPWD      = "InsertUser_pwd";
        static private $USERROLE     = "InsertUser_role";

        public function __construct($spaceNum) {
            $this->spaceNum = $spaceNum;
        }

        static public function GetImportButton() {
            return self::$IMPORTBUTTON;
        }

        static public function GetUserId() {
            return self::$USERID;
        }

        static public function GetUserName() {
            return self::$USERNAME;
        }

        static public function GetUserPassword() {
            return self::$USERPWD;
        }

        static public function GetUserRole() {
            return self::$USERROLE;
        }

        public function Display() {
            $prefix = Fun::NSpaceStr($this->spaceNum);
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
        }
    }
?>
