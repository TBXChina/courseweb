<?php
    include_once "include/common/file.php";
    include_once "include/common/user.php";
    include_once "include/common/encode.php";

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

        //process the common str
        static public function ProcessStr($str) {
            $str = trim($str);
            $str = stripslashes($str);
            $str = htmlspecialchars($str);
            return $str;
        }

        //process the username
        static public function ProcessUsername($username) {
            $username = trim($username);
            $username = stripslashes($username);
            $username = htmlspecialchars($username);
            $username = strtolower($username);
            return $username;
        }

        //process the password
        static public function ProcessPassword($password) {
            $password = trim($password);
            $password = stripslashes($password);
            $password = htmlspecialchars($password);
            //$password = Encode::Hash($password);
            return $password;
        }

        static public function Byte2MB($size) {
            return sprintf("%.2f", $size / 1024 / 1024);
        }
    }
?>
