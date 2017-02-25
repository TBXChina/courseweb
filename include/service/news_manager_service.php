<?php
    include_once "include/service/service.php";
    include_once "include/configure.php";
    include_once "include/common/fun.php";
    include_once "include/common/log.php";
    include_once "include/common/table_manager.php";

    //add news to NewsTable
    class NewsManagerService implements Service {
        private $addButton;
        private $newsText;
        private $deleteButton;
        private $newsId;

        static private $NEWSTABLE_ID   = "id";
        static private $NEWSTABLE_MSG  ="message";
        static private $NEWSTABLE_TIME = "time";

        public function __construct($addButton, $newsText,
                                    $deleteButton, $newsId) {
            $this->addButton    = $addButton;
            $this->newsText     = $newsText;
            $this->deleteButton = $deleteButton;
            $this->newsId       = $newsId;
        }

        public function Run() {
            //add news
            if ( isset($_POST[$this->addButton]) ) {
                if ( !isset($_POST[$this->newsText]) ||
                      empty($_POST[$this->newsText]) ) {
                    Log::Echo2Web("Empty News");
                    return false;
                }

                //insert into news table
                $tableManager = TableManagerFactory::Create(Configure::$NEWSTABLE);
                $sqlstr = "select max(id) from ".Configure::$NEWSTABLE;
                $rs = $tableManager->Execute($sqlstr);
                $maxId = $rs[0]["max(id)"];
                if ( is_null($maxId) ) {
                    $maxId = 0;
                }
                $id = $maxId + 1;
                $msg = Fun::ProcessStr($_POST[$this->newsText]);
                $time = date("Y-m-d");
                $propArray = Array(self::$NEWSTABLE_ID,
                                   self::$NEWSTABLE_TIME,
                                   self::$NEWSTABLE_MSG);
                $valueArray = Array($id, $time, $msg);
                return $tableManager->Insert($propArray, $valueArray);
            }
            //delete news
            if ( isset($_POST[$this->deleteButton]) ) {
                if ( !isset($_POST[$this->newsId]) ||
                     empty($_POST[$this->newsId]) ) {
                    Log::Echo2Web("must select one news");
                    return false;
                }
                $id = $_POST[$this->newsId];
                $prop = self::$NEWSTABLE_ID;
                $value = $id;
                //delete news in table
                $tableManager = TableManagerFactory::Create(Configure::$NEWSTABLE);
                return $tableManager->Delete($prop, $value);
            }
            return null;
        }
    }
?>
