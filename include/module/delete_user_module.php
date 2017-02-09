<?php
    include_once "include/module/module.php";
    include_once "include/common/log.php";
    include_once "include/common/fun.php";
    include_once "include/common/web.php";

    class DeleteUserModule implements Module {
        private $spaceNum;

        static private $DELETEUSERBUTTON = "DeleteUser_Delete";
        static private $USERID           = "DeleteUser_UserId";

        public function __construct($spaceNum) {
            $this->spaceNum = $spaceNum;
        }

        static public function GetDeleteUserButton() {
            return self::$DELETEUSERBUTTON;
        }

        static public function GetUserId() {
            return self::$USERID;
        }

        public function Display() {
            $prefix = Fun::NSpaceStr($this->spaceNum);
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
        }
    }
?>
