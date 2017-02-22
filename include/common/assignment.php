<?php
    include_once "include/configure.php";
    include_once "include/common/table_manager.php";

    class Assignment { 
        private $no; //point out which assignment
        private $name;  //save name
        private $user_id; //point out who distributed
        private $document_type;
        private $time;

        public function __construct($no) {
            $this->no            = $no;
            $this->name          = "Assignment_".$no;
            $this->user_id       = "";
            $this->document_type = "unknown";
            $this->time          = "";
        }

        public function GetNo() {
            return $this->no;
        }

        public function GetName() {
            return $this->name;
        }

        public function SetUserId($id) {
            $this->user_id = $id;
        }
        public function GetUserId() {
            return $this->user_id;
        }

        public function SetDocumentType($document_type) {
            $this->document_type = $document_type;
        }
        public function GetDocumentType() {
            return $this->document_type;
        }

        public function SetTime($time) {
            $this->time = $time;
        }
        public function GetTime() {
            return $this->time;
        }

        public function Show() {
            Log::Echo2Web("no: ".$this->no);
            Log::Echo2Web("user_id: ".$this->user_id);
            Log::Echo2Web("time: ".$this->time);
        }

        public function Insert2Table($tableName) {
            $propArray = Array("no", "user_id", "document_type", "time");
            $valueArray = Array($this->no,
                                $this->user_id,
                                $this->document_type,
                                $this->time);
            //open table
            $tableManager = TableManagerFactory::Create($tableName);
            $rs = $tableManager->Insert($propArray, $valueArray);
            return $rs;
        }
    }

    class AssignmentFactory {
        static public function Create($no) {
            return new Assignment($no);
        }

        static public function Query($no) {
            if ( is_null($no) || empty($no) ) {
                return null;
            }
            $tableManager = TableManagerFactory::Create(Configure::$ASSIGNMENTTABLE);
            $propArray = Array("no");
            $valueArray = Array($no);
            $rs = $tableManager->Query($propArray, $valueArray);
            if ( 1 == count($rs) ) {
                $assignment = AssignmentFactory::Create($rs[0]["no"]);
                $assignment->SetUserId($rs[0]["user_id"]);
                $assignment->SetDocumentType($rs[0]["document_type"]);
                $assignment->SetTime($rs[0]["time"]);
                return $assignment;
            } else {
                return null;
            }
        }

        static public function Find($no1, $no2) {
            if ( is_null($no1) || is_null($no2) || !is_int($no1) || !is_int($no2) ) {
                Log::Echo2Web("Assignment No is int.");
                return null;
            }

            if ( $no2 < $no1) {
                $temp = $no2;
                $no2  = $no1;
                $no1  = $temp;
            }
            //query the table, [id1, id2)
            $tableManager = TableManagerFactory::Create(Configure::$ASSIGNMENTTABLE);
            $sqlstr = "select * from ".Configure::$ASSIGNMENTTABLE.
                      " where no >= ".$no1.
                      " and no < ".$no2;
            $rs = $tableManager->Execute($sqlstr);
            $assignments = array();
            foreach ($rs as $r) {
                $a = AssignmentFactory::Create($r["no"]);
                $a->SetUserId($r["user_id"]);
                $a->SetDocumentType($r["document_type"]);
                $a->SetTime($r["time"]);
                array_push($assignments, $a);
            }
            return $assignments;
        }

        static public function Destroy($no) {
            $assignment = AssignmentFactory::Query($no);
            if ( is_null($assignment) ) {
                Log::Echo2Web("Assignment ".$no." isn't in our system");
                return false;
            }
            $tableManager = TableManagerFactory::Create(Configure::$ASSIGNMENTTABLE);
            $prop = "no";
            $value = $no;
            $rs = $tableManager->Delete($prop, $value);
            return $rs;
        }

        static public function QueryMaxNo() {
            $tableManager = TableManagerFactory::Create(Configure::$ASSIGNMENTTABLE);
            $sqlstr = "select max(no) from ".Configure::$ASSIGNMENTTABLE;
            $rs = $tableManager->Execute($sqlstr);
            return $rs[0]["max(no)"];
        }
    }
?>
