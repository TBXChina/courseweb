<?php
    class Log {
        static private $switch = false;

        static public function DebugEcho($msg) {
            if ( true == Log::$switch ) {
                echo $msg."<br>\n";
            }
        }

        static public function Echo2Web($msg) {
            echo $msg."<br>\n";
        }

        static public function RawEcho($msg) {
            echo $msg;
        }
    }
?>
