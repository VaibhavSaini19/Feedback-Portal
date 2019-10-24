<?php
class DB {

    var $conn = null;
    var $res = null;

    function __construct() {
        $this->conn = new mysqli('localhost', 'root', '', 'feedback_portal');
        if ($this->conn->connect_error) {
            die("Error: Failed to connect with the database");
        }
    }

    function execute($sql, $type) {
        if (($type=='I' || $type=='U' || $type=='D') && $sql !='') {
            return $this->conn->query($sql);
        } elseif ($type=="S") {
            $this->res = $this->conn->query($sql);
            if ($this->res->num_rows>0) {
                $data = [];
                while($row = $this->res->fetch_assoc()) {
                    $data[] = $row;
                }
                return $data;
            }
        }
    }

    function getNoOfRows() {
        return $this->res->num_rows;
    }
}
?>