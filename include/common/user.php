<?php
    include_once "include/configure.php";

    class User {
        //unique, to identity each user
        protected $id;
        protected $name;
        protected $password;
        protected $homepage;

        public function __construct($id) {
            $this->id        = $id;
            $this->name      = "Anonymity";
            $this->password  = "";
            $this->homepage  = Configure::$URL;
        }

        static public function GetRole() {
            return "Guest";
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

        public function SetPassword($pwd) {
            $this->password = $pwd;
        }
        public function GetPassword() {
            return $this->password;
        }

        public function GetHomepage() {
            return $this->homepage;
        }
    }

    class Admin extends User {
        static public function GetRole() {
            return "admin";
        }

        public function __construct($id) {
            parent::__construct($id);
            $this->homepage = Configure::$URL."/console.php";
        }
    }

    class Student extends User {
        static public function GetRole() {
            return "student";
        }

        public function __construct($id) {
            parent::__construct($id);
            $this->homepage = Configure::$URL."/console.php";
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
