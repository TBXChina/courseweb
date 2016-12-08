<?php
    include_once "include/service/service.php";
    include_once "include/configure.php";
    include_once "include/common/log.php";
    include_once "include/common/web.php";
    include_once "include/common/authentication.php";

    //session module, directly concern with authentication
    class SessionService implements Service {
        private $url;   //url record this sessionService serve which page
        private $user;
        public function __construct($url) {
            $this->url  = $url;
            $this->user = null;
        }

        public function Run() {
            $authentication = new Authentication();
            if ( $authentication->Permission() ) {
                //you have logined, so jump to console page
                if ($this->url != Configure::$CONSOLEPAGE) {
                    Web::Jump2Web(Configure::$CONSOLEPAGE);
                }
                $this->user = $authentication->GetLegalUser();
            } else {
                //if you are not login, jump to the log page
                if ( $this->url != Configure::$LOGINPAGE ) {
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
