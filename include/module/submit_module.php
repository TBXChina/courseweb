<?php
    include_once "include/module/module.php";
    include_once "include/common/log.php";
    include_once "include/common/fun.php";
    include_once "include/common/user.php";
    include_once "include/service/upload_service.php";

    //submit what you want
    class SubmitModule implements Module {
        private $spaceNum;
        private $assignDir;
        private $user;
        static private $FILENAME = "Submit_FileName";
        static private $UPLOAD   = "Submit_Upload";
        static private $saveFileName = "Submit_Select";

        public function __construct($spaceNum, $assignDir, $user) {
            $this->spaceNum  = $spaceNum;
            $this->assignDir = File::Trim($assignDir);
            $this->user      = $user;
        }

        static public function GetFileName() {
            return self::$FILENAME;
        }

        static public function GetUploadButton() {
            return self::$UPLOAD;
        }

        static public function GetSaveFileName() {
            return self::$saveFileName;
        }

        public function Display() {
            $prefix = Fun::NSpaceStr($this->spaceNum);
            $RETURN_VALUE_CONTAIN_SUBDIR = false;
            $files = File::LS($this->assignDir, $RETURN_VALUE_CONTAIN_SUBDIR);
            if ( 0 == count($files) ) {
                Log::Echo2Web($prefix."<p>You can't submit your homework because no assignment available.</p>");
                return;
            }

            $str      = $prefix."<form enctype = \"multipart/form-data\" ".
                        "action = \"".
                        htmlspecialchars($_SERVER["PHP_SELF"]).
                        "\" method = \"post\">\n";
            $str      .= $prefix."    <p>Choose No.</p>\n";
            $size = count($files);
            for ( $i = 1; $i <= $size; $i++ ) {
                $str .= $prefix."    <input type = \"radio\" name = \"".
                        self::$saveFileName."\" value = \"".
                        $this->user->GetId()."_No_".$i."\" required>$i\n";
            }
            $str     .= $prefix."    Assignment to submit.<br>\n";
            $str     .= $prefix."    <input type = \"file\" name = \"".
                        self::$FILENAME.
                        "\" required><br>\n";
            $str     .= $prefix."    <input type = \"submit\" name = \"".
                        self::$UPLOAD.
                        "\" value = \"Upload\">\n";
            $str     .= $prefix."</form>";
            Log::Echo2Web($str);
            UploadService::EchoUploadLimits();
        }
    }
?>
