<?php
    include_once "include/module/module.php";
    include_once "include/configure.php";
    include_once "include/service/discuss_board_service.php";
    include_once "include/common/log.php";
    include_once "include/common/fun.php";
    include_once "include/common/user.php";
    include_once "include/common/table_manager.php";
    include_once "include/common/discuss.php";

    class DiscussBoardModule implements Module {
        private $nums_to_display; //the number of discussion to display
        private $user;
        private $infoBetweenPage; //pass max id between page
        private $maxIdinTable;
        private $currentMaxId;

        static private $currentMaxDiscussIdName = "DiscussBoard_max_id";

        static private $divId = "DiscussBoard_table";
        static private $textareaId = "DiscussBoard_textareaId";
        static private $textareaContent = "DiscussBoard_textarea";
        static private $userIdTag = "DiscussBoard_userIdTag";
        static private $user2NextPageName = "DiscussBoard_User";

        //button
        static private $firstPageButton        = "FirstPageButton";
        static private $nextPageButton         = "NextPageButton";
        static private $refreshButton          = "RefreshButton";
        static private $previousPageButton     = "PreviousPageButton";
        static private $lastPageButton         = "LastPageButton";
        static private $submitDiscussButton    = "SubmitButton";

        //callback function when press button
        static private $firstPageButtonFun     = "PressFirstPageButton";
        static private $nextPageButtonFun      = "PressNextPageButton";
        static private $refreshButtonFun       = "PressRefressButton";
        static private $previousPageButtonFun  = "PressPreviousButton";
        static private $lastPageButtonFun      = "PressLastPageButton";
        static private $submitDiscussButtonFun = "PressSubmitButton";

        public function __construct($nums_to_display, $user = null) {
            if ( !is_int($nums_to_display) ) {
                Log::Echo2Web("DiscussBoard::nums_to_display must be int");
                exit(0);
            }
            $this->nums_to_display = $nums_to_display;
            $this->user            = $user;
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

        public function GetNums2Display() {
            return $this->nums_to_display;
        }

        public function GetUser() {
            return $this->user;
        }

        static public function GetDivId() {
            return self::$divId;
        }

        static public function GetTextareaId() {
            return self::$textareaId;
        }

        static public function GetTextareaContent() {
            return self::$textareaContent;
        }

        static public function GetUserIdTag() {
            return self::$userIdTag;
        }

        static public function GetUser2NextPage() {
            return self::$user2NextPageName;
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

        static public function GetSubmitButton() {
            return self::$submitDiscussButton;
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

        static public function GetSubmitButtonFun() {
            return self::$submitDiscussButtonFun;
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

        //submit
        private function Submit() {
            if ( !isset($_POST[self::$textareaContent]) ||
                 empty($_POST[self::$textareaContent])) {
                Log::Echo2Web("You can't submit empty comment.");
                return;
            }
            if ( !isset($_POST[self::$userIdTag]) ||
                 empty($_POST[self::$userIdTag])) {
                Log::Echo2Web("who submit the comment?");
                return;
            }
            $userid = Fun::ProcessUserId($_POST[self::$userIdTag]);
            $msg    = Fun::ProcessStr($_POST[self::$textareaContent]);
            $user = UserFactory::Query($userid);
            if ( is_null($user) ) {
                Log::Echo2Web("User: ".$userid." isn't in our system");
                return false;
            }

            //open table, query the newest max id
            $tableManager = TableManagerFactory::Create(Configure::$DISCUSSTABLE);
            //lock the table
            $tableManager->Lock();
            $sqlstr = "select max(id) from ".Configure::$DISCUSSTABLE;
            $rs = $tableManager->Execute($sqlstr);
            $maxIdinTable = (int)$rs[0]["max(id)"];

            $discuss = DiscussFactory::Create($maxIdinTable + 1);
            $discuss->SetState(Discuss::$STATE_VALID);
            $discuss->SetUserId($userid);
            $discuss->SetTime(time());
            $discuss->SetMessage($msg);
            //$discuss->Show();
            $rs = $discuss->Insert2TableManager($tableManager);
            //don't forget to unlock
            $tableManager->Unlock();
            $this->currentMaxId = $discuss->GetId();;
            $this->PassCurrentMaxId();
            return $rs;
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

            $submitResult = null;
            if ( isset($_POST[self::$submitDiscussButton]) ) {
                $submitResult = $this->Submit();
            }

            $id2 = $this->currentMaxId + 1;
            $id1 = $id2 - $this->nums_to_display;
            $service = new DiscussBoardService($this->user, $id1, $id2);
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

            if ( !is_null($this->user) ) {
                $str .= "    <tr>\n";
                $str .= "        <td><textarea id = \"".
                        self::$textareaId."\"></textarea></td>\n";
                $str .= "    </tr>\n";

                $str .= "    <tr>\n";
                $str .= "        <td><button type = \"button\" ";
                $str .= "onclick = \"".self::$submitDiscussButtonFun."()\"";
                $str .= ">Submit</button></td>";
                $str .= "    </tr>\n";
            }

            $str .= "</table>\n";
            $str .= "</div>\n";
            Log::RawEcho($str);

            if ( !is_null($submitResult) ) {
                if (true == $submitResult) {
                    Log::Echo2Web("submit success");
                } else {
                    Log::Echo2Web("submit fail");
                }
            }
        }
    }
?>
