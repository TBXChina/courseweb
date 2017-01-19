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
        private $spaceNum;
        private $nums_to_display; //the number of discussion to display
        private $user;
        private $tableClass;
        private $buttonClass;
        private $submitClass;

        private $infoBetweenPage; //pass max id between page
        private $maxIdinTable;
        private $currentMaxId;

        static private $currentMaxDiscussIdName = "DiscussBoard_max_id";

        static private $nums_to_displayName = "DiscussBoard_Nums_to_Display";
        static private $divId = "DiscussBoard";
        static private $textareaId = "DiscussBoard_textareaId";
        static private $textareaContent = "DiscussBoard_textarea";
        static private $userIdTag = "DiscussBoard_userIdTag";
        static private $user2NextPageName = "DiscussBoard_User";

        //class name to next page
        static private $tableClass2NextPageName = "DiscussBoard_TableClass";
        static private $buttonClass2NextPageName = "DiscussBoard_ButtonClass";
        static private $submitClass2NextPageName = "DiscussBoard_SubmitClass";

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

        public function __construct($spaceNum, $nums_to_display, $user = null,
                                    $tableClass = "", $buttonClass ="", $submitClass = "") {
            if ( !is_int($nums_to_display) ) {
                Log::Echo2Web("DiscussBoard::nums_to_display must be int");
                exit(0);
            }
            $this->spaceNum        = $spaceNum;
            $this->nums_to_display = $nums_to_display;
            $this->user            = $user;
            $this->tableClass      = $tableClass;
            $this->buttonClass     = $buttonClass;
            $this->submitClass     = $submitClass;

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

        public function GetNotices() {
            $prefix = Fun::NSpaceStr($this->spaceNum);
            $str  = $prefix."<b>* Notices:</b>\n";
            $str .= $prefix."<ol>\n";
            $str .= $prefix."    <li><b>Warning:</b> don't abuse anyone.</li>\n";
            $str .= $prefix."    <li>Press ".
                    "<img src = \"images/icons/refresh.jpg\" width = \"30\" title = \"refresh\" /> ".
                    "if you wanna see the newest comments</li>\n";
            $str .= $prefix."    <li>Support display Emoji face <span class=\"emoji-outer emoji-sizer\"><span class=\"emoji-inner emoji1f36d\"></span></span></li>\n";
            $str .= $prefix."</ol>\n";
            Log::RawEcho($str);
        }

        public function GetNums2Display() {
            return $this->nums_to_display;
        }

        public function GetUser() {
            return $this->user;
        }

        public function GetTableClass() {
            return $this->tableClass;
        }

        public function GetButtonClass() {
            return $this->buttonClass;
        }

        public function GetSubmitClass() {
            return $this->submitClass;
        }

        static function GetNums2DisplayName() {
            return self::$nums_to_displayName;
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

        static public function GetUser2NextPageName() {
            return self::$user2NextPageName;
        }

        static public function GetTableClass2NextPageName() {
            return self::$tableClass2NextPageName;
        }

        static public function GetButtonClass2NextPageName() {
            return self::$buttonClass2NextPageName;
        }

        static public function GetSubmitClass2NextPageName() {
            return self::$submitClass2NextPageName;
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

            //control the length
            if ( 100 <= strlen($msg)) {
                Log::Echo2Web("Commit failed: you input too much words");
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

        private function ButtonDisplay($id1, $id2) {
            $prefix = Fun::NSpaceStr($this->spaceNum);
            //button
            $str  = $prefix."    <div class = \"".$this->buttonClass."\">\n";
            $str .= $prefix."        <table>\n";
            $str .= $prefix."            <tr>\n";

            //first button
            $str .= $prefix."                <td>";
            if ($id2 <= $this->maxIdinTable) {
                $str .= "<img src = \"images/icons/firstpage.jpg\" ".
                        "title = \"first page\" ";
                $str .= "onclick = \"".self::$firstPageButtonFun."()\"";
                $str .= "/>";
            }
            $str .= "</td>\n";

            //previous button
            $str .= $prefix."                <td>";
            if ( $id2 <= $this->maxIdinTable ) {
                $str .= "<img src = \"images/icons/previouspage.jpg\" ".
                        "title = \"previous page\" ";
                $str .= "onclick = \"".self::$previousPageButtonFun."()\"";
                $str .= "/>";
            }
            $str .= "</td>\n";

            //refresh button
            $str .= $prefix."                <td><img src = \"images/icons/refresh.jpg\" ".
                    "title = \"refresh\" ";
            $str .= "onclick = \"".self::$refreshButtonFun."()\"";
            $str .= "/></td>\n";

            //next button
            $str .= $prefix."                <td>";
            if ( $id1 > 1 ) {
                $str .= "<img src = \"images/icons/nextpage.jpg\" ".
                        "title = \"next page\" ";
                $str .= "onclick = \"".self::$nextPageButtonFun."()\"";
                $str .= "/>";
            }
            $str .= "</td>\n";

            //last button
            $str .= $prefix."                <td>";
            if ( $id1 > 1 ) {
                $str .= "<img src = \"images/icons/lastpage.jpg\" ".
                        "title = \"last page\" ";
                $str .= "onclick = \"".self::$lastPageButtonFun."()\"";
                $str .= "/>";
            }
            $str .= "</td>\n";
            $str .= $prefix."            </tr>\n";
            $str .= $prefix."        </table>\n";
            $str .= $prefix."    </div>\n";
            Log::RawEcho($str);
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

            $prefix = Fun::NSpaceStr($this->spaceNum);
            $str  = $prefix."<div id = \"".self::$divId."\" >\n";
            Log::RawEcho($str);

            //button
            $id2 = $this->currentMaxId + 1;
            $id1 = $id2 - $this->nums_to_display;
            $this->ButtonDisplay($id1, $id2);

            //comment table
            $str = $prefix."    <div class = \"".$this->tableClass."\">\n";
            Log::RawEcho($str);

            $service = new DiscussBoardService($this->spaceNum + 8, $this->user, $id1, $id2);
            $service->Run();

            $str = $prefix."    </div>\n";
            Log::RawEcho($str);

            //button
            $this->ButtonDisplay($id1, $id2);

            //submit
            if ( !is_null($this->user) ) {
                $str = $prefix."    <div class = \"".$this->submitClass."\">\n";
                $str .= $prefix."        <h1>Comment</h1>\n";
                $str .= $prefix."        <table>\n";
                $str .= $prefix."            <tr>\n";
                $str .= $prefix."                <td><textarea id = \"".
                        self::$textareaId."\" placeholder = \"".
                                "骚年，为什么不评论一发呢!\" ></textarea></td>\n";
                $str .= $prefix."            </tr>\n";

                $str .= $prefix."            <tr>\n";
                $str .= $prefix."                <td><button type = \"button\" ";
                $str .= "onclick = \"".self::$submitDiscussButtonFun."()\"";
                $str .= ">Submit</button></td>\n";
                $str .= $prefix."            </tr>\n";
                $str .= $prefix."        </table>\n";
                $str .= $prefix."    </div>\n";
            }

            $str .= $prefix."</div>\n";
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
