<?php
    class Homework  {
        private $userId; //point out who submit
        private $assignmentNo; //point out for which assignment
        private $supportType;  //accepted homework type

        public function __construct($id, $no) {
            $this->userId = $id;
            $this->assignmentNo = $no;
            $this->supportType = Array("pdf", "zip");
        }

        public function GetUserId() {
            return $this->userId;
        }

        public function GetAssignmentNo() {
            return $this->assignmentNo;
        }

        public function GetHomeworkName($with_document_type = false) {
            $name = $this->userId."_No_".$this->assignmentNo;
            if ( false == $with_document_type) {
                return $name;
            } else {
                $rs = Array();
                foreach ($this->supportType as $t) {
                    array_push($rs, $name.".".$t);
                }
                return $rs;
            }
        }
    }
?>
