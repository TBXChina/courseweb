<?php
    include_once "include/module/module.php";
    include_once "include/configure.php";
    include_once "include/common/log.php";
    include_once "include/common/fun.php";
    include_once "include/common/web.php";

    //export the student homework
    class ExportHomeworkModule {
        private $spaceNum;
        private $assignDir;

        static private $EXPORT = "ExportHomework_Export";
        static private $NO     = "ExportHomework_No";

        public function __construct($spaceNum) {
            $this->spaceNum = $spaceNum;
            $this->assignDir = Configure::$ASSIGNMENTDIR;
        }

        static public function GetExportButton() {
            return self::$EXPORT;
        }

        static public function GetHomeworkNo() {
            return self::$NO;
        }

        public function Display() {
            $prefix = Fun::NspaceStr($this->spaceNum);
            $RETURN_VALUE_CONTAIN_SUBDIR = false;
            $files = File::LS($this->assignDir, $RETURN_VALUE_CONTAIN_SUBDIR);
            if ( 0 == count($files) ) {
                Log::Echo2Web($prefix."<p>No Homework to export because you haven't distribute any assignment.</p>");
            }

            $str = $prefix."<form action = \"".
                   Web::GetCurrentPage()."\" method = \"post\">\n";
            $str .= $prefix."    <p>Choose No.</p>\n";
            $size = count($files);
            for ( $i = 1;  $i <= $size ; $i++) {
                $str .= $prefix."    <input type = \"radio\" name = \"".
                        self::$NO."\" value = \"".
                        $i."\" required>$i\n";
            }
            $str .= $prefix."    <p>Homework to export.</p><br>\n";
            $str .= $prefix."    <input type = \"submit\" name = \"".
                    self::$EXPORT."\" value = \"Export\">\n";
            $str .= $prefix."</form>\n";
            Log::RawEcho($str);
        }
    }
?>
