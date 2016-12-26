<?php
    include_once "include/configure.php";
    include_once "include/common/log.php";
    //database parameter
    class DBParam {
        public $host;
        public $user;
        public $pwd;
        public $dbname;
        public function __construct($host, $user, $pwd, $dbname) {
            $this->host     = $host;
            $this->user     = $user;
            $this->pwd      = $pwd;
            $this->dbname   = $dbname;
        }
    }

    //Execute sql
    class Database {
        public function __construct($dbParam) {
            $host   = $dbParam->host;
            $user   = $dbParam->user;
            $pwd    = $dbParam->pwd;
            $dbname = $dbParam->dbname;
            $conn   = new mysqli($host, $user, $pwd, $dbname);
            if ($conn->connect_error) {
                die("Connetct to host: ".$host." failed. Error Code = ".$conn->connect_error."<br>\n");
            } else {
                Log::DebugEcho("connect to db: ".$host."::".$dbname);
            }
            $this->dbParam 	= $dbParam;
            $this->conn = $conn;
        }

        public function __destruct() {
            if ($this->conn) {
                $this->conn->close();
                Log::DebugEcho("Close DB");
            }
        }

        //create new DB
        static public function CreateDatabase($dbParam) {
            $host   = $dbParam->host;
            $user   = $dbParam->user;
            $pwd    = $dbParam->pwd;
            $dbname = $dbParam->dbname; //new database name
            $conn   = new mysqli($host, $user, $pwd);
            if ($conn->connect_error) {
                die("Connetct to host: ".$host." failed. Error Code = ".$conn->connect_error."<br>\n");
            } else {
                Log::DebugEcho("connect to db: ".$host."::".$dbname);
            }
            $sql = "create database $dbname";
            $rs = $conn->query($sql);
            if ($conn) {
                $conn->close();
                Log::DebugEcho("Close DB");
            }
            if ( true == $rs ) {
                Log::DebugEcho("New Database: ".$dbname." created.");
                return true;
            } else {
                Log::DebugEcho("Fail to create new Database: ".$dbname);
                return false;
            }
        }

        //drop current DB
        static public function DropDatabase($dbParam) {
            $host   = $dbParam->host;
            $user   = $dbParam->user;
            $pwd    = $dbParam->pwd;
            $dbname = $dbParam->dbname; //database you want to drop
            $conn   = new mysqli($host, $user, $pwd);
            if ($conn->connect_error) {
                die("Connetct to host: ".$host." failed. Error Code = ".$conn->connect_error."<br>\n");
            } else {
                Log::DebugEcho("connect to db: ".$host."::".$dbname);
            }
            $sql = "drop database if exists $dbname";
            $rs = $conn->query($sql);
            if ($conn) {
                $conn->close();
                Log::DebugEcho("Close DB");
            }
            if ( true == $rs ) {
                Log::DebugEcho("Database: ".$dbname." has dropped.");
                return true;
            } else {
                Log::DebugEcho("Fail to drop Database: ".$dbname);
                return false;
            }
        }

        //execute any sql str
        //return true/false, or the result set according to the sql str;
        public function execute($sqlstr) {
            //cut out the first 6 character
            $sqlType = strtolower(substr(trim($sqlstr), 0, 6));  
            $rs = $this->conn->query($sqlstr); //execute sqlstr
            if ("create" == $sqlType ||
                "update" == $sqlType ||
                "insert" == $sqlType ||
                "delete" == $sqlType) {
                if ($rs) {
                    return true;
                }
                else {
                    return false;
                }
            } elseif ("select" == $sqlType) {
                if (is_bool($rs) && false == $rs) {
                    return false;
                }
                $i = 0;
                $arr = array();
                //associative array, row[coluneName] = value
                while ($row = $rs->fetch_array(MYSQLI_ASSOC)) {
                    $arr[$i] = $row;
                    $i = $i + 1;
                }
                mysqli_free_result($rs);
                return $arr;
            } else {
                Log::DebugEcho("SQL: ".$sqlstr." expression invalid.");
                return false;
            }
            return false;
        }

        private $dbParam;
        private $conn;    //connect to the database
    }

    class DatabaseFactory {
        static public function Create() {
            $host = Configure::$DBHOST;
            $user = Configure::$DBUSER;
            $pwd  = Configure::$DBPWD;
            $name = Configure::$DBNAME;
            $dbParam = new DBParam($host, $user, $pwd, $name);
            $db = new Database($dbParam);
            return $db;
        }
    }
?>
