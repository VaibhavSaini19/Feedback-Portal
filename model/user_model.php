<?php
class UserModel {
    var $data = null;
    var $db = null;

    function __construct($db) {
        $this->db = $db;
    }

    function checkUser($username, $password) {
        if (!empty($username) && !empty($password)) {
            $sql = "SELECT * FROM department WHERE name='$username'";
            $this->data = $this->db->execute($sql,"S");
            if ($this->db->getNoOfRows()==1) {
                if (password_verify($password, $this->data[0]['password']))
                    return true;
            }
        }
        return false;
    }

    function checkStudent($prn, $token) {
        if (!empty($prn) && !empty($token)) {
            $sql = "SELECT * FROM student_tokens WHERE prn='$prn' AND token='$token'";
            $this->data = $this->db->execute($sql,"S");
            if ($this->db->getNoOfRows()==1) {
                return true;
            }
        }
        return false;
    }
}
?>