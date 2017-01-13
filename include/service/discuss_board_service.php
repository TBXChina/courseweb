<?php
    include_once "include/service/service.php";
    include_once "include/common/log.php";
    include_once "include/common/discuss.php";
    include_once "include/common/user.php";
    include_once "include/common/fun.php";

    class DiscussBoardService implements Service {
        private $spaceNum;
        private $user;
        private $id1;
        private $id2;

        //display discussions which between [id1, id2) 
        public function __construct($spaceNum, $user, $id1, $id2) {
            $this->spaceNum = $spaceNum;
            $this->user = $user;
            $this->id1   = $id1;
            $this->id2   = $id2;
        }

        public function Run() {
            $prefix = Fun::NSpaceStr($this->spaceNum);
            $str      = $prefix."<table>\n";
            $discussions = DiscussFactory::Find($this->id1, $this->id2);
            $size = count($discussions);
            for ( $i = ($size - 1); $i >= 0; $i-- ) {
                $d = $discussions[$i];
                $str .= $prefix."    <tr>\n";
                //floor and user
                $str .= $prefix."        <td align = \"left\"><p>#".$d->GetId()." ";
                $user = UserFactory::Query($d->GetUserId());
                if ( is_null($user) ) {
                    $str .= "Unknown User</p></td>\n";
                } else {
                    $str .= $user->GetName()."</p></td>\n";
                }
                //time
                $str .= $prefix."        <td align = \"right\">";
                if ( empty($d->GetTime()) ) {
                    $str .= "<p>Unknown Time</p>";
                } else {
                    $str .= "<p>".date("Y-m-d H:i", $d->GetTime())."</p>";
                }
                $str .= "</td>\n";
                $str .= $prefix."    </tr>\n";
                $str .= $prefix."    <tr>\n";
                //message
                $str .= $prefix."        <td colspan = \"2\">";
                if ( ( is_null($this->user) || Admin::GetRole() != $this->user->GetRole() ) &&
                       Discuss::$STATE_VALID != $d->GetState() ) {
                    $str .= "<p>&nbsp;&nbsp;This comment has been deleted.</p>";
                } else {
                    $str .= "<p>&nbsp;&nbsp;".$d->GetMessage()."</p>";
                }
                $str .= "</td>\n";
                $str .= $prefix."    </tr>\n";
                $str .= $prefix."    <tr><th></th></tr>\n";
            }
            $str     .= $prefix."</table>\n";
            Log::RawEcho($str);
        }
    }
?>
