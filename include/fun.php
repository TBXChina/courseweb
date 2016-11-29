<?php
    include_once "file.php";
    include_once "user.php";

    //some usefull function
    class Fun {
        //name.list format: id/separaotor/name
        static public function ImportUser($role, $namelistFile, $separator) {
            $RETURN_IN_LINES = true;
            $lines = File::ReadFile($namelistFile, $RETURN_IN_LINES);
            $users = array();
            foreach( $lines as $l ) {
                $arr = explode($separator, $l);
                $id = trim($arr[0]);
                if ( count($arr) < 2 ) {
                    $name = $id;
                } else {
                    $name = trim($arr[1]);
                }
                $u = UserFactory::Create($role, $id);
                $u->SetName($name);
                array_push($users, $u);
            }
            return $users;
        }

        //this function just for align html tag
        static public function NSpaceStr($num) {
            $str = "";
            for ($i = 0; $i < $num; $i++) {
                $str .= " ";
            }
            return $str;
        }
    }
?>
