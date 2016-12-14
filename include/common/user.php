<?php
    include_once "include/configure.php";
    include_once "include/common/file.php";

    class User {
        //unique, to identity each user
        protected $id;
        protected $name;
        protected $password;
        protected $homepage;
        protected $storeDir;

        public function __construct($id) {
            $this->id        = $id;
            $this->name      = "Anonymity";
            $this->password  = "";
            $this->homepage  = Configure::$URL;
            $this->storeDir  = File::Trim(Configure::$SHARED_DIR)."/".$this->id;
            //File::Mkdir($this->storeDir);
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

        public function GetStoreDir() {
            return $this->storeDir;
        }
    }

    class Admin extends User {
        static public function GetRole() {
            return "admin";
        }

        public function __construct($id) {
            parent::__construct($id);
            $this->homepage = Configure::$ADMINCONSOLEPAGE;
            $this->storeDir  = File::Trim(Configure::$ADMIN_DIR)."/".$this->id;
            File::Mkdir($this->storeDir);
        }
    }

    class Student extends User {
        static public function GetRole() {
            return "student";
        }

        public function __construct($id) {
            parent::__construct($id);
            $this->homepage = Configure::$CONSOLEPAGE;
            $this->storeDir  = File::Trim(Configure::$STUDENT_DIR)."/".$this->id;
            File::Mkdir($this->storeDir);
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
