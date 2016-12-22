<?php
    include_once "include/service/service.php";
    include_once "include/common/user.php";
    include_once "include/common/log.php";

    class QueryHomeworkService implements Service {
        private $queryButton;
        private $userId;

        static private $DOWNLOAD = "QueryHomework_Download";
        static private $DELETE   = "QueryHomework_Delete";
        static private $FILENAME = "QueryHomework_FileName";

        public function __construct($queryButton, $userId) {
            $this->queryButton = $queryButton;
            $this->userId      = $userId;
        }

        static public function GetDownloadButton() {
            return self::$DOWNLOAD;
        }

        static public function GetDeleteButton() {
            return self::$DELETE;
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

                        print_r($files);
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
