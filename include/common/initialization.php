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

            //check out the necessary root dir
            if ( !is_dir(Configure::$STORE_DIR) ) {
                Log::Echo2Web("Root Store Dir: ".
                               Configure::$STORE_DIR.
                              " Should be created handly, and chmod");
                return false;
            }

            //clear the specified dir
            File::RM(Configure::$ADMIN_DIR);
            File::RM(Configure::$STUDENT_DIR);
            File::RM(Configure::$SHARED_DIR);

            //create the necessary dir and file
            //admin
            Log::EchoByStatus(true == File::Mkdir(Configure::$ADMIN_DIR),
                                                  "Create Dir: ".Configure::$ADMIN_DIR,
                                                  "fail to create Dir: ".Configure::$ADMIN_DIR);
            //student
            Log::EchoByStatus(true == File::Mkdir(Configure::$STUDENT_DIR),
                                                  "Create Dir: ".Configure::$STUDENT_DIR,
                                                  "fail to create Dir: ".Configure::$STUDENT_DIR);
            //shared are
            Log::EchoByStatus(true == File::Mkdir(Configure::$SHARED_DIR),
                                                  "Create Dir: ".Configure::$SHARED_DIR,
                                                  "fail to create Dir: ".Configure::$SHARED_DIR);
            //assignment
            Log::EchoByStatus(true == File::Mkdir(Configure::$ASSIGNMENTDIR),
                                                  "Create Dir: ".Configure::$ASSIGNMENTDIR,
                                                  "fail to create Dir: ".Configure::$ASSIGNMENTDIR);

            //database drop the older one and create a new
            $host
        }
    }
?>
