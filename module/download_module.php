<?php
    include_once "module.php";
    include_once "include/log.php";
    include_once "include/file.php";

    //Download module, need point out which download button, download what, and home dir
    class DownloadModule implements Module {
        private $downloadButton;
        private $fileName;
        private $homeDir;

        public function __construct($downloadButton, $fileName, $homeDir) {
            $this->downloadButton = $downloadButton;
            $this->fileName       = $fileName;
            $this->homeDir        = File::Trim($homeDir);
        }

        public function Display() {
            if ( isset($_POST[$this->downloadButton]) ) {
                if ( isset($_POST[$this->fileName]) ) {
                    $path = $this->homeDir."/".$_POST[$this->fileName];
                    if ( false == File::Download($path) ) {
                        Log::Echo2Web("Download File Failed");
                    }
                } else {
                    Log::Echo2Web("You should choose a file to download");
                }
            }
        }
    }
?>
