<?php
    include_once "include/module/module.php";
    include_once "include/configure.php";
    include_once "include/service/discuss_board_service.php";
    include_once "include/common/log.php";
    include_once "include/common/fun.php";
    include_once "include/common/table_manager.php";

    class DiscussBoardModule implements Module {
        private $nums_to_display; //the number of discussion to display
        private $infoBetweenPage; //pass max id between page
        private $maxIdinTable;
        private $currentMaxId;

        static private $currentMaxDiscussIdName = "DiscussBoard_max_id";

        static private $divId = "DiscussBoard_table";

        //button
        static private $firstPageButton       = "FirstPageButton";
        static private $nextPageButton        = "NextPageButton";
        static private $refreshButton         = "RefreshButton";
        static private $previousPageButton    = "PreviousPageButton";
        static private $lastPageButton        = "LastPageButton";

        //callback function when press button
        static private $firstPageButtonFun    = "PressFirstPageButton";
        static private $nextPageButtonFun     = "PressNextPageButton";
        static private $refreshButtonFun      = "PressRefressButton";
        static private $previousPageButtonFun = "PressPreviousButton";
        static private $lastPageButtonFun     = "PressLastPageButton";

        public function __construct($nums_to_display) {
            if ( !is_int($nums_to_display) ) {
                Log::Echo2Web("DiscussBoard::nums_to_display must be int");
                exit(0);
            }
            $this->nums_to_display = $nums_to_display;
            $this->infoBetweenPage = new PassInfoBetweenPage();
            //open table
            $tableManager = TableManagerFactory::Create(Configure::$DISCUSSTABLE);
            $sqlstr = "select max(id) from ".Configure::$DISCUSSTABLE;
            $rs = $tableManager->Execute($sqlstr);
            $this->maxIdinTable = (int)$rs[0]["max(id)"];

            //get current id to display
            $this->currentMaxId = $this->infoBetweenPage->GetInfo(self::$currentMaxDiscussIdName);
            if ( is_null($this->currentMaxId) ) {
                $this->currentMaxId = $this->maxIdinTable;
            }
            $this->currentMaxId = (int)$this->currentMaxId;
        }

        static public function GetDivId() {
            return self::$divId;
        }

        //button
        static public function GetFirstPageButton() {
            return self::$firstPageButton;
        }

        static public function GetPreviousPageButton() {
            return self::$previousPageButton;
        }

        static public function GetRefreshButton() {
            return self::$refreshButton;
        }

        static public function GetNextPageButton() {
            return self::$nextPageButton;
        }

        static public function GetLastPageButton() {
            return self::$lastPageButton;
        }

        //function
        static public function GetFirstPageButtonFun() {
            return self::$firstPageButtonFun;
        }

        static public function GetPreviousPageButtonFun() {
            return self::$previousPageButtonFun;
        }

        static public function GetRefreshButtonFun() {
            return self::$refreshButtonFun;
        }

        static public function GetNextPageButtonFun() {
            return self::$nextPageButtonFun;
        }

        static public function GetLastPageButtonFun() {
            return self::$lastPageButtonFun;
        }

        private function PassCurrentMaxId() {
            $this->infoBetweenPage->SetInfo(self::$currentMaxDiscussIdName, $this->currentMaxId);
        }
        //change currentMaxId private fun
        private function FirstPage() {
            $this->currentMaxId = (int)$this->maxIdinTable;
            $this->PassCurrentMaxId();
        }

        private function PreviousPage() {
            $this->currentMaxId += $this->nums_to_display;
            $this->PassCurrentMaxId();
        }

        private function Refresh() {
            $this->currentMaxId = (int)$this->maxIdinTable;
            $this->PassCurrentMaxId();
        }

        private function NextPage() {
            $this->currentMaxId -= $this->nums_to_display;
            $this->PassCurrentMaxId();
        }

        private function LastPage() {
            $this->currentMaxId = $this->nums_to_display;
            $this->PassCurrentMaxId();
        }

        public function Display() {
            if ( isset($_POST[self::$firstPageButton]) ) {
                $this->FirstPage();
            }

            if ( isset($_POST[self::$previousPageButton])) {
                $this->PreviousPage();
            }

            if ( isset($_POST[self::$refreshButton])) {
                $this->Refresh();
            }

            if ( isset($_POST[self::$nextPageButton]) ) {
                $this->NextPage();
            }

            if ( isset($_POST[self::$lastPageButton]) ) {
                $this->LastPage();
            }

            $id2 = $this->currentMaxId + 1;
            $id1 = $id2 - $this->nums_to_display;
            //Log::Echo2Web($id1);
            //Log::Echo2Web($id2);
            $service = new DiscussBoardService($id1, $id2);
            $str  = "<div id = \"".self::$divId."\" >\n";
            Log::RawEcho($str);
            $service->Run();

            //button
            $str = "<table border = 1>\n";
            $str .= "    <tr>\n";

            //first button
            $str .= "        <td><button type = \"button\" ";
            if ( $id2 > $this->maxIdinTable ) {
                $str .= "disabled = \"disabled\" ";
            }
            $str .= "onclick = \"".self::$firstPageButtonFun."()\"";
            $str .= ">First Page</button></td>\n";

            //previous button
            $str .= "        <td><button type = \"button\" ";
            if ( $id2 > $this->maxIdinTable ) {
                $str .= "disabled = \"disabled\" ";
            }
            $str .= "onclick = \"".self::$previousPageButtonFun."()\"";
            $str .= ">Previous Page</button></td>\n";

            //previous button
            $str .= "        <td><button type = \"button\" ";
            $str .= "onclick = \"".self::$refreshButtonFun."()\"";
            $str .= ">Refresh</button></td>\n";

            //next button
            $str .= "        <td><button type = \"button\" ";
            if ( $id1 <= 1) {
                $str .= "disabled = \"disabled\" ";
            }
            $str .= "onclick = \"".self::$nextPageButtonFun."()\"";
            $str .= ">Next Page</button></td>\n";

            //last button
            $str .= "        <td><button type = \"button\" ";
            if ( $id1 <= 1) {
                $str .= "disabled = \"disabled\" ";
            }
            $str .= "onclick = \"".self::$lastPageButtonFun."()\"";
            $str .= ">Last Page</button></td>\n";

            $str .= "    </tr>\n";
            $str .= "</table>\n";
            $str .= "</div>\n";
            Log::RawEcho($str);
        }
    }
?>
