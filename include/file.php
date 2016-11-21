<?php
    //wrap file system operation
    class File {
        static private function Trim($path) {
            return rtrim(trim($path), '/');
        }

        static public function LS($dir, $RETURN_VALUE_CONTAINT_SUBDIR = false) {
            $dir = File::Trim($dir);
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
            sort($content);
            return $content;
        }

        //support del a file or a directory
        static public function RM($path) {
            if ( false == file_exists($path) ) {
                echo "Error in File::RM: ".
                     " path doesn't exisits.<br>\n";
                return false;
            }
            $path = File::Trim($path);
            if ( is_dir($path) ) {
                //this is a dir, del itself and its subdir
                $content = File::LS($path, true);
                foreach ($content as $c) {
                    $subpath = $path."/".$c;
                    if ( is_dir($subpath) ) {
                        //recursion call
                        if ( false == File::RM($subpath) ) {
                            return false;
                        }
                    } else {
                        //unlink($subpath);
                        echo $subpath."<br>\n";
                    }
                }
                //delete current dir
                //rmdir($path);
                echo $path."<br>\n";
            } else {
                //this is a file
                //unlink($path);
                echo $path."<br>\n";
            }
            return true;
        }

        //write msg to file, mode is 'w' or 'a'
        static public function Write2File($msg, $path, $mode) {
            if ( 0 != strcasecmp($mode, "a") &&
                 0 != strcasecmp($mode, "w") ) {
                echo "Error in File::Write2File:
                      only support 'w' or 'a' mode";
                return false;
            }
            $path = File::Trim($path);
            $f = fopen($path, $mode) or die ("Error in File::Write2File:
                                              Unable to open");
            fwrite($f, $msg);
            fclose($f);
            return true;
        }
    }
?>
