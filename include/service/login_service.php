<?php
    include_once "include/service/service.php";
    include_once "include/configure.php";
    include_once "include/common/log.php";
    include_once "include/common/fun.php";
    include_once "include/common/table_manager.php";
    include_once "include/common/user.php";
    include_once "include/common/web.php";
    include_once "include/common/authentication.php";

    //login service and decide the identity
    class LoginService implements Service {
        private $loginButton;
        private $userid;
        private $password;

        public function __construct($loginButton, $userid, $password) {
            $this->loginButton = $loginButton;
            $this->userid    = $userid;
            $this->password    = $password;
        }

        public function Run() {
            if ( isset($_POST[$this->loginButton]) ) {
                if ( !isset($_POST[$this->userid]) ) {
                    Log::Echo2Web("Please input your user ID");
                }
                if ( !isset($_POST[$this->password]) ) {
                    Log::Echo2Web("Please input your password");
                }
                $id = Fun::ProcessUsername($_POST[$this->userid]);
                $pwd  = Fun::ProcessPassword($_POST[$this->password]);

                $user = UserFactory::Query($id);
                if ( !is_null($user) &&
                      $pwd == $user->GetPassword() ) {
                    //register the legal user
                    $au = new Authentication();
                    $au->SetLegalUser($user);
                    //jump to the correspond console page
                    $jump2url = $user->GetHomepage();
                    Web::Jump2Web($jump2url);
                } else {
                    Log::Echo2Web("Login failed");
                }
                /*
                //query user table
                $tableManager = TableManagerFactory::Create(Configure::$USERTABLE);
                $propArray  = Array("id", "password");
                $valueArray = Array($id, $pwd);
                $rs = $tableManager->Query($propArray, $valueArray);
                if ( !empty($rs) && 1 == count($rs) ) {
                    $user = UserFactory::Create($rs[0]["role"], $rs[0]["id"]);
                    $user->SetName($rs[0]["name"]);
                    $user->SetPassword($rs[0]["password"]);
                    //register the legal user
                    $au = new Authentication();
                    $au->SetLegalUser($user);
                    //jump to the correspond console page
                    $jump2url = $user->GetHomepage();
                    Web::Jump2Web($jump2url);
                } else {
                    Log::Echo2Web("Login failed");
                }
                */
            }
        }
    }
?>
