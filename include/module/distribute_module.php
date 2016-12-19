<?php
    include_once "include/module/module.php";
    include_once "include/common/log.php";
    include_once "include/common/fun.php";
    include_once "include/common/web.php";

    //distribute new assignment
    class DistributeModule implements Module {
        private $spaceNum;
        private $assignDir;

        static private $FILENAME = "Distribute_FileName";
        static private $UPLOAD   = "Distribute_Upload";

        static private $SAVEFILENAME = "Distribute_No";

        public function __construct($spaceNum) {
            $this->spaceNum = $spaceNum;
            $this->assignDir = File::Trim(Configure::$ADMIN_DIR)."/Assignment";
            File::Mkdir($this->assignDir);
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

        public function GetAssignDir() {
            return $this->assignDir;
        }

        public function Display() {
            $prefix = Fun::NSpaceStr($this->spaceNum);
            $RETURN_VALUE_CONTAIN_SUBDIR = false;
            $files = File::LS($this->assignDir, $RETURN_VALUE_CONTAIN_SUBDIR);
            $str      = $prefix."<form enctype = \"multipart/form-data\" action = \"".
                        Web::GetCurrentPage().
                        "\" method = \"post\">\n";
            $str     .= $prefix."    <p>This is No.</p>\n";
            $size = count($files);
            for ( $i = 1; $i <= $size; $i++ ) {
                $str .= $prefix."    <input type = \"radio\" name = \"".
                        self::$SAVEFILENAME."\" value = \"《概率论与随机过程》大作业".
                        $i."\" required>$i\n";
            }
            $size++;
            $str     .= $prefix."    <input type = \"radio\" name = \"".
                        self::$SAVEFILENAME."\" value = \"《概率论与随机过程》大作业".
                        $size."\" checked = \"true\" required>$size (New)\n";
            $str     .= $prefix."    <p>assignment to distribute</p>\n";
            $str     .= $prefix."    <input type = \"file\" name = \"".
                        self::$FILENAME."\" required><br>\n";
            $str     .= $prefix."    <input type = \"submit\" name = \"".
                        self::$UPLOAD."\" value = \"Distribute\">\n";
            $str     .= $prefix."</form>\n";
            Log::RawEcho($str);
        }
    }
?>
