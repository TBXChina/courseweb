<?php
    include_once "include/module/module.php";
    include_once "include/common/log.php";
    include_once "include/common/fun.php";
    include_once "include/common/file.php";

    //Show Student homework
    class HomeworkListModule implements Module {
        private $spaceNum;
        private $homeDir;
        static private $FILENAME = "HomeworkList_FileName";
        static private $DOWNLOAD = "HomeworkList_Download";
        static private $DELETE   = "HomeworkList_Delete";

        public function __construct($spaceNum, $homeDir) {
            $this->spaceNum = $spaceNum;
            $this->homeDir  = File::Trim($homeDir);
        }

        static public function GetFileName() {
            return self::$FILENAME;
        }

        static public function GetDownloadButton() {
            return self::$DOWNLOAD;
        }

        static public function GetDeleteButton() {
            return self::$DELETE;
        }

        public function Display() {
            $RETURN_VALUE_CONTAIN_SUBDIR = false;
            $files = File::LS($this->homeDir, $RETURN_VALUE_CONTAIN_SUBDIR);
            if ( 0 == count($files) ) {
                return;
            }
            $prefix      = Fun::NSpaceStr($this->spaceNum);
            $str         = $prefix."<form action = \"".
                           htmlspecialchars($_SERVER["PHP_SELF"]).
                           "\" method = \"post\">\n";
            $str        .= $prefix."    <table border = \"1\" border-spacing = \"100\">\n";
            $str        .= $prefix."        <tr>\n";
            $str        .= $prefix."            <td align = \"center\">Name</td>\n";
            $str        .= $prefix."            <td align = \"center\">Upload Time</td>\n";
            $str        .= $prefix."            <td align = \"center\">Size (MB)</td>\n";
            $str        .= $prefix."        </tr>\n";
            foreach ( $files as $f ) {
                $str    .= $prefix."        <tr>\n";
                $str    .= $prefix."            <td><input type = \"radio\" name = \"".
                           self::$FILENAME."\" value = \"".
                           $f."\" required>".
                           $f."</td>\n";
                $str    .= $prefix."            <td>".
                           date("Y-m-d H:i:s", filectime($this->homeDir."/".$f)).
                           "</td>\n";
                $str    .= $prefix."            <td align = \"center\">".
                           Fun::Byte2MB(filesize($this->homeDir."/".$f)).
                           "</td>\n";
                $str    .= $prefix."        </tr>\n";
            }
            $str   .= $prefix."    </table><br>\n";
            $str   .= $prefix."    <input type = \"submit\" name = \"".
                      self::$DOWNLOAD."\" value = \"Download\">\n";
            $str   .= $prefix."    <input type = \"submit\" name = \"".
                      self::$DELETE."\" value = \"Delete\">\n";
            $str   .= $prefix."</form>\n";
            Log::Echo2Web($str);
        }
    }
?>
