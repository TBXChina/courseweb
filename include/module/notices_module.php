<?php
    include_once "include/module/module.php";
    include_once "include/service/upload_service.php";

    //display some notices
    class NoticesModule implements Module {
        private $spaceNum;

        public function __construct($spaceNum) {
            $this->spaceNum = $spaceNum;
        }

        public function Display() {
            UploadService::EchoUploadLimits($this->spaceNum);
        }
    }
?>
