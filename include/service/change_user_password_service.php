<?php
    include_once "include/configure.php";
    include_once "include/service/service.php";
    include_once "include/common/table_manager.php";
    include_once "include/common/user.php";

    class ChangeUserPasswordService implements Service {
        private $changePWDButton;
        private $userId;
        private $userPWD;

        static private $table_id  = "id";
        static private $table_pwd = "password";

        public function __construct($changePWDButton, $userId, $userPWD) {
            $this->changePWDButton = $changePWDButton;
            $this->userId          = $userId;
            $this->userPWD         = $userPWD;
        }

        public function Run() {
            if ( isset($_POST[$this->changePWDButton]) ) {
                if ( !isset($_POST[$this->userId])  ||
                     !isset($_POST[$this->userPWD]) ||
                     empty($_POST[$this->userId])   ||
                     empty($_POST[$this->userPWD]) ) {
                    Log::Echo2Web("Please input user id and new password.");
                    return;
                }
                $id = $_POST[$this->userId];
                $user = UserFactory::Query($id);
                if ( !is_null($user) ) {
                    $newPWD = Fun::ProcessPassword($_POST[$this->userPWD]);
                    $prop4location = self::$table_id;
                    $value         = $id;
                    $prop4modify    = self::$table_pwd;
                    $newValue      = $newPWD;
                    //open table
                    $tableManager = TableManagerFactory::Create(Configure::$USERTABLE);
                    $rs = $tableManager->Update($prop4location, $value, $prop4modify, $newValue);
                    return $rs;
                } else {
                    Log::Echo2Web("User: ".$id." isn't in our system.");
                }
            }
        }
    }
?>
