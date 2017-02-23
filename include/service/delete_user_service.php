<?php
    include_once "include/configure.php";
    include_once "include/service/service.php";
    include_once "include/common/table_manager.php";
    include_once "include/common/user.php";
    include_once "include/common/file.php";

    class DeleteUserService implements Service {
        private $currentUser; //point out who is using this service now
        private $deleteButton;
        private $userId;

        static private $table_id = "id";

        public function __construct($currentUser, $deleteButton, $userId) {
            $this->currentUser  = $currentUser;
            $this->deleteButton = $deleteButton;
            $this->userId       = $userId;
        }

        public function Run() {
            if ( isset($_POST[$this->deleteButton]) ) {
                if ( isset($_POST[$this->userId]) ) {
                    $id = $_POST[$this->userId];
                    $user = UserFactory::Query($id);
                    if ( is_null($user) ) {
                        Log::Echo2Web("User: ".$id." isn't in our system.");
                        return false;
                    }

                    if ( "root" == $user->GetId() ) {
                        Log::Echo2Web("You can't delete the root Administration.");
                        return false;
                    }

                    if ( $user->GetId() == $this->currentUser->GetId() ) {
                        Log::Echo2Web("You can't delete your self.");
                        return false;
                    }

                    //delete his/her file and account
                    if ( false == File::RM($user->GetStoreDir()) ) {
                        Log::Echo2Web("Delete User's file Error.");
                        return false;
                    }
                    $prop = self::$table_id;
                    $value = $id;
                    //open table
                    $tableManager = TableManagerFactory::Create(Configure::$USERTABLE);
                    $rs = $tableManager->Delete($prop, $value);
                    return $rs;
                } else {
                    Log::Echo2Web("Please input user id.");
                }
            }
        }
    }
?>
