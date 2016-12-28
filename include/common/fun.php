<?php
    include_once "include/common/file.php";
    include_once "include/common/user.php";
    include_once "include/common/encode.php";
    include_once "include/common/log.php";

    //some usefull function
    class Fun {
        //name.list format: id/separaotor/name
        static public function ImportUser($role, $namelistFile, $separator) {
            $RETURN_IN_LINES = true;
            $lines = File::ReadFileContent($namelistFile, $RETURN_IN_LINES);
            if ( is_bool($lines) && false == $lines ) {
                Log::Echo2Web("Can't Read file");
                return array();
            }
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
                $u->SetName(Fun::ProcessUsername($name));
                $u->SetPassword(Fun::ProcessPassword($id));
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
            $password = Encode::Hash($password);
            return $password;
        }

        static public function Byte2MB($size) {
            return sprintf("%.2f", $size / 1024 / 1024);
        }
    }

    //this class to store info, and pass to next page
    class PassInfoBetweenPage {
        public function __construct() {
            if ( !session_id() ) {
                session_start();
            }
        }

        public function SetInfo($name, $info) {
            $_SESSION[$name] = $info;
        }

        public function GetInfo($name) {
            if ( isset($_SESSION[$name]) ) {
                $info = $_SESSION[$name];
                return $info;
            } else {
                return null;
            }
        }
    }
?>
