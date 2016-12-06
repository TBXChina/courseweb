<?php
    include_once "include/service/service.php";
    include_once "include/common/log.php";
    include_once "include/common/file.php";

    //Download module, need point out which download button, download what, and home dir
    class DownloadService implements Service {
        private $downloadButton;
        private $fileName;
        private $homeDir;

        public function __construct($downloadButton, $fileName, $homeDir) {
            $this->downloadButton = $downloadButton;
            $this->fileName       = $fileName;
            $this->homeDir        = File::Trim($homeDir);
        }

        public function Run() {
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
