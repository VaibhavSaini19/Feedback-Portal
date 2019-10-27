<?php
class ResponseModel {
    var $data = null;
    var $db = null;

    function __construct($db) {
        $this->db = $db;
    }
    
    function enlistResponse($project=[], $filter=[], $groupby=[], $orderby=[]){
        if(!empty($project)){
            $project = implode(', ', $project);
        }else{
            $project = '*';
        }
        if(!empty($filter)){
            $filter = ' WHERE ' . implode(' AND ', $filter);
        }else{
            $filter = '';
        }
        if(!empty($groupby)){
            $groupby = ' GROUP BY ' . implode(', ', $groupby);
        }else{
            $groupby = '';
        }
        if(!empty($orderby)){
            $orderby = ' ORDER BY ' . implode(', ', $orderby);
        }else{
            $orderby = '';
        }
        $sql = "SELECT $project FROM response $filter $groupby $orderby";
        // var_dump($sql);
        return $this->db->execute($sql ,"S");
    }

    function saveData($prn) {
        $sql = "INSERT INTO response VALUES ";
        $flag = 0;
        foreach($_POST as $desc=>$score){
            $desc = explode("_", $desc);
            $qid = $desc[0];
            $faculty = $desc[1];
            $course = $desc[2];
            $dept = $desc[3];
            $year = $desc[4];
            $block = $desc[5];
            $type = $desc[6];
            $token = $desc[7];
            $score = (int)$score;

            if($flag){
                $sql .= ", ";
            }
            $sql .= "('$faculty', '$course', '$dept', '$year', '$block','$type', $qid, $score, '$token')";

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