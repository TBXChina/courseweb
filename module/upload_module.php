<?php
    include_once "module.php";
    include_once "include/log.php";
    include_once "include/file.php";

    //upload module, need point out which upload button, upload what, and save where
    class UploadModule implements Module {
        private $uploadButton;
        private $fileName;
        private $saveDir;

        public function __construct($uploadButton, $fileName, $saveDir) {
            $this->uploadButton = $uploadButton;
            $this->fileName     = $fileName;
            $this->saveDir      = File::Trim($saveDir);
        }

        public function Display() {
            if ( isset($_POST[$this->uploadButton]) ) {
                if ( isset($_FILES[$this->fileName]) ) {
                    if ( false == File::UploadFile($this->fileName,
                                                   $this->saveDir) ) {
                        Log::Echo2Web("Upload Failed");
                    }
                } else {
                    Log::Echo2Web("You Should choose a file to upload");
                }
            }
        }
    }
?>
