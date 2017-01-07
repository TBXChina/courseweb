<?php
    include_once "include/service/service.php";
    include_once "include/common/log.php";
    include_once "include/common/discuss.php";
    include_once "include/common/user.php";

    class DiscussBoardService implements Service {
        private $id1;
        private $id2;

        //display discussions which between [id1, id2) 
        public function __construct($id1, $id2) {
            $this->id1 = $id1;
            $this->id2 = $id2;
        }

        public function Run() {
            $str      = "<table border = 1>\n";
            $discussions = DiscussFactory::Find($this->id1, $this->id2);
            $size = count($discussions);
            for ( $i = ($size - 1); $i >= 0; $i-- ) {
                $d = $discussions[$i];
                $str .= "    <tr>\n";
                $user = UserFactory::Query($d->GetUserId());
                if ( is_null($user) ) {
                    $str .= "        <td>Unknown User</td>\n";
                } else {
                    $str .= "        <td>".$user->GetName()."</td>\n";
                }
                if ( empty($d->GetTime()) ) {
                    $str .= "        <td>Unknown Time</td>\n";
                } else {
                    $str .= "        <td>".date("Y-m-d H:i", $d->GetTime())."</td>\n";
                }
                $str .= "    </tr>\n    <tr>\n";
                $str .= "        <td>".$d->GetMessage()."</td>\n";
                $str .= "    </tr>\n    <tr>\n";
                $str .= "        <td>#".$d->GetId()." floor</td>\n";
                $str .= "    </tr>\n";
            }
            $str     .= "</table>\n";
            Log::RawEcho($str);
        }
    }
?>
