<?php
    class User {
        //unique, to identity each user
        protected $id;
        protected $role; //admin, student, or other person
        protected $name;
        protected $pwd;

        public function __construct($id) {
            $this->id   = $id;
            $this->role = "user";
            $this->name = "";
            $this->pwd  = "";
        }

        public function GetId() {
            return $this->id;
        }

        public function GetRole() {
            return $this->role;
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
        public function __construct($id) {
            parent::__construct($id);
            $this->role = "admin";
        }
    }

    class Student extends User {
        public function __construct($id) {
            parent::__construct($id);
            $this->role = "student";
        }
    }

    class UserFactory {
        static public function Create($role, $id) {
            $user = null;
            switch ($role) {
                case "admin":
                    $user = new Admin($id);
                    break;
                case "student":
                    $user = new Student($id);
                    break;
                default:
                    $user = new User($id);
            }
            return $user;
        }
    }
?>
