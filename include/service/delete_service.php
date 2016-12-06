<?php
    include_once "include/service/service.php";
    include_once "include/common/log.php";
    include_once "include/common/file.php";

    //Delete module, need point out which delete button, delete what, and home dir
    class DeleteService implements Service {
        private $deleteButton;
        private $fileName;
        private $homeDir;

        public function __construct($deleteButton, $fileName, $homeDir) {
            $this->deleteButton = $deleteButton;
            $this->fileName     = $fileName;
            $this->homeDir      = File::Trim($homeDir);
        }

        public function Run() {
            if ( isset($_POST[$this->deleteButton]) ) {
                if ( isset($_POST[$this->fileName]) ) {
                    $path = $this->homeDir."/".$_POST[$this->fileName];
                    //Log::Echo2Web($path);
                    if ( false == File::RM($path) ) {
                        Log::Echo2Web("Delete File Failed");
                    }
                } else {
                    Log::Echo2Web("You Should choose a file to delete.");
                }
            }
        }
    }

?>
