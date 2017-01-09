<?php
    include_once "include/configure.php";
    include_once "include/common/log.php";
    include_once "include/common/table_manager.php";
    /**
     **student may want to discuss with each other,
     **this class reprent one discussion in the discussion board
    **/
    class Discuss {
        private $id; //unique, to identity each other
        private $state;
        private $user_id; //point out who says
        private $time;
        private $message;

        //state list
        static public $STATE_VALID   = "VALID";
        static public $STATE_INVALID = "INVALID";

        public function __construct($id) {
            $this->id      = $id;
            $this->state   = self::$STATE_INVALID;
            $this->user_id = "";
            $this->time    = "";
            $this->message = "";
        }

        public function GetId() {
            return $this->id;
        }

        public function SetState($state) {
            $this->state = $state;
        }
        public function GetState() {
            return $this->state;
        }

        public function SetUserId($user_id) {
            $this->user_id = $user_id;
        }
        public function GetUserId() {
            return $this->user_id;
        }

        public function SetTime($time) {
            $this->time = $time;
        }
        public function GetTime() {
            return $this->time;
        }

        public function SetMessage($msg) {
            $this->message = $msg;
        }
        public function GetMessage() {
            return $this->message;
        }

        public function Show() {
            Log::Echo2Web("id: ".$this->id);
            Log::Echo2Web("state: ".$this->state);
            Log::Echo2Web("user_id: ".$this->user_id);
            Log::Echo2Web("time: ".$this->time);
            Log::Echo2Web("message: ".$this->message);
        }

        public function Insert2Table($tableName) {
            $propArray = Array("id", "state", "user_id", "time", "message");
            $valueArray = Array($this->id,
                                $this->state,
                                $this->user_id,
                                $this->time,
                                $this->message);
            //open table
            $tableManager = TableManagerFactory::Create($tableName);
            $rs = $tableManager->Insert($propArray, $valueArray);
            return $rs;
        }

        public function Insert2TableManager($tableManager) {
            $propArray = Array("id", "state", "user_id", "time", "message");
            $valueArray = Array($this->id,
                                $this->state,
                                $this->user_id,
                                $this->time,
                                $this->message);
            $rs = $tableManager->Insert($propArray, $valueArray);
            return $rs;
        }
    }

    class DiscussFactory {
        static public function Create($id) {
            return new Discuss($id);
        }

        static public function Query($id) {
            $tableManager = TableManagerFactory::Create(Configure::$DISCUSSTABLE);
            $propArray = Array("id");
            $valueArray = Array($id);
            $rs = $tableManager->Query($propArray, $valueArray);
            if ( 1 == count($rs) ) {
                $discussion = DiscussFactory::Create($rs[0]["id"]);
                $discussion->SetState($rs[0]["state"]);
                $discussion->SetUserId($rs[0]["user_id"]);
                $discussion->SetTime($rs[0]["time"]);
                $discussion->SetMessage($rs[0]["message"]);
                return $discussion;
            } else {
                return null;
            }
        }

        //query discuss, where id1 <= id < id2, or id2 <= id < id1
        static public function Find($id1, $id2) {
            if ( !is_int($id1) || !is_int($id2) ) {
                Log::Echo2Web("Discuss id is int.");
                return null;
            }
            if ( $id2 < $id1 ) {
                $temp = $id2;
                $id2  = $id1;
                $id1  = $temp;
            }
            //query the table, [id1, id2)
            $tableManager = TableManagerFactory::Create(Configure::$DISCUSSTABLE);
            $sqlstr = "select * from ".Configure::$DISCUSSTABLE.
                      " where id >= ".$id1.
                      " and id < ".$id2;
            $rs = $tableManager->Execute($sqlstr);
            $discussions = array();
            foreach ($rs as $r) {
                $d = DiscussFactory::Create($r["id"]);
                $d->SetState($r["state"]);
                $d->SetUserId($r["user_id"]);
                $d->SetTime($r["time"]);
                $d->SetMessage($r["message"]);
                array_push($discussions, $d);
            }
            return $discussions;
        }
    }
?>
