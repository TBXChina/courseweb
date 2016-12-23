<?php
    include_once "include/service/service.php";
    include_once "include/common/log.php";
    include_once "include/common/file.php";

    //Delete module, need point out which delete button, delete what, and home dir
    class DeleteService implements Service {
        private $deleteButton;
        private $fileName;
        private $storeDir;

        public function __construct($deleteButton, $fileName, $storeDir) {
            $this->deleteButton = $deleteButton;
            $this->fileName     = $fileName;
            $this->storeDir      = File::Trim($storeDir);
        }

        public function Run() {
            if ( isset($_POST[$this->deleteButton]) ) {
                if ( isset($_POST[$this->fileName]) ) {
                    $path = $this->storeDir."/".$_POST[$this->fileName];
                    //Log::Echo2Web($path);
                    if ( false == File::RM($path) ) {
                        Log::Echo2Web("Delete File Failed");
                        return false;
                    }
                    return true;
                } else {
                    Log::Echo2Web("You Should choose a file to delete.");
                    return false;
                }
            }
            return null;
        }
    }

?>
