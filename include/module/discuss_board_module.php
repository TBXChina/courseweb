<?php
    include_once "include/module/module.php";
    include_once "include/configure.php";
    include_once "include/service/discuss_board_service.php";
    include_once "include/common/log.php";
    include_once "include/common/fun.php";
    include_once "include/common/table_manager.php";

    class DiscussBoardModule implements Module {
        private $nums_to_display; //the number of discussion to display
        private $maxIdinTable;
        private $currentMaxId;

        static private $currentMaxDiscussIdName = "DiscussBoard_max_id";

        static private $divId = "DiscussBoard_table";
        static private $nextPageButton = "NextPageButton";
        static private $previousPageButton = "PreviousPageButton";
        static private $nextPageButtonFun = "PressNextPageButton";
        static private $previousPageButtonFun = "PressPreviousButton";

        public function __construct($nums_to_display) {
            $this->nums_to_display = $nums_to_display;
            //open table
            $tableManager = TableManagerFactory::Create(Configure::$DISCUSSTABLE);
            $sqlstr = "select max(id) from ".Configure::$DISCUSSTABLE;
            $rs = $tableManager->Execute($sqlstr);
            $this->maxIdinTable = (int)$rs[0]["max(id)"];

            //get current id to display
            $infoFromPre = new PassInfoBetweenPage();
            $this->currentMaxId = $infoFromPre->GetInfo(self::$currentMaxDiscussIdName);
            if ( is_null($this->currentMaxId) ) {
                $this->currentMaxId = $this->maxIdinTable;
            }
            $this->currentMaxId = (int)$this->currentMaxId;
        }

        public function GetDivId() {
            return self::$divId;
        }

        public function GetNextPageButtonFun() {
            return self::$nextPageButtonFun;
        }

        public function GetPreviousPageButtonFun() {
            return self::$previousPageButtonFun;
        }

        private function NextPage() {
            $this->currentMaxId -= $this->nums_to_display;
        }

        private function PreviousPage() {
            $this->currentMaxId += $this->nums_to_display;
        }

        public function Display() {
            if ( isset($_POST[self::$nextPageButton]) ) {
                $this->NextPage();
            }

            if ( isset($_POST[self::$previousPageButton])) {
                $this->PreviousPage();
            }

            $id2 = $this->currentMaxId + 1;
            $id1 = $id2 - $this->nums_to_display;
            $service = new DiscussBoardService($id1, $id2);
            $str  = "<div id = \"".self::$divId."\" >\n";
            Log::RawEcho($str);
            $service->Run();
            $str  = "</div>\n";
            $str .= "<table border = 1>\n";
            $str .= "    <tr>\n";
            $str .= "        <td><button type = \"button\" ";
            if ( $id2 >= $this->maxIdinTable) {
                $str .= "disabled = \"disabled\" ";
            }
            $str .= ">Previous Page</button></td>\n";
            $str .= "        <td><button type = \"button\" ";
            if ( $id1 < 0) {
                $str .= "disabled = \"disabled\" ";
            }
            $str .= ">Next Page</button></td>\n";
            $str .= "    </tr>\n";
            $str .= "</table>\n";
            Log::RawEcho($str);
        }
    }
?>
