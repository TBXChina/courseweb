<?php
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
    class ExecSQL {
        public function __construct($dbParam) {
            $host   = $dbParam->host;
            $user   = $dbParam->user;
            $pwd    = $dbParam->pwd;
            $dbname = $dbParam->dbname;
            $conn   = new mysqli($host, $user, $pwd, $dbname);
            if ($conn->connect_error) {
                die("Connetct to host: ".$host." failed. Error Code = ".$conn->connect_error."<br/>");
            } else {
                echo "connect to db: ".$host."::".$dbname."<br/>";
            }
            $this->dbParam 	= $dbParam;
            $this->conn = $conn;
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
                if (false == $rs) {
                    return false;
                }
                $i = 0;
                $arr = array();
                //associative array, row[coluneName] = value
                while ($row = $rs->fetch_array(MYSQLI_ASSOC)) {
                    $arr[$i] = $row;
                    $i = $i + 1;
                }			
                return $arr;
            } else {
                echo "SQL: ".$sqlstr." expression invalid.<br/>";
                return false;
            }
            return false;
        }

        public function __destruct() {
            if ($this->conn) {
                $this->conn->close();
                echo "close db";
            }
        }

        private $dbParam;
        private $conn;    //connect to the database
    }

    /*
    $dbParam = new DBParam("127.0.0.1", "root", "tbx", "testDB");
    $execSQL = new ExecSQL($dbParam);
    $rs = $execSQL->execute("select * from test");
    echo $rs ? 1 : 0;
    echo "<br/>";
    print_r($rs);
    echo "<br/>";
    */
?>
