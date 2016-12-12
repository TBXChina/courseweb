<?php
    include_once "include/module/module.php";
    include_once "include/common/log.php";
    include_once "include/common/fun.php";
    include_once "include/common/file.php";
    include_once "include/common/user.php";

    //Show the asssignment
    class AssignmentsModule implements Module {
        private $spaceNum;
        private $assignDir;
        private $user;
        static private $FILENAME = "AssignmentModule_FileName";
        static private $DOWNLOAD = "AssignmentModule_Download";
        static private $DELETE   = "AssignmentModule_Delete";

        public function __construct($spaceNum, $assignDir, $user) {
            $this->spaceNum   = $spaceNum;
            $this->assignDir  = File::Trim($assignDir);
            $this->user       = $user;
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
            $files = File::LS($this->assignDir, $RETURN_VALUE_CONTAIN_SUBDIR);
            if ( 0 == count($files) ) {
                return ;
            }
            $prefix     = Fun::NSpaceStr($this->spaceNum);
            $str        = $prefix."<form action = \"".
                          htmlspecialchars($_SERVER["PHP_SELF"]).
                          "\" method = \"post\">\n";
            $str       .= $prefix."    <ul>\n";
            foreach ( $files as $f ) {
                $str   .= $prefix."        <li>\n";
                $str   .= $prefix."            <input type = \"radio\" name = \"".
                          self::$FILENAME."\" value = \"".
                          $f."\" required>".
                          $f."\n";
                $str   .= $prefix."        </li>\n";
            }
            $str       .= $prefix."    </ul><br>\n";
            $str       .= $prefix."    <input type = \"submit\" name = \"".
                          self::$DOWNLOAD."\" value = \"Download\">\n";
            if ( Admin::GetRole() == $this->user->GetRole() ) {
                $str   .= $prefix."    <input type = \"submit\" name = \"".
                          self::$DELETE."\" value = \"Delete\">\n";
            }
            $str       .= $prefix."</form>\n";
            Log::Echo2Web($str);
        }
    }
?>
