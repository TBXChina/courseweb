<?php
    include_once "log.php";
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
                Log::DebugEcho("Error in File::RM: ".
                               "path doesn't exisits.");
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
                Log::DebugEcho("Error in File::Write2File: ".
                               "only support 'w' or 'a' mode");
                return false;
            }
            $path = File::Trim($path);
            $f = fopen($path, $mode) or die ("Error in File::Write2File:
                                              Unable to open");
            fwrite($f, $msg);
            fclose($f);
            return true;
        }

        //upload file, saveName no need to contain postfix, only name is ok
        static public function UploadFile($fileName, $saveDir, $saveName = "/") {
            if ( empty($_FILES[$fileName]) ) {
                Log::DebugEcho("Error in File::UploadFile ".
                               "No file upload.");
                return false;
            }
            $fileinfo = $_FILES[$fileName];
            if ( 0 != $fileinfo["error"] ) {
                if ( 4 == $fileinfo["error"] ) {
                    Log::DebugEcho("Error in File::UploadFile: ".
                                   "You haven't choose any file.");
                } else {
                    Log::DebugEcho("Error in File::UploadFile: ".
                                   "Upload File Failed.");
                }
                return false;
            }
            $saveDir = File::Trim($saveDir);
            if ( !is_dir($saveDir) ) {
                Log::DebugEcho("Error in File::UploadFile ".
                               "save dir doesn't exist.");
                return false;
            }
            if ( 0 == strcmp($saveName, "/") ) {
                $saveName = $fileinfo["name"];
            } else {
                $name = $fileinfo["name"];
                //make sure file postfix, obviously not support like this: XX.tar.gz
                $pos = strrpos($name, ".");
                if ( !(is_bool($pos) && false == $pos) ) {
                    $saveName .= substr($name, $pos);
                }
            }
            $path = $saveDir."/".$saveName;
            if ( is_file($path) ) {
                Log::DebugEcho("Error in File::UploadFile ".
                               "File already Exists.");
                return false;
            }
            //move file to destination
            if ( !move_uploaded_file($fileinfo["tmp_name"], $path) ) {
                Log::DebugEcho("Error in File::UploadFile ".
                               "move file to destination failed.");
                return false;
            }
            return true;
        }

        static public function Download($path) {
            if ( !is_file($path) ) {
                Log::DebugEcho("Error in File::Download: ".
                               "Can't find file.");
                return false;
            }
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="'.basename($path).'"');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($path));
            if ( ob_get_level() ) {
                ob_end_clean();
            }
            readfile($path);
            fclose($path);
            return true;
        }
    }
?>
