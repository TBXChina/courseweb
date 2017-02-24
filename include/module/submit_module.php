<?php
    include_once "include/module/module.php";
    include_once "include/common/log.php";
    include_once "include/common/fun.php";
    include_once "include/common/user.php";
    include_once "include/common/web.php";
    include_once "include/common/homework.php";
    include_once "include/common/assignment.php";

    //submit what you want
    class SubmitModule implements Module {
        private $spaceNum;
        private $assignDir;
        private $user;
        static private $FILENAME     = "Submit_FileName";
        static private $UPLOAD       = "Submit_Upload";
        static private $SAVEFILENAME = "Submit_Select";

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
            return self::$SAVEFILENAME;
        }

        public function Display() {
            $prefix = Fun::NSpaceStr($this->spaceNum);
            $maxNo = AssignmentFactory::QueryMaxNo();
            if ( is_null($maxNo) ) {
                $maxNo = -1;
            }
            $assignments = AssignmentFactory::Find(0, $maxNo + 1);
            if ( is_null($assignments) || empty($assignments) ) {
                Log::Echo2Web($prefix."<p>You can't submit your homework because no assignment available.</p>");
                return;
            }

            $str      = $prefix."<form enctype = \"multipart/form-data\" action = \"".
                        Web::GetCurrentPage().
                        "\" method = \"post\">\n";
            $str      .= $prefix."    <p>Choose No.</p>\n";
            $with_document_type = false;
            foreach ( $assignments as $a ) {
                $homework = new Homework($this->user->GetId(), $a->GetNo());
                $str .= $prefix."    <input type = \"radio\" name = \"".
                        self::$SAVEFILENAME."\" value = \"".
                        $homework->GetHomeworkName($with_document_type).
                        "\" required>".$a->GetNo()."\n";
            }
            $str     .= $prefix."    <p>Assignment to submit.</p><br>\n";
            $str     .= $prefix."    <input type = \"file\" name = \"".
                        self::$FILENAME."\" required><br>\n";
            $str     .= $prefix."    <input type = \"submit\" name = \"".
                        self::$UPLOAD."\" value = \"Upload\">\n";
            $str     .= $prefix."</form>\n";
            Log::RawEcho($str);
        }
    }
?>
