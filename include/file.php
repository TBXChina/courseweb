<?php
    //wrap file system operation
    class File {
        static public function LS($dir, $RETURN_VALUE_CONTAINT_SUBDIR = false) {
            $dir = trim($dir);
            $dir = rtrim($dir, '/');
            $dir .= '/';
            $content = array();
            if ( is_dir($dir) ) {
                $dire = opendir($dir);
                while ( $file = readdir($dire) ) {
                    if ( '.' == $file || '..' == $file ) {
                        continue;
                    }
                    $path = $dir.$file;
                    if ( false == $RETURN_VALUE_CONTAINT_SUBDIR &&
                         is_dir($path) ) {
                        continue;
                    }
                    array_push($content, $file);
                }
                closedir($dire);
            }
            return $content;
        }
    }

?>
