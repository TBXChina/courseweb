<?php
    include_once "module.php";
    include_once "include/log.php";
    include_once "include/file.php";

    //Delete module, need point out which delete button, delete what, and home dir
    class DeleteModule implements Module {
        private $deleteButton;
        private $fileName;
        private $homeDir;

        public function __construct($deleteButton, $fileName, $homeDir) {
            $this->deleteButton = $deleteButton;
            $this->fileName     = $fileName;
            $this->homeDir      = File::Trim($homeDir);
        }

        public function Display() {
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
