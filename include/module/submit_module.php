<?php
    include_once "include/module/module.php";
    include_once "include/common/log.php";
    include_once "include/common/fun.php";

    //submit what you want
    class SubmitModule implements Module {
        private $spaceNum;
        static private $FILENAME = "Submit_FileName";
        static private $UPLOAD   = "Submit_Upload";

        public function __construct($spaceNum) {
            $this->spaceNum = $spaceNum;
        }

        static public function GetFileName() {
            return self::$FILENAME;
        }

        static public function GetUploadButton() {
            return self::$UPLOAD;
        }

        public function Display() {
            $prefix = Fun::NSpaceStr($this->spaceNum);
            $str    = $prefix."<form enctype = \"multipart/form-data\" ".
                      "action = \"".
                      htmlspecialchars($_SERVER["PHP_SELF"]).
                      "\" method = \"post\">\n";
            $str   .= $prefix."    <input type = \"file\" name = \"".
                      self::$FILENAME.
                      "\" required><br>\n";
            $str   .= $prefix."    <input type = \"submit\" name = \"".
                      self::$UPLOAD.
                      "\" value = \"Upload\">\n";
            $str   .= $prefix."</form>";
            Log::Echo2Web($str);
        }
    }
?>
