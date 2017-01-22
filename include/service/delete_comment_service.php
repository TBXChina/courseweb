<?php
    include_once "include/configure.php";
    include_once "include/service/service.php";
    include_once "include/common/table_manager.php";
    include_once "include/common/discuss.php";

    class DeleteCommentService implements Service {
        private $deleteButton;
        private $commentId;

        public function __construct($deleteButton, $commentId) {
            $this->deleteButton = $deleteButton;
            $this->commentId    = $commentId;
}

        public function Run() {
            if ( isset($_POST[$this->deleteButton]) ) {
                if ( isset($_POST[$this->commentId]) &&
                     !empty($_POST[$this->commentId]) ) {
                    $commentId = $_POST[$this->commentId];
                    $discuss = DiscussFactory::Query($commentId);
                    if ( !is_null($discuss) ) {
                        $discuss->SetState(Discuss::$STATE_INVALID);
                        $discuss->Update2Table(Configure::$DISCUSSTABLE);
                        return true;
                    } else {
                        Log::Echo2Web("Comment: ".$commentId." isn't in our system.");
                        return false;
                    }
                } else {
                    Log::Echo2Web("Please input comment id.");
                }
            }
        }
    }
?>
