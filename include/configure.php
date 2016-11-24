<?php
    //configure
    class Configure {
        static public $AUTHOR;

        //course info
        static public $COURSE;
        static public $URL;

        //some important dir
        static public $ROOT_DIR;
        static public $STORE_DIR;
        static public $ADMIN_DIR;
        static public $STUDENT_DIR;
        static public $SHARED_DIR;

        //some important var about database
        static public $DBHOST;
        static public $DBUSER;
        static public $DBPWD;
        static public $DBNAME;
        static public $TABLENAME;

        //constraint
        static public $UPLOAD_FILE_MAX; /*Byte*/
        static public $SESSION_VALID_TIME; /*second*/

        static public function Init() {
            self::$AUTHOR = "Brayan Tang";
            self::$COURSE = "Probability Theory";
            self::$URL = "http://visg.nju.edu.cn";
            self::$ROOT_DIR = "/usr/local/apache2/htdocs/courseweb";
            self::$STORE_DIR = "/home/tbx/".Configure::$COURSE;
            self::$SESSION_VALID_TIME = 10;
        }
    }
    Configure::Init();
?>
