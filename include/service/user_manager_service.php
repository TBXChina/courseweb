<?php
    include_once "include/service/service.php";
    include_once "include/common/log.php";

    class UserManagerService implements Service {
        private $queryButton;
        private $changePWDButton;
        private $importButton;
        private $deleteUserButton;
        private $resetButton;

        private $userID;
        private $userName;
        private $userPWD;
        private $userRole;

        public function __construct($queryButton,
                                    $changePWDButton,
                                    $importButton,
                                    $deleteUserButton,
                                    $resetButton,
                                    $userID,
                                    $userName,
                                    $userPWD,
                                    $userRole) {
            $this->queryButton      = $queryButton;
            $this->changePWDButton  = $changePWDButton;
            $this->importButton     = $importButton;
            $this->deleteUserButton = $deleteUserButton;
            $this->resetButton      = $resetButton;
            $this->userID           = $userID;
            $this->userName         = $userName;
            $this->userPWD          = $userPWD;
            $this->userRole         = $userRole;
        }

        public function Run() {
            //after press query button
            if ( isset($_POST[$this->queryButton]) ) {
                if ( isset($_POST[$this->userID]) &&
                     !empty($_POST[$this->userID]) ) {
                    $user = 
                } else {
                    Log::Echo2Web("Please input student id");
                }

            }

            //after press changePWD button
            if ( isset($_POST[$this->changePWDButton]) ) {

            }

            //after press import button
            if ( isset($_POST[$this->importButton]) ) {

            }

            //after press deleteuser button
            if ( isset($_POST[$this->deleteUserButton]) ) {

            }

            //after press reset button
            if ( isset($_POST[$this->resetButton]) ) {

            }
        }
    }
?>
