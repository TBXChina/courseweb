<?php
    include_once "include/service/service.php";
    include_once "include/configure.php";
    include_once "include/common/log.php";
    include_once "include/common/web.php";
    include_once "include/common/authentication.php";

    //session module, directly concern with authentication
    class SessionService implements Service {
        private $url;
        public function __construct($url) {
            $this->url = $url;
            Log::Echo2Web($this->url);
        }
        public function Run() {
            $authentication = new Authentication();
            if ( $authentication->Permission() ) {

            } else {
                //if you are not login, jump to the log page
                if ( $this->url != Configure::$URL ) {
                    Web::Jump2Web(Configure::$URL);
                }
            }
        }
    }
?>
