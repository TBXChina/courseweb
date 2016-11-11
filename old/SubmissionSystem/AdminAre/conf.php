<?php
//course Name
$COURSE 		= "Probability Theory";
$AUTHOR			= "T";


// Some important Dir
$URL			= "http://visg.nju.edu.cn";
$ROOT_DIR 		= "/usr/local/apache2/htdocs/SubmissionSystem";  
$STORE_DIR		= "/home/visg/ProbabilityTheory";

$SHARED_DIR 	= $STORE_DIR."/SharedAre";
$ADMIN_DIR 		= $STORE_DIR."/Admin";
$STUDENT_DIR	= $STORE_DIR."/StudentAre";
$NAMELIST_DIR	= $STORE_DIR."/NameList.txt";
$ADMINLIST_DIR	= $STORE_DIR."/AdminList.txt";
$NOTICE_PATH 	= $SHARED_DIR."/notice.txt";

$FILE_OP_DIR 	= $ROOT_DIR."/AdminAre/file_op";
$MYSQL_OP_DIR	= $ROOT_DIR."/AdminAre/mysql_op";
$HOMEWORK_DIR	= $SHARED_DIR."/homework";
$PPT_DIR		= $SHARED_DIR."/ppt";

//some var to label identification
$IDENTITY		= "Identity";
$ADMIN 			= "Admin";
$STUDENT 		= "Student";

// some important var
$SERVERNAME		= "127.0.0.1";
$DBUSER 		= "root";
$DBPWD 			= "tbx";
$DBNAME 		= "ProbabilityTheoryDB";
$TABLENAME		= "Student";
$ADMINTABLENAME	= "Admin";


// some important var in Table
$USERNAME		= "UserName";
$PASSWD			= "PassWD";

// Some Important upload file limits
//this var must smaller than POST_MAX_SIZE and UPLOAD_MAX_FILESIZE in php.ini  
$UPLOAD_FILE_MAX = 20971520/*Byte*/;  



?>