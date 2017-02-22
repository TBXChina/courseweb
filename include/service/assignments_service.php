<?php
    include_once "include/service/service.php";
    include_once "include/service/download_service.php";
    include_once "include/service/delete_service.php";
    include_once "include/common/log.php";
    include_once "include/common/assignment.php";

    class AssignmentsDownloadService implements Service {
        private $assignment_no;
        private $downloadButton;
        private $fileName;
        private $storeDir;

        public function __construct($downloadButton, $fileName, $storeDir) {
            if ( isset($_POST[$fileName]) ) {
                $this->assignment_no = $_POST[$fileName];
            } else {
                $this->assignment_no = null;
            }
            $this->downloadButton = $downloadButton;
            $this->fileName       = $fileName;
            $this->storeDir       = $storeDir;
        }

        public function Run() {
            if ( isset($_POST[$this->downloadButton]) ) {
                if ( is_null($this->assignment_no) )  {
                    Log::Echo2Web("Must Point out Assignment No");
                    return false;
                }
                $assignment = AssignmentFactory::Query($this->assignment_no);
                if ( is_null($assignment) ) {
                    Log::Echo2Web("Error Assignment No");
                    return false;
                }
                $_POST[$this->fileName] = $assignment->GetName().".".$assignment->GetDocumentType();
                $downloadService = new DownloadService($this->downloadButton,
                                                       $this->fileName,
                                                       $this->storeDir);
                $rs = $downloadService->Run();
                return $rs;
            }

            return null;
        }
    }

    class AssignmentsDeleteService implements Service {
        private $assignment_no;
        private $deleteButton;
        private $fileName;
        private $storeDir;

        public function __construct($deleteButton, $fileName, $storeDir) {
            $this->deleteButton = $deleteButton;
            $this->fileName     = $fileName;
            $this->storeDir     = $storeDir;
            if ( isset($_POST[$this->fileName]) ) { 
                $this->assignment_no = $_POST[$this->fileName];
            } else {
                $this->assignment_no = null;
            }
        }

        public function Run() {
            if ( isset($_POST[$this->deleteButton]) ) {
                if ( is_null($this->assignment_no) )  {
                    Log::Echo2Web("Must Point out Assignment No");
                    return false;
                }
                $assignment = AssignmentFactory::Query($this->assignment_no);
                if ( is_null($assignment) ) {
                    Log::Echo2Web("Error Assignment No");
                    return false;
                }
                $_POST[$this->fileName] = $assignment->GetName().".".$assignment->GetDocumentType();

                //delete the record in table
                $rs = AssignmentFactory::Destroy($assignment->GetNo());
                if ( false == $rs ) {
                    return false;
                }
                //delete file
                $deleteService = new DeleteService($this->deleteButton,
                                                   $this->fileName,
                                                   $this->storeDir);
                $rs = $deleteService->Run();
                return $rs;
            }
            return null;
        }
    }

?>
