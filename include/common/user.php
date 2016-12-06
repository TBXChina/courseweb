<?php
    class User {
        //unique, to identity each user
        protected $id;
        protected $name;
        protected $pwd;

        static public function GetRole() {
            return "Guest";
        }

        public function __construct($id) {
            $this->id   = $id;
            $this->name = "Anonymity";
            $this->pwd  = "";
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
    }

    class Admin extends User {
        static public function GetRole() {
            return "admin";
        }

        public function __construct($id) {
            parent::__construct($id);
        }
    }

    class Student extends User {
        static public function GetRole() {
            return "student";
        }

        public function __construct($id) {
            parent::__construct($id);
        }
    }

    class UserFactory {
        static public function Create($role, $id) {
            $user = null;
            switch ($role) {
                case Admin::GetRole():
                    $user = new Admin($id);
                    break;
                case Student::GetRole():
                    $user = new Student($id);
                    break;
                default:
                    $user = new User($id);
            }
            return $user;
        }
    }
?>
