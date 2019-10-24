<?php
class DepartmentModel {
    var $data = null;
    var $db = null;

    function __construct($db) {
        $this->db = $db;
    }
   
    function enlistDepartment($filter=[]){
        if($filter != []){
            $filter = implode(' AND ', $filter);
            $filter = ' WHERE ' . $filter;
        } else {
            $filter = '';
        }
        $sql = "SELECT * from department $filter";
        $this->data = $this->db->execute($sql,"S");
        return $this->data;
    }

    function addDepartment($deptName, $desc, $uname, $password){
        if (!empty($deptName) && !empty($desc) && !empty($uname) && !empty($password)){
            $db = new DB;
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $sql = "INSERT INTO department VALUES ('$deptName', '$desc', '$uname', '$hashed_password', 'F')";
            // echo $sql;
            return $this->db->execute($sql,'I');
        }
        return false;
    }

    function updateDepartment($set, $filter){
        if(!empty($set) && !empty($filter)){
            $set = implode(', ', $set);
            $filter = ' WHERE ' . implode(' AND ', $filter);
            $sql = "UPDATE department SET $set $filter";
            return $this->db->execute($sql, "U");
        }
        return false;
    }

    function deleteDepartment($deptName){
        if(!empty($deptName)){
            $sql = "DELETE from department WHERE name='$deptName'";
            return $this->db->execute($sql, "D");
        }
    }
}
