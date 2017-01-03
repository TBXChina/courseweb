<?php
    include_once "include/configure.php";
    include_once "include/service/service.php";
    include_once "include/common/table_manager.php";
    include_once "include/common/user.php";

    class ChangeUserInfoService implements Service {
        private $resetPasswordButton;
        private $changeNameButton;
        private $userId;
        private $userName;

        static private $table_id   = "id";
        static private $table_name = "name";
        static private $table_pwd  = "password";

        public function __construct($resetPasswordButton,
                                    $changeNameButton,
                                    $userId, $userName) {
            $this->resetPasswordButton = $resetPasswordButton;
            $this->changeNameButton    = $changeNameButton;
            $this->userId              = $userId;
            $this->userName            = $userName;
        }

        public function Run() {
            //reset password
            if ( isset($_POST[$this->resetPasswordButton]) ) {
                if ( !isset($_POST[$this->userId])  ||
                     empty($_POST[$this->userId]) ) {
                    Log::Echo2Web("<b>*Please input user id.</b>");
                    return false;
                }
                $id = $_POST[$this->userId];
                $user = UserFactory::Query($id);
                if ( !is_null($user) ) {
                    $newPWD = Fun::ProcessPassword($id);
                    $prop4location = self::$table_id;
                    $value         = $id;
                    $prop4modify    = self::$table_pwd;
                    $newValue      = $newPWD;
                    //open table
                    $tableManager = TableManagerFactory::Create(Configure::$USERTABLE);
                    $rs = $tableManager->Update($prop4location, $value, $prop4modify, $newValue);
                    return $rs;
                } else {
                    Log::Echo2Web("<b>*User: ".$id." isn't in our system.</b>");
                    return false;
                }
            }

            //change user name
            if ( isset($_POST[$this->changeNameButton]) ) {
                if ( !isset($_POST[$this->userId])    ||
                     !isset($_POST[$this->userName])  ||
                     empty($_POST[$this->userId])     ||
                     empty($_POST[$this->userName]) ) {
                    Log::Echo2Web("<b>*Please input user id and new name.</b>");
                    return false;
                }
                $id = Fun::ProcessUserId($_POST[$this->userId]);
                $user = UserFactory::Query($id);
                if ( !is_null($user) ) {
                    $newName = $_POST[$this->userName];
                    $prop4location = self::$table_id;
                    $value         = $id;
                    $prop4modify   = self::$table_name;
                    $newValue      = $newName;
                    //open table
                    $tableManager = TableManagerFactory::Create(Configure::$USERTABLE);
                    $rs = $tableManager->Update($prop4location, $value, $prop4modify, $newValue);
                    return $rs;
                } else {
                    Log::Echo2Web("<b>*User: ".$id." isn't in our system.</b>");
                    return false;
                }
            }
        }
    }
?>
