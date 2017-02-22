<?php
    include_once "include/service/service.php";
    include_once "include/service/upload_service.php";
    include_once "include/common/assignment.php";
    include_once "include/common/log.php";
    include_once "include/configure.php";

    class DistributeService implements Service {
        private $user_id;
        private $assignmentNo;
        private $uploadService;

        private $uploadButton;
        private $fileName;
        private $saveDir;
        private $saveFileName;

        public function __construct($user_id, $uploadButton,
                                    $fileName, $saveFileName, $saveDir) {
            $this->user_id       = $user_id;
            if ( isset($_POST[$saveFileName]) ) {
                $this->assignmentNo = $_POST[$saveFileName];
            } else {
                $this->assignmentNo = null;
            }

            $this->uploadButton = $uploadButton;
            $this->fileName     = $fileName;
            $this->saveFileName = $saveFileName;
            $this->saveDir      = $saveDir;
        }

        public function Run() {
            if ( isset($_POST[$this->uploadButton]) ) {
                $assignment = AssignmentFactory::Query($this->assignmentNo);
                if ( !is_null($assignment) ) {
                    Log::Echo2Web("Assignment ".$this->assignmentNo.
                                  " has already been distributed, ".
                                  "you may delete the older one ahead");
                    return false;
                }

                //create new assignment, and upload the file
                $assignment = AssignmentFactory::Create($this->assignmentNo);
                $assignment->SetUserId($this->user_id);
                $assignment->SetTime(time());

                //rename the savefile name
                if ( isset($_POST[$this->saveFileName]) ) {
                    $_POST[$this->saveFileName] = $assignment->GetName();
                }
                //find the document type
                if ( isset($_FILES[$this->fileName]) ) {
                    $name = $_FILES[$this->fileName]["name"];
                    $pos = strrpos($name, ".");
                    if ( !(is_bool($pos) && false == $pos) ) {
                        $document_type = substr($name, $pos + 1);
                        $assignment->SetDocumentType($document_type);
                    }
                }

                $uploadService = new UploadService($this->uploadButton,
                                                   $this->fileName,
                                                   $this->saveFileName,
                                                   $this->saveDir);
                $rs = $uploadService->Run();
                if ( false == $rs ) {
                    return false;
                }
                $rs = $assignment->Insert2Table(Configure::$ASSIGNMENTTABLE);
                if ( false == $rs ) {
                    Log::Echo2Web("Assignment into table failed.");
                    return false;
                }
                return true;
            }
            return null;
        }
    }
?>
