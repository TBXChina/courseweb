<?php
    class Log {
        static private $switch = true;

        static public function DebugEcho($msg) {
            if ( true == Log::$switch ) {
                echo $msg."<br>\n";
            }
        }

        static public function Echo2Web($msg) {
            echo $msg."<br>\n";
        }
    }
?>
