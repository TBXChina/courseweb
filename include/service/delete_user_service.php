<?php
    include_once "include/configure.php";
    include_once "include/service/service.php";
    include_once "include/common/table_manager.php";
    include_once "include/common/user.php";

    class DeleteUserService implements Service {
        private $deleteButton;
        private $userId;

        static private $table_id = "id";

        public function __construct($deleteButton, $userId) {
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

                    //delete
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
