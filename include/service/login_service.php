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
        private $username;
        private $password;

        public function __construct($loginButton, $username, $password) {
            $this->loginButton = $loginButton;
            $this->username    = $username;
            $this->password    = $password;
        }

        public function Run() {
            if ( isset($_POST[$this->loginButton]) ) {
                if ( !isset($_POST[$this->username]) ) {
                    Log::Echo2Web("Please input your username");
                }
                if ( !isset($_POST[$this->password]) ) {
                    Log::Echo2Web("Please input your password");
                }
                $name = Fun::ProcessUsername($_POST[$this->username]);
                $pwd  = Fun::ProcessPassword($_POST[$this->password]);
                //query user table
                $tableManager = TableManagerFactory::Create(Configure::$USERTABLE);
                $propArray  = Array("id", "password");
                $valueArray = Array($name, $pwd);
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
            }
        }
    }
?>
