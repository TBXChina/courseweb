<?php
    include_once "include/service/service.php";
    include_once "include/configure.php";
    include_once "include/common/log.php";
    include_once "include/common/fun.php";
    include_once "include/common/table_manager.php";
    include_once "include/common/user.php";
    include_once "include/common/web.php";
    include_once "include/common/authentication.php";
    include_once "include/common/easter_egg.php";

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
                $id = Fun::ProcessUserId($_POST[$this->userid]);
                $pwd  = Fun::ProcessPassword($_POST[$this->password]);

                //put a Easter egg here
                if ( 0 == strcmp("easteregg", $id) ||
                     0 == strcmp("caidan", $id) ) {
                    $easterEgg = new EasterEgg();
                    $easterEgg->Display();
                    return;
                }

                $user = UserFactory::Query($id);
                if ( !is_null($user) &&
                      User::GetRole() != $user->GetRole() &&
                      $pwd == $user->GetPassword() ) {
                    //set the access_time
                    $last_access_time = time();
                    $user->SetLastAccessTime($last_access_time);
                    $user->Update2Table(Configure::$USERTABLE);
                    //register the legal user
                    $au = new Authentication();
                    $au->SetLegalUser($user);
                    //jump to the correspond console page
                    $jump2url = $user->GetHomepage();
                    Web::Jump2Web($jump2url);
                } else {
                    Log::Echo2Web("Login failed.<br>");
                }
            }
        }
    }
?>
