<?php
    /**
     **student may want to discuss with each other,
     **this class reprent one discussion in the discussion board
    **/
    class Discussion {
        private $id; //unique, to identity each other
        private $state;
        private $user_id; //point out who says
        private $time;
        private $message;

        //state list
        static private $STATE_VALID   = "STATE_VALID";
        static private $STATE_INVALID = "STATE_INVALID";

        public function __construct($id, $user_id) {
            $this->id  = $id;
            $this->state = self::$STATE_VALID;
            $this->user_id = "";
            $this->time   = "";
            $this->message = "";
        }
    }
?>
