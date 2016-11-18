<?php
    //Table manager
    class TableManager {
        private $db;  //the database you wanna to manage
        private $tableName;

        public function __construct($db, $tableName) {
            $this->db           = $db;
            $this->tableName    = $tableName;
        }

        public function Query($prop/*property*/, $value) {
            if ( empty($prop) || empty($value) ) {
                return false;
            }
            $sqlstr = "SELECT * FROM $this->tableName
                       WHERE $prop = '$value'";
            echo $sqlstr."<br>"; 
            return true;
        }

        public function Update($prop4location, $value, $prop4modify, $newValue) {
            if (empty($prop4location) ||
                empty($value)         ||
                empty($prop4modify)   ||
                empty($newValue)
               ) {
                return false;
            }
            //first, make sure this record exists
            $exist = $this->Query($prop4location, $value);
            if (false == $exist) {
                return false;
            }
            //second, modify this record
            $sqlstr = "UPDATE $this->tableName SET $prop4modify = '$newValue'
                       WHERE $prop4location = '$value'";
            echo $sqlstr."<br>";
            return true;
        }

        public function Insert($user) {

        }

        public function Delete($user) {

        }
    }
?>
