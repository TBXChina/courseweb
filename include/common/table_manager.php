<?php
    include_once "include/configure.php";
    include_once "include/common/log.php";
    include_once "include/common/database.php";
    //Table manager
    class TableManager {
        private $db;  //the database you wanna to manage
        private $tableName;

        public function __construct($db, $tableName) {
            $this->db           = $db;
            $this->tableName    = $tableName;
        }

        public function GetTableName() {
            return $this->tableName;
        }

        //create the new table according to the tableSql
        public function CreateNewTable($tableSql) {
            $sql = "create table if not exists ".$this->tableName.
                   " (".$tableSql.")";
            Log::Echo2Web($sql);
            $rs = $this->db->execute($sql);
            if ( true == $rs ) {
                return true;
            } else {
                return false;
            }
        }

        //lock the table, write lock
        public function Lock() {
            $sqlstr = "lock table ".$this->tableName." write";
            $this->db->RawExecute($sqlstr);
        }

        //unlock the table
        public function Unlock() {
            $sqlstr = "unlock tables";
            $this->db->RawExecute($sqlstr);
        }

        //return an array in which saved the result
        public function Query($propArray/*property*/ = array(),
                              $valueArray            = array()) {
            /*
            // allow empty var now, to get all query results
            if ( empty($propArray) || empty($valueArray) ) {
                Log::DebugEcho("Error in TableManager::Query: ".
                               "Empty var.");
                return false;
            }
            */
            if ( !is_array($propArray) ) {
                $propArray = Array($propArray);
            }
            if ( !is_array($valueArray) ) {
                $valueArray = Array($valueArray);
            }

            if ( count($propArray) != count($valueArray) ) {
                Log::DebugEcho("Error in TableManager::Query: ".
                               "The size of prorArray and valueArray not equal");
                return false;
            }
            $sqlstr = "SELECT * FROM $this->tableName ";
            $size = count($propArray);
            for ( $i = 0; $i < $size; $i++) {
                if ( 0 == $i ) {
                    $sqlstr .= " WHERE";
                } else {
                    $sqlstr .= " AND";
                }
                $sqlstr .= " $propArray[$i] = '$valueArray[$i]'";
            }
            Log::DebugEcho($sqlstr);
            $rs = $this->db->execute($sqlstr);
            if (is_bool($rs) && false == $rs) {
                Log::DebugEcho("Error in TableManager::Query, please check sql str.");
                $rs = Array();
            }
            return $rs;
        }

        public function TableRows($propArray = array(), $valueArray = array()) {
            if ( !is_array($propArray) ) {
                $propArray = Array($propArray);
            }
            if ( !is_array($valueArray) ) {
                $valueArray = Array($valueArray);
            }

            if ( count($propArray) != count($valueArray) ) {
                Log::DebugEcho("Error in TableManager::Query: ".
                               "The size of prorArray and valueArray not equal");
                return false;
            }
            $sqlstr = "SELECT count(*) FROM $this->tableName ";
            $size = count($propArray);
            for ( $i = 0; $i < $size; $i++) {
                if ( 0 == $i ) {
                    $sqlstr .= " WHERE";
                } else {
                    $sqlstr .= " AND";
                }
                $sqlstr .= " $propArray[$i] = '$valueArray[$i]'";
            }
            Log::DebugEcho($sqlstr);
            $rs = $this->db->execute($sqlstr);
            if (is_bool($rs) && false == $rs) {
                Log::DebugEcho("Error in TableManager::Query, please check sql str.");
                $rs = Array();
                return -1;
            }
            return $rs[0]["count(*)"];
        }

        public function Exist($propArray, $valueArray) {
            return 0 < $this->TableRows($propArray, $valueArray);
        }

        public function Update($prop4location, $value, $prop4modify, $newValue) {
            if (empty($prop4location) ||
                empty($value)         ||
                empty($prop4modify)   ||
                empty($newValue)
               ) {
                Log::DebugEcho("Error in TableManager::Update, Empty var.");
                return false;
            }
            //first, make sure this record exists
            if (false == $this->Exist($prop4location, $value)) {
                Log::DebugEcho("Error in TableManager::Updata: the record don't exist.");
                return false;
            }
            //second, modify this record
            $sqlstr = "UPDATE $this->tableName SET $prop4modify = '$newValue'
                       WHERE $prop4location = '$value'";
            if ( true == $this->db->execute($sqlstr) ) {
                return true;
            } else {
                Log::DebugEcho("Error in TableManager::Updata: updata the record failed.");
                return false;
            }
        }

        //only one restric, primary key must put in the 0th in the array
        public function Insert($propArray, $valueArray) {
            if ( 0 == count($propArray) ||
                 0 == count($valueArray)||
                 !is_array($propArray ) ||
                 !is_array($valueArray)) {
                Log::Echo2Web("Error in TableManager::Insert, Empty var or not array.");
                return false;
            }
            if ( count($propArray) != count($valueArray) ) {
                Log::DebugEcho("Error in TableManager::Insert: ".
                               "the size of two array not equal.");
                return false;
            }

            $primaryProp  = $propArray[0];
            $primaryValue = $valueArray[0];
            if ( true == $this->Exist($primaryProp, $primaryValue) ) {
                Log::Echo2Web("Warning: this record already exists, ".
                     "no need to insert.");
                return  false;
            }

            //insert sql str
            $sqlstr = "INSERT INTO $this->tableName VALUES(";
            foreach ( $valueArray as $value ) {
                $sqlstr .= "'$value',";
            }
            $sqlstr = rtrim($sqlstr, ",");
            $sqlstr .= ")";
            if ( true == $this->db->execute($sqlstr) ) {
                return true;
            } else {
                Log::Echo2Web("Error in TableManager::Insert: failed to insert.");
                return false;
            }
        }

        public function Delete($prop, $value) {
            if ( empty($prop) || empty($value) ) {
                Log::DebugEcho("Error in TableManager::Delete, Empty var.");
                return false;
            }
            if ( false == $this->Exist($prop, $value) ) {
                Log::DebugEcho("Error in TableManager::Delete, ".
                               "this record doesn't exist. ".
                               "Are you sure not kidding me?");
                return false;
            }

            $sqlstr = "DELETE FROM $this->tableName
                    WHERE $prop = '$value'";
            if ($this->db->execute($sqlstr)) {
                return true;
            } else {
                Log::DebugEcho("Error in TableManager::Delete: failed to delete.");
                return false;
            }
        }

        public function Execute($sqlstr) {
            $rs = $this->db->execute($sqlstr);
            return $rs;
        }
    }

    class TableManagerFactory {
        static public function Create($tableName) {
            $db = DatabaseFactory::Create();
            $manager = new TableManager($db, $tableName);
            return $manager;
        }
    }
?>
