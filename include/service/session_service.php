<?php
    include_once "include/service/service.php";
    include_once "include/configure.php";
    include_once "include/common/log.php";
    include_once "include/common/web.php";
    include_once "include/common/user.php";
    include_once "include/common/authentication.php";

    //session module, directly concern with authentication
    class SessionService implements Service {
        private $currentURL;   //url record this sessionService serve which page
        private $user;
        private $authentication;
        public function __construct($url) {
            $this->currentURL  = $url;
            $this->user        = null;
            $this->authentication = new Authentication();
        }

        public function Run() {
            if ( $this->authentication->Permission() ) {
                $this->user = $this->authentication->GetLegalUser();
                //you have logined, so jump to console page
                if ($this->currentURL != $this->user->GetHomepage()) {
                    Web::Jump2Web($this->user->GetHomepage());
                }
            } else {
                //if you are not login, jump to the log page
                if ( $this->currentURL != Configure::$LOGINPAGE ) {
                    Web::Jump2Web(Configure::$LOGINPAGE);
                }
            }
        }

        public function GetLegalUser() {
            if ( is_null($this->user) ) {
                return null;
            } else {
                return $this->user;
            }
        }
    }
?>
