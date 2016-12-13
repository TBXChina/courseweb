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
            for ( $i = ($size - 1); $i >= 0; $i-- ) {
                $str .= $prefix."   <li>\n";
                $str .= $prefix."       ".$rs[$i][self::$NEWSTABLE_TIME].". ".
                        $rs[$i][self::$NEWSTABLE_MSG]."<br>\n";
                $str .= $prefix."   </li>\n";
            }
            $str   .= $prefix."</ul>";
            Log::Echo2Web($str);
        }
    }
?>
