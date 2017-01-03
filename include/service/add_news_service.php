<?php
    include_once "include/service/service.php";
    include_once "include/configure.php";
    include_once "include/common/log.php";
    include_once "include/common/table_manager.php";

    //add news to NewsTable
    class AddNewsService implements Service {
        private $addButton;
        private $newsText;

        static private $NEWSTABLE_ID   = "id";
        static private $NEWSTABLE_MSG  ="message";
        static private $NEWSTABLE_TIME = "time";

        public function __construct($addButton, $newsText) {
            $this->addButton = $addButton;
            $this->newsText  = $newsText;
        }

        public function Run() {
            if ( isset($_POST[$this->addButton]) ) {
                if ( !isset($_POST[$this->newsText]) ||
                      empty($_POST[$this->newsText]) ) {
                    Log::Echo2Web("Empty News");
                }

                //insert into news table
                $tableManager = TableManagerFactory::Create(Configure::$NEWSTABLE);
                $rows = $tableManager->TableRows();
                $id = $rows + 1;
                $msg = Fun::ProcessStr($_POST[$this->newsText]);
                Log::Echo2Web($msg);
                $time = date("Y-m-d");
                $propArray = Array(self::$NEWSTABLE_ID,
                                   self::$NEWSTABLE_TIME,
                                   self::$NEWSTABLE_MSG);
                $valueArray = Array($id, $msg, $time);
                return $tableManager->Insert($propArray, $valueArray);
            }
            return null;
        }
    }
?>
