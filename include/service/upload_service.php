<?php
    include_once "include/service/service.php";
    include_once "include/common/log.php";
    include_once "include/common/file.php";
    include_once "include/common/fun.php";

    //upload module, need point out which upload button, upload what, and save where
    class UploadService implements Service {
        private $uploadButton;
        private $fileName;
        private $saveDir;
        private $saveFileName;

        public function __construct($uploadButton, $fileName, $saveFileName, $saveDir) {
            $this->uploadButton = $uploadButton;
            $this->fileName     = $fileName;
            $this->saveFileName = $saveFileName;
            $this->saveDir      = File::Trim($saveDir);
        }

        private function UploadLimits() {
            if ( isset($_FILES[$this->fileName]) ) {
                $fileName = $this->fileName;
                return ($_FILES[$fileName]["size"] < Configure::$UPLOAD_FILE_MAX) &&
                       ("application/pdf" == $_FILES[$fileName]["type"] ||
                        "zip" == substr($_FILES[$fileName]["name"], strrpos($_FILES[$fileName]["name"], ".") + 1) ||
                        "pdf" == substr($_FILES[$fileName]["name"], strrpos($_FILES[$fileName]["name"], ".") + 1) );
            } else {
                return false;
            }
        }

        static public function EchoUploadLimits($spaceNum = 0) {
            $prefix = Fun::NSpaceStr($spaceNum);
            $str = $prefix."<b>* Notices:</b>\n".
                   $prefix."<ul>\n".
                   $prefix."    <li>Size < ".
                   Fun::Byte2MB(Configure::$UPLOAD_FILE_MAX)." MB</li>\n".
                   $prefix."    <li>Only support pdf/zip Document Type</li>\n".
                   $prefix."    <li>Uploaded file will be renamed</li>\n".
                   $prefix."</ul>\n";
            Log::Echo2Web($str);
        }

        static public function UploadLimitsStr() {
            $str = "File Limits: Only Size < ".
                   Fun::Byte2MB(Configure::$UPLOAD_FILE_MAX).
                   " MB and Type is pdf/zip can be uploaded.";
            return $str;
        }

        public function Run() {
            if ( isset($_POST[$this->uploadButton]) ) {
                if ( isset($_FILES[$this->fileName]) ) {
                    $saveName = null;
                    if ( isset($_POST[$this->saveFileName]) ) {
                        $saveName = $_POST[$this->saveFileName];
                    }
                    if ( false == $this->UploadLimits() ) {
                        Log::Echo2Web("Violate the upload limits");
                        return false;
                    }
                    if ( false == File::UploadFile($this->fileName,
                                                   $this->saveDir,
                                                   $saveName) ) {
                        Log::Echo2Web("Upload Failed");
                        return false;
                    }
                    return true;
                } else {
                    Log::Echo2Web("You Should choose a file to upload");
                    return false;
                }
            }
            return null;
        }
    }
?>
