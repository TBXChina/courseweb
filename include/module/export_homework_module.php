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
            $maxNo = AssignmentFactory::QueryMaxNo();
            $assignments = AssignmentFactory::Find(0, $maxNo + 1);
            if ( is_null($assignments) || empty($assignments) ) {
                Log::Echo2Web($prefix."<p>No Homework to export because you haven't distribute any assignment.</p>");
                return;
            }

            $str = $prefix."<form action = \"".
                   Web::GetCurrentPage()."\" method = \"post\">\n";
            $str .= $prefix."    <p>Choose No.</p>\n";
            foreach ( $assignments as $a ) {
                $assignment_no = $a->GetNo();
                $str .= $prefix."    <input type = \"radio\" name = \"".
                        self::$NO."\" value = \"".
                        $assignment_no."\" required>$assignment_no\n";
            }
            $str .= $prefix."    <p>Homework to export.</p><br>\n";
            $str .= $prefix."    <input type = \"submit\" name = \"".
                    self::$EXPORT."\" value = \"Export\">\n";
            $str .= $prefix."</form>\n";
            Log::RawEcho($str);
        }
    }
?>
