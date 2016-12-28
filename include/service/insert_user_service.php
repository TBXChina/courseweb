<?php
    include_once "include/configure.php";
    include_once "include/service/service.php";
    include_once "include/common/fun.php";
    include_once "include/common/table_manager.php";
    include_once "include/common/user.php";

    class InsertUserService implements Service {
        private $importButton;
        private $userId;
        private $userName;
        private $userPWD;
        private $userRole;

        static private $table_id               = "id";
        static private $table_name             = "name";
        static private $table_pwd              = "password";
        static private $table_role             = "role";
        static private $table_last_access_time = "last_access_time";

        public function __construct($importButton,
                                    $userId,
                                    $userName,
                                    $userPWD,
                                    $userRole) {
            $this->importButton = $importButton;
            $this->userId       = $userId;
            $this->userName     = $userName;
            $this->userPWD      = $userPWD;
            $this->userRole     = $userRole;
        }

        private function ValidUserVar() {
            if ( isset($_POST[$this->userId])   &&
                 isset($_POST[$this->userName]) &&
                 isset($_POST[$this->userPWD])  &&
                 isset($_POST[$this->userRole]) &&
                !empty($_POST[$this->userId])   &&
                !empty($_POST[$this->userName]) &&
                !empty($_POST[$this->userPWD])  &&
                !empty($_POST[$this->userRole]) &&
                (Student::GetRole() == $_POST[$this->userRole]) ||
                 Admin::GetRole() == $_POST[$this->userRole]) {
                return true;
            } else {
                return false;
            }
        }

        public function Run() {
            if ( isset($_POST[$this->importButton]) ) {
                if (!$this->ValidUserVar()) {
                    Log::Echo2Web("Please input valid user var.");
                    return;
                }

                $id = $_POST[$this->userId];
                $name = Fun::ProcessUsername($_POST[$this->userName]);
                $pwd = Fun::ProcessPassword($_POST[$this->userPWD]);
                $role = $_POST[$this->userRole];
                $last_access_time = "";
                $propArray = Array(self::$table_id,
                                   self::$table_name,
                                   self::$table_pwd,
                                   self::$table_role,
                                   self::$table_last_access_time);
                $valueArray = Array($id,
                                    $name,
                                    $pwd,
                                    $role,
                                    $last_access_time);
                //open table
                $tableManager = TableManagerFactory::Create(Configure::$USERTABLE);
                $rs = $tableManager->Insert($propArray, $valueArray);
                return $rs;
            }
        }
    }
?>
