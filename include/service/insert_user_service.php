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
                $id = Fun::ProcessUserId($_POST[$this->userId]);
                if ( !is_null(UserFactory::Query($id)) ) {
                    Log::Echo2Web("Error! User: ".$id." is already in our system.<br>\n");
                    return false;
                }
                $role = $_POST[$this->userRole];
                $user = UserFactory::Create($role, $id);
                $user->SetName($_POST[$this->userName]);
                $user->SetPassword(Fun::ProcessPassword($_POST[$this->userPWD]));
                $user->SetLastAccessTime("");
                $rs = $user->Insert2Table(Configure::$USERTABLE);
                return $rs;
            }
        }
    }
?>
