<?php
    include_once "include/service/service.php";
    include_once "include/common/user.php";
    include_once "include/common/log.php";
    include_once "include/common/fun.php";
    include_once "include/common/web.php";

    class QueryHomeworkService implements Service {
        private $spaceNum;
        private $queryButton;
        private $userId;

        static private $DOWNLOAD = "QueryHomework_Download";
        static private $DELETE   = "QueryHomework_Delete";
        static private $FILENAME = "QueryHomework_FileName";
        static private $STODEDIR = "QueryHomework_StoreDir";

        public function __construct($spaceNum, $queryButton, $userId) {
            $this->spaceNum      = $spaceNum;
            $this->queryButton   = $queryButton;
            $this->userId        = $userId;
        }

        static public function GetDownloadButton() {
            return self::$DOWNLOAD;
        }

        static public function GetDeleteButton() {
            return self::$DELETE;
        }

        static public function GetFileName() {
            return self::$FILENAME;
        }

        static public function GetStoreDir() {
            return self::$STODEDIR;
        }

        public function Run() {
            if ( isset($_POST[$this->queryButton]) ) {
                if ( isset($_POST[$this->userId]) &&
                     !empty($_POST[$this->userId]) ) {
                    $id = $_POST[$this->userId];
                    $user = UserFactory::Query($id);
                    if ( !is_null($user) &&
                          Student::GetRole() == $user->GetRole()) {
                        $RETURN_VALUE_CONTAINT_SUBDIR = false;
                        $files = File::LS($user->GetStoreDir());
                        if ( 0 == count($files) ) {
                            Log::Echo2Web($user->GetName()." (".$user->GetId().
                                          ") haven't submit any homework");
                            return;
                        }
                        //display student homework form
                        $prefix = Fun::NSpaceStr($this->spaceNum);
                        $str      = $prefix."<h3>".$user->GetName()." (".$user->GetId().
                                    ") have submitted homework:</h3>\n";
                        $str     .= $prefix."<form action = \"".
                                    Web::GetCurrentPage()."\" method = \"post\">\n";
                        $str     .= $prefix."    <ul>\n";
                        foreach ($files as $f) {
                            $str .= $prefix."        <li>\n";
                            $str .= $prefix."            <input type = \"radio\" name = \"".
                                    self::$FILENAME."\" value = \"".
                                    $f."\" required>".$f."\n";
                            $str .= $prefix."        </li>\n";
                        }
                        $str     .= $prefix."    </ul>\n";
                        $str     .= $prefix."    <input type = \"submit\" name = \"".
                                    self::$DOWNLOAD."\" value = \"Download\">\n";
                        $str     .= $prefix."    <input type = \"submit\" name = \"".
                                    self::$DELETE."\" value = \"Delete\">\n";
                        $str     .= $prefix."</form>\n";
                        Log::RawEcho($str);

                        //register the user's store dir for the next page
                        $info2NextPage = new Info2NextPage();
                        $info2NextPage->SetInfo(self::$STODEDIR, $user->GetStoreDir());
                    } else {
                        Log::Echo2Web("null");
                    }
                } else {
                    Log::Echo2Web("Require User ID.");
                }
            }
        }
    }
?>
