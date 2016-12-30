<?php
    include_once "include/service/service.php";
    include_once "include/common/log.php";
    include_once "include/common/user.php";
    include_once "include/common/initialization.php";

    class ResetSystemService implements Service {
        private $resetButton;
        private $user;

        public function __construct($resetButton, $user) {
            $this->resetButton = $resetButton;
            $this->user        = $user;
        }

        public function Run() {
            if ( isset($_POST[$this->resetButton]) ) {
                $NEED_CHECK_USER = true;
                $init = new Initialization($this->user, $NEED_CHECK_USER);
                $init->Run();
            }
        }
    }
?>
