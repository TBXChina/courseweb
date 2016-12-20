<?php
    //configure
    class Configure {
        static public $AUTHORS;

        //course info
        static public $COURSE;
        static public $COURSE_DIR_NAME;
        static public $COURSE_EMAIL;

        //web info
        static public $URL;
        static public $LOGINPAGE;
        static public $CONSOLEPAGE;
        static public $ADMINCONSOLEPAGE;

        //some important dir
        static public $ROOT_DIR;
        static public $STORE_DIR;
        static public $ADMIN_DIR;
        static public $STUDENT_DIR;
        static public $SHARED_DIR;
        static public $ASSIGNMENTDIR;

        //some important var about database
        static public $DBHOST;
        static public $DBUSER;
        static public $DBPWD;
        static public $DBNAME;
        static public $USERTABLE;
        static public $NEWSTABLE;

        //constraint
        static public $UPLOAD_FILE_MAX; /*Byte*/
        static public $SESSION_VALID_TIME; /*second*/

        //encode var
        static public $SALT;

        //Init
        static public function Init() {
            self::$AUTHORS              = "Brayan Tang, QQ Lee, ZYQ";
            self::$COURSE               = "Probability Theory";
            self::$COURSE_DIR_NAME      = "courseweb";
            self::$COURSE_EMAIL         = "probability2017@163.com";
            self::$URL                  = "http://127.0.0.1/".self::$COURSE_DIR_NAME;
            self::$LOGINPAGE            = "/".self::$COURSE_DIR_NAME."/index.php";
            self::$CONSOLEPAGE          = "/".self::$COURSE_DIR_NAME."/console.php";
            self::$ADMINCONSOLEPAGE     = "/".self::$COURSE_DIR_NAME."/admin.php";
            self::$ROOT_DIR             = "/usr/local/apache2/htdocs/courseweb";
            self::$STORE_DIR            = "/home/tbx/".self::$COURSE;
            self::$ADMIN_DIR            = self::$STORE_DIR."/admin";
            self::$STUDENT_DIR          = self::$STORE_DIR."/student";
            self::$SHARED_DIR           = self::$STORE_DIR."/shared";
            self::$ASSIGNMENTDIR        = self::$ADMIN_DIR."/Assignment";
            self::$DBHOST               = "127.0.0.1";
            self::$DBUSER               = "root";
            self::$DBPWD                = "tbx";
            self::$DBNAME               = "testDB";
            self::$USERTABLE            = "test";
            self::$NEWSTABLE            = "NewsTable";
            self::$UPLOAD_FILE_MAX      = 20971520;
            self::$SESSION_VALID_TIME   = 10;
            self::$SALT                 = "6Ut!4Q";
        }
    }
    Configure::Init();
?>
