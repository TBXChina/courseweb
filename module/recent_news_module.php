<?php
    include_once "module.php";
    include_once "include/log.php";
    include_once "include/fun.php";
    include_once "include/table_manager.php";
    include_once "include/configure.php";

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
            print_r($rs);
            $prefix = Fun::NSpaceStr($this->spaceNum);
            $str    = $prefix."<ul>\n";
            $size   = count($rs);
            for ( $i = ($size - 1); $i >= 0; $i-- ) {
                $str .= $prefix."   <li>\n";
                $str .= $prefix."       ".$rs[$i][self::$NEWSTABLE_TIME].". ".
                        $rs[$i][self::$NEWSTABLE_MSG]."<br>\n";
                $str .= $prefix."   </li>\n";
            }
            $str   .= $prefix."</ul>\n";
            Log::Echo2Web($str);
        }
    }
?>
