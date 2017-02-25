<?php
    include_once "include/module/module.php";
    include_once "include/common/log.php";
    include_once "include/common/fun.php";
    include_once "include/common/web.php";
    include_once "include/common/table_manager.php";

    //add news in login page
    class NewsManagerModule implements Module {
        private $spaceNum;
        private $TextRows;
        private $TextCols;

        static private $ADD      = "NewsManager_Add";
        static private $NEWSTEXT = "NewsManager_Text";
        static private $DELETE   = "NewsManager_Delete";
        static private $NEWSID   = "NewsManager_NewsId";

        static private $NEWSTABLE_ID   = "id";
        static private $NEWSTABLE_MSG  = "message";
        static private $NEWSTABLE_TIME = "time";

        static private $DISPLAY_LENGTH = 20;

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

        static public function GetDeleteButton() {
            return self::$DELETE;
        }

        static public function GetNewsId() {
            return self::$NEWSID;
        }

        public function Display() {
            $prefix = Fun::NspaceStr($this->spaceNum);
            //add news
            $str  = $prefix."<form action = \"".
                    Web::GetCurrentPage()."\" method = \"post\">\n";
            $str .= $prefix."    <textarea name = \"".
                    self::$NEWSTEXT."\" rows = \"".
                    $this->TextRows."\" cols = \"".
                    $this->TextCols."\" required></textarea><br><br>\n";
            $str .= $prefix."    <input type = \"submit\" name = \"".
                    self::$ADD."\" value = \"Add\">\n";
            $str .= $prefix."</form><br>\n";
            Log::RawEcho($str);
            //delete news
            $tableManager = TableManagerFactory::Create(Configure::$NEWSTABLE);
            $rs = $tableManager->Query();
            if ( is_bool($rs) && false == $rs ) {
                Log::Echo2Web("Error happened in Querying news.");
                return;
            }
            $size = count($rs);
            if ( 0 == $size) {
                $str = $prefix."<p>No News Available</p>";
                Log::RawEcho($str);
                return; 
            }
            $str      = $prefix."<form action = \"".
                        Web::GetCurrentPage()."\" method = \"post\">\n";
            $str     .= $prefix."    <select name = \"".
                        self::$NEWSID."\" >\n";
            for ( $i = ($size - 1); $i >= 0; $i--) {
                $newsId  = $rs[$i][self::$NEWSTABLE_ID];
                $newsMsg = $rs[$i][self::$NEWSTABLE_MSG];
                if ( self::$DISPLAY_LENGTH < strlen($newsMsg) ) {
                    $newsMsg = substr($newsMsg, 0, self::$DISPLAY_LENGTH)."...";
                }
                $str .= $prefix."        <option value = \"".
                        $newsId."\">".$newsMsg."</option>\n";
            }
            $str     .= $prefix."    </select><br><br>\n";
            $str     .= $prefix."    <input type = \"submit\" name = \"".
                    self::$DELETE."\" value = \"DELETE\">\n";
            $str     .= $prefix."</form>\n";
            Log::RawEcho($str);
        }
    }
?>
