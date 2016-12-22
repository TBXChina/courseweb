<?php
    include_once "include/module/module.php";
    include_once "include/common/log.php";
    include_once "include/common/fun.php";
    include_once "include/common/web.php";

    class QueryHomeworkModule implements Module {
        private $spaceNum;

        //button
        static private $QUERYBUTTON = "QueryHomework_Query";
        //user
        static private $USERID      = "QueryHomework_UserID";

        public function __construct($spaceNum) {
            $this->spaceNum = $spaceNum;
        }

        static public function GetQueryButton() {
            return self::$QUERYBUTTON;
        }

        static public function GetUserID() {
            return self::$USERID;
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
        }
    }
?>
