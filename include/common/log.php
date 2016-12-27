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

        static public function EchoByStatus($status, $trueMsg, $falseMsg) {
            if ( true == $status ) {
                Log::Echo2Web($trueMsg);
            } else {
                Log::Echo2Web($falseMsg);
                exit(0);
            }
        }
    }
?>
