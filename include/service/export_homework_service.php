<?php
    include_once "include/service/service.php";
    include_once "include/configure.php";
    include_once "include/common/log.php";
    include_once "include/common/file.php";
    include_once "include/common/user.php";
    include_once "include/common/homework.php";
    include_once "include/common/table_manager.php";

    //Export Students' homework
    class ExportHomeworkService implements Service {
        private $tempDir;
        private $exportButton;
        private $homeworkNo;

        public function __construct($exportButton, $homeworkNo) {
            $this->tempDir    = File::Trim(Configure::$ADMIN_DIR."/temp4ExportHomework");
            $this->exportButton = $exportButton;
            $this->homeworkNo   = $homeworkNo;
        }

        //delte last temp dir, copy homework to a temp dir in admin dir, then tar, then download
        public function Run() {
            if ( isset($_POST[$this->exportButton]) ) {
                if ( isset($_POST[$this->homeworkNo]) &&
                     is_numeric($_POST[$this->homeworkNo]) ) {
                    $no = $_POST[$this->homeworkNo];
                    //query all student
                    $tableManager = TableManagerFactory::Create(Configure::$USERTABLE);
                    $propArray = Array("role");
                    $valueArray = Array(Student::GetRole());
                    $students = $tableManager->Query($propArray, $valueArray);
                    if ( !empty($students) ) {
                        //delete temp dir
                        File::RM($this->tempDir);

                        //Make new dir
                        File::Mkdir($this->tempDir);
                        $tempNoDir = File::Trim($this->tempDir."/".$no);
                        File::Mkdir($tempNoDir);

                        //copy
                        foreach ( $students as $s) {
                            $user = UserFactory::Create(Student::GetRole(), $s["id"]);
                            $homework = new Homework($user->GetId(), $no);
                            $with_document_type = true;
                            $fileNames = $homework->GetHomeworkName($with_document_type);
                            foreach ($fileNames as $f) {
                                $src = $user->GetStoreDir()."/".$f;
                                $dst = $tempNoDir."/".$f;
                                File::CopyFile($src, $dst);
                            }
                        }

                        //tar
                        $tarFileName = $this->tempDir."/".$no.".tar.bz2";
                        $str = "cd $this->tempDir && tar -jcv -f $tarFileName $no";
                        exec("cd $this->tempDir && tar -jcv -f $tarFileName $no", $retval);

                        //download
                        File::Download($tarFileName);
                    }
                } else {
                    Log::Echo2Web("You should choose a assignment to export");
                }
            }
        }
    }
?>
