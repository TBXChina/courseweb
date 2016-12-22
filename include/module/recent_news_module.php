<?php
    include_once "include/module/module.php";
    include_once "include/configure.php";
    include_once "include/common/log.php";
    include_once "include/common/fun.php";
    include_once "include/common/table_manager.php";

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
            $prefix = Fun::NSpaceStr($this->spaceNum);
            $str    = $prefix."<ul>\n";
            $size   = count($rs);
            if ( 0 == $size ) {
                Log::Echo2Web($prefix."<p>No news now</p>");
                return;
            }
            for ( $i = ($size - 1); $i >= 0; $i-- ) {
                $str .= $prefix."   <li>\n";
                $str .= $prefix."       <b>".$rs[$i][self::$NEWSTABLE_TIME]."</b><br>\n";
                $str .= $prefix."       <p>". $rs[$i][self::$NEWSTABLE_MSG]."</p>\n";
                $str .= $prefix."   </li>\n";
            }
            $str   .= $prefix."</ul>\n";
            Log::RawEcho($str);
        }
    }
?>
