<?php
class ResponseModel {
    var $data = null;
    var $db = null;

    function __construct($db) {
        $this->db = $db;
    }

    function saveData($prn) {
        $sql = "INSERT INTO response VALUES ";
        $flag = 0;
        foreach($_POST as $desc=>$score){
            $desc = explode("_", $desc);
            $qid = $desc[0];
            $faculty = $desc[1];
            $course = $desc[2];
            $type = $desc[3];
            $token = $desc[4];
            $score = (int)$score;

            if($flag){
                $sql .= ", ";
            }
            $sql .= "('$faculty', '$course', '$type', $qid, $score, '$token')";

            $flag = 1;
        }
        // var_dump($sql);
        $res = $this->db->execute($sql, "I");
        if($res){
            $sql = "UPDATE student_tokens SET status=1 WHERE prn='$prn'";
            $this->db->execute($sql, "U");
            return true;
        }
        return false;
    }

}
?>