<?php
    //base class
    class User {
        private $id;
        private $name;
        private $pwd; //password
        private $level; //authority, admin has the highest level score

        //id is the primary key
        public function __construct($id) {
            $this->id       = $id;
            $this->name     = '';
            $this->pwd      = '';
            $this->level    = 0;
        }

        public function SetId($id) {
            $this->id = $id;
        }
        public function GetId() {
            return $this->id;
        }

        public function SetName($name) {
            $this->name = $name;
        }
        public function GetName() {
            return $this->name;
        }

        public function SetPwd($pwd) {
            $this->pwd = $pwd;
        }
        public function GetPwd() {
            return $this->pwd;
        }

        public function SetLevel($level) {
            $this->level = $level;
        }
        public function GetLevel() {
            return $this->level;
        }
    }
?>
