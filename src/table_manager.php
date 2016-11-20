<?php
    //Table manager
    class TableManager {
        private $db;  //the database you wanna to manage
        private $tableName;

        public function __construct($db, $tableName) {
            $this->db           = $db;
            $this->tableName    = $tableName;
        }

        //return an array in which saved the result
        public function Query($prop/*property*/, $value) {
            if ( empty($prop) || empty($value) ) {
                echo "Error in TableManager::Query, Empty var<br>\n";
                return false;
            }
            $sqlstr = "SELECT * FROM $this->tableName
                       WHERE $prop = '$value'";
            $rs = $this->db->execute($sqlstr);
            if (is_bool($rs) && false == $rs) {
                echo "Error in TableManager::Query, please check sql str<br>\n";
                $rs = Array();
            }
            return $rs;
        }

        public function Exist($prop, $value) {
            return 0 != count($this->Query($prop, $value));
        }

        public function Update($prop4location, $value, $prop4modify, $newValue) {
            if (empty($prop4location) ||
                empty($value)         ||
                empty($prop4modify)   ||
                empty($newValue)
               ) {
                echo "Error in TableManager::Update, Empty var<br>\n";
                return false;
            }
            //first, make sure this record exists
            if (false == $this->Exist($prop4location, $value)) {
                echo "Error in TableManager::Updata: the record don't exist<br>\n";
                return false;
            }
            //second, modify this record
            $sqlstr = "UPDATE $this->tableName SET $prop4modify = '$newValue'
                       WHERE $prop4location = '$value'";
            if ( true == $this->db->execute($sqlstr) ) {
                return true;
            } else {
                echo "Error in TableManager::Updata: updata the record failed<br>\n";
                return false;
            }
        }

        //only one restric, primary key must put in the 0th in the array
        public function Insert($propArray, $valueArray) {
            if ( 0 == count($propArray) ||
                 0 == count($valueArray)||
                 !is_array($propArray ) ||
                 !is_array($valueArray)) {
                echo "Error in TableManager::Insert, Empty var or not array.<br>\n";
                return false;
            }
            if ( count($propArray) != count($valueArray) ) {
                echo "Error in TableManager::Insert: the size of two array not equal.<br>\n";
                return false;
            }

            $primaryProp  = $propArray[0];
            $primaryValue = $valueArray[0];
            if ( true == $this->Exist($primaryProp, $primaryValue) ) {
                echo "Warning in TableManager::Insert: ".
                     "this record already exists, ".
                     "no need to insert.<br>\n";
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
                echo "Error in TableManager::Insert: failed to insert.<br>\n";
                return false;
            }
        }

        public function Delete($prop, $value) {
            if ( empty($prop) || empty($value) ) {
                echo "Error in TableManager::Delete, Empty var<br>\n";
                return false;
            }
            if ( false == $this->Exist($prop, $value) ) {
                echo "Error in TableManager::Delete, ".
                     "this record doesn't exist. ".
                     "Are you sure not kidding me?<br>\n";
                return false;
            }

            $sqlstr = "DELETE FROM $this->tableName
                    WHERE $prop = '$value'";
            if ($this->db->execute($sqlstr)) {
                return true;
            } else {
                echo "Error in TableManager::Delete: failed to delete.<br>\n";
                return false;
            }
        }
    }
?>
