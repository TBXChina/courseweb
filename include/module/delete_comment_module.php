<?php
    include_once "include/module/module.php";
    include_once "include/common/log.php";
    include_once "include/common/fun.php";
    include_once "include/common/web.php";

    class DeleteCommentModule implements Module {
        private $spaceNum;

        static private $DELETECOMMENTBUTTON = "DeleteComment_Delete";
        static private $COMMENTID           = "DeleteComment_CommentId";

        public function __construct($spaceNum) {
            $this->spaceNum = $spaceNum;
        }

        static public function GetDeleteCommentButton() {
            return self::$DELETECOMMENTBUTTON;
}

        static public function GetCommentId() {
            return self::$COMMENTID;
        }

        public function Display() {
            $prefix = Fun::NSpaceStr($this->spaceNum);
            //delete comment
            $str  = $prefix."<h3>Delete Comment</h3>\n";
            $str .= $prefix."<form action = \"".
                    Web::GetCurrentPage()."\" method = \"post\">\n";
            $str .= $prefix."    <input type = \"text\" name = \"".
                    self::$COMMENTID."\" placeholder = \"Comment ID\" required>\n";
            $str .= $prefix."    <input type = \"submit\" name = \"".
                    self::$DELETECOMMENTBUTTON."\" value = \"Delete\">\n";
            $str .= $prefix."</form>\n";
            Log::RawEcho($str);
        }
    }
?>
