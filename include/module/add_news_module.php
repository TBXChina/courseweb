<?php
    include_once "include/module/module.php";
    include_once "include/common/log.php";
    include_once "include/common/fun.php";
    include_once "include/common/web.php";

    //add news in login page
    class AddNewsModule implements Module {
        private $spaceNum;
        private $TextRows;
        private $TextCols;

        static private $ADD      = "AddNews_Add";
        static private $NEWSTEXT = "AddNews_Text";

        public function __construct($spaceNum, $rows, $cols) {
            $this->spaceNum = $spaceNum;
            $this->TextRows = $rows;
            $this->TextCols = $cols;
        }

        static public function GetAddButton() {
            return self::$ADD;
        }

        static public function GetNewsText() {
            return self::$NEWSTEXT;
        }

        public function Display() {
            $prefix = Fun::NspaceStr($this->spaceNum);
            $str  = $prefix."<form action = \"".
                    Web::GetCurrentPage()."\" method = \"post\">\n";
            $str .= $prefix."    <textarea name = \"".
                    self::$NEWSTEXT."\" rows = \"".
                    $this->TextRows."\" cols = \"".
                    $this->TextCols."\" required></textarea><br><br>\n";
            $str .= $prefix."    <input type = \"submit\" name = \"".
                    self::$ADD."\" value = \"Add\">\n";
            $str .= $prefix."</form>\n";
            Log::RawEcho($str);
        }
    }
?>
