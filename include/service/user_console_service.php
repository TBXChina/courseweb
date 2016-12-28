<?php
    include_once "include/service/service.php";
    include_once "include/configure.php";
    include_once "include/common/log.php";
    include_once "include/common/user.php";
    include_once "include/common/authentication.php";
    include_once "include/common/web.php";
    include_once "include/common/table_manager.php";

    class UserConsoleService implements Service {
        private $signoutButton;
        private $changePWDButton;

        private $newPassword;
        private $user;

        static private $VALIDPASSWORDLEN = 20;
        static private $table_id  = "id";
        static private $table_pwd = "password";

        public function __construct($signoutButton,
                                    $changePWDButton,
                                    $newPassword,
                                    $user) {
            $this->signoutButton   = $signoutButton;
            $this->changePWDButton = $changePWDButton;
            $this->newPassword     = $newPassword;
            $this->user            = $user;
            if ( is_null($this->user) ) {
                Log::Echo2Web("Invalid User.");
                exit(0);
            }
        }

        private function is_valid_password($pwd) {
            if ( empty($pwd) ||
                 strlen($pwd) > self::$VALIDPASSWORDLEN ) {
                Log::Echo2Web("Password Length should less than ".self::$VALIDPASSWORDLEN);
                return false;
            } else {
                return true;
            }
        }

        public function Run() {
            //sign out
            if ( isset($_POST[$this->signoutButton]) ) {
                $authentication = new Authentication();
                $authentication->Destroy();
                //jump to the login page
                Web::Jump2Web(Web::GetLoginPage());
                return;
            }

            //change password
            if ( isset($_POST[$this->changePWDButton]) ) {
                if ( !isset($_POST[$this->newPassword]) ||
                     !$this->is_valid_password($_POST[$this->newPassword])
                   ) {
                    return false;
                }
                $id   = $this->user->GetId();
                $user = UserFactory::Query($id);
                if ( is_null($user) ) {
                    Log::Echo2Web("User: ".$user->GetId()." (".$user->GetName()." )".
                                  " isn't in our system");
                    return false;
                }
                $newPWD = Fun::ProcessPassword($_POST[$this->newPassword]);
                $prop4location = self::$table_id;
                $value         = $id;
                $prop4modify   = self::$table_pwd;
                $newValue      = $newPWD;
                //open table
                $tableManager  = TableManagerFactory::Create(Configure::$USERTABLE);
                $rs = $tableManager->Update($prop4location, $value, $prop4modify, $newValue);
                return $rs;
            }
        }
    }
?>
