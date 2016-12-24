<?php
    include_once "include/configure.php";
    include_once "include/common/table_manager.php";
    include_once "include/common/log.php";
    include_once "include/common/user.php";
    include_once "include/common/file.php";

    class Initialization {
        private $user;

        public function __construct($user) {
            $this->user = $user;
        }

        public function Run() {
            //confirm the authorization
            if ( 0 != strcmp("root", $this->user->GetId()) ) {
                Log::Echo2Web("Authentication  failed.");
                return false;
            }
            $rootUser = UserFactory::Query("root");
            if ( is_null($rootUser) ) {
                Log::Echo2Web("There is no root Admin in our system.");
                return false;
            }
            if ( $this->user->GetPassword() != $rootUser->GetPassword() ) {
                Log::Echo2Web("Authentication  failed.");
                return false;
            }
            Log::Echo2Web("Authentication  success.");

            //clear the specified dir
            File::RM(Configure::$ADMIN_DIR);
            File::RM(Configure::$STUDENT_DIR);
            File::RM(Configure::$SHARED_DIR);
        }
    }
?>
