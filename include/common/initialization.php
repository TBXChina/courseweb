<?php
    include_once "include/configure.php";
    include_once "include/new_configure.php";
    include_once "include/common/log.php";
    include_once "include/common/user.php";
    include_once "include/common/file.php";
    include_once "include/common/database.php";
    include_once "include/common/fun.php";

    class Initialization {
        private $user;
        private $NEED_CHECK_USER;

        public function __construct($user, $NEED_CHECK_USER = true) {
            $this->user = $user;
            $this->NEED_CHECK_USER = $NEED_CHECK_USER;
        }

        private function SeparatorLine() {
            Log::Echo2Web("----------------------------------------------");
        }

        public function Run() {
            if ( true == $this->NEED_CHECK_USER ) {
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
                Log::Echo2Web("<h3>Authentication  success.</h3>");
            }
            //-------------------------------------------------------------------

            //check out the necessary root dir
            if ( !is_dir(Configure::$STORE_DIR) ) {
                Log::Echo2Web("Root Store Dir: ".
                               Configure::$STORE_DIR.
                              " can't find in the old system");
                return false;
            }
            if ( !is_dir(NewConfigure::$STORE_DIR) ) {
                Log::Echo2Web("Root Store Dir in new system: ".
                               NewConfigure::$STORE_DIR.
                              " Should be created handly, and chmod");
                return false;
            }

            //clear the specified dir
            $this->SeparatorLine();
            Log::Echo2Web("<h3>Clear the specified Dir in old system</h3>");
            Log::EchoByStatus(true == File::RM(Configure::$ADMIN_DIR),
                              "RM Dir: ".Configure::$ADMIN_DIR,
                              "Fail to RM Dir: ".Configure::$ADMIN_DIR);
            Log::EchoByStatus(true == File::RM(Configure::$STUDENT_DIR),
                              "RM Dir: ".Configure::$STUDENT_DIR,
                              "Fail to RM Dir: ".Configure::$STUDENT_DIR);
            Log::EchoByStatus(true == File::RM(Configure::$SHARED_DIR),
                              "RM Dir: ".Configure::$SHARED_DIR,
                              "Fail to RM Dir: ".Configure::$SHARED_DIR);

            //create the necessary dir and file
            $this->SeparatorLine();
            Log::Echo2Web("<h3>Create the necessary Dir in the new System.</h3>");
            //admin
            Log::EchoByStatus(true == File::Mkdir(NewConfigure::$ADMIN_DIR),
                              "Create Dir: ".NewConfigure::$ADMIN_DIR,
                              "fail to create Dir: ".NewConfigure::$ADMIN_DIR);
            //student
            Log::EchoByStatus(true == File::Mkdir(NewConfigure::$STUDENT_DIR),
                              "Create Dir: ".NewConfigure::$STUDENT_DIR,
                              "fail to create Dir: ".NewConfigure::$STUDENT_DIR);
            //shared are
            Log::EchoByStatus(true == File::Mkdir(NewConfigure::$SHARED_DIR),
                              "Create Dir: ".NewConfigure::$SHARED_DIR,
                              "fail to create Dir: ".NewConfigure::$SHARED_DIR);
            //assignment
            Log::EchoByStatus(true == File::Mkdir(NewConfigure::$ASSIGNMENTDIR),
                              "Create Dir: ".NewConfigure::$ASSIGNMENTDIR,
                              "fail to create Dir: ".NewConfigure::$ASSIGNMENTDIR);

            //database drop the older one and create a new
            $this->SeparatorLine();
            //older
            $oldhost = Configure::$DBHOST;
            $olduser = Configure::$DBUSER;
            $oldpwd  = Configure::$DBPWD;
            $oldname = Configure::$DBNAME;  //the database we wanna drop
            $olddbParam = new DBParam($oldhost, $olduser, $oldpwd, $oldname);
            //new
            $newhost = NewConfigure::$DBHOST;
            $newuser = NewConfigure::$DBUSER;
            $newpwd  = NewConfigure::$DBPWD;
            $newname = NewConfigure::$DBNAME; //the database we cannt create
            $newdbParam = new DBParam($newhost, $newuser, $newpwd, $newname);
            Log::Echo2Web("<h3>drop the old database.</h3>");
            Log::EchoByStatus(true == Database::DropDatabase($olddbParam),
                              "drop success",
                              "drop failed");
            Log::Echo2Web("<h3>create the new database</h3>");
            Log::EchoByStatus(true == Database::CreateDatabase($newdbParam),
                              "create success",
                              "create failed");
            //create new table
            $this->SeparatorLine();
            $newDB = new Database($newdbParam);

            //user table
            $newUserTableManager = new TableManager($newDB, NewConfigure::$USERTABLE);
            Log::Echo2Web("<h3>Create user table.</h3>");
            $newTableSql = "id varchar(15) NOT NULL, PRIMARY KEY(id), name varchar(15), password varchar(40), role varchar(10), last_access_time char(20)";
            Log::EchoByStatus(true == $newUserTableManager->CreateNewTable($newTableSql),
                              "create success",
                              "create failed");

            //recent news table
            $newNewsTable = new TableManager($newDB, NewConfigure::$NEWSTABLE);
            Log::Echo2Web("<h3>Create Recent News table.</h3>");
            $newTableSql = "id int NOT NULL, primary key(id), message varchar(200), time varchar(50)";
            Log::EchoByStatus(true == $newNewsTable->CreateNewTable($newTableSql),
                              "create success",
                              "create failed");

            //import the student and admin users list
            $separator = " ";
            $studentUsers = Fun::ImportUser(Student::GetRole(),
                                            NewConfigure::$STUDENTNAMELISTFILE,
                                            $separator);
            $adminUsers   = Fun::ImportUser(Admin::GetRole(),
                                            NewConfigure::$ADMINNAMELISTFILE,
                                            $separator);
            if ( empty($studentUsers) || empty($adminUsers) ) {
                Log::Echo2Web("Import Users Failed");
                exit(0);
            }
            $this->SeparatorLine();
            $propArray = Array("id", "name", "password", "role", "last_access_time");
            $last_access_time = "";
            Log::Echo2Web("<h3>Import Student Name List...</h3>");
            foreach ( $studentUsers as $u) {
                $valueArray = Array($u->GetId(),
                                    $u->GetName(),
                                    $u->GetPassword(),
                                    $u->GetRole(),
                                    $last_access_time);
                if ( true == $newUserTableManager->Insert($propArray, $valueArray) ) {
                    Log::Echo2Web($u->GetName()." (".$u->GetId().")");
                } else {
                    Log::Echo2Web("Error import ".$u->GetName()." (".$u->GetId().")");
                    Log::Echo2Web("Stop here");
                    exit(0);
                }
            }
            Log::Echo2Web("<h3>Import Admin Name List...</h3>");
            foreach ( $adminUsers as $u) {
                $valueArray = Array($u->GetId(),
                                    $u->GetName(),
                                    $u->GetPassword(),
                                    $u->GetRole(),
                                    $last_access_time);
                if ( true == $newUserTableManager->Insert($propArray, $valueArray) ) {
                    Log::Echo2Web($u->GetName()." (".$u->GetId().")");
                } else {
                    Log::Echo2Web("Error import ".$u->GetName()." (".$u->GetId().")");
                    Log::Echo2Web("Stop here");
                    exit(0);
                }
            }

            //Tips
            Log::Echo2Web("<h1>Don't forget to copy the new_configure.php to configure.php</h1>");
        }
    }
?>
