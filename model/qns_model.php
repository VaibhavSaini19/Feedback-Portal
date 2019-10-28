<?php
class QuestionsModel {
    var $data = null;
    var $db = null;

    function __construct($db) {
        $this->db = $db;
    }
   
    function enlistQuestions($project=[], $filter=[], $groupBy=[], $orderBy=[]){
        if($project != []){
            $project = implode(', ', $project);
        } else {
            $project = "*";
        }
        if($filter != []){
            $filter = ' WHERE ' .implode(' AND ', $filter);
        } else {
            $filter = '';
        }
        if($groupBy != []){
            $groupBy = ' GROUP BY ' . implode(', ', $groupBy);
        } else {
            $groupBy = '';
        }
        if($orderBy != []){
            $orderBy = ' ORDER BY ' . implode(', ', $orderBy);
        } else {
            $orderBy = '';
        }
        $sql = "SELECT $project from questions $filter $groupBy $orderBy";
        // var_dump($sql);
        $this->data = $this->db->execute($sql,"S");
        return $this->data;
    }

    function addQuestion($sql){
        return $this->db->execute($sql, "I");
    }

    function deleteQuestions($filter=[]){
        if($filter != []){
            $filter = implode(' AND ', $filter);
            $filter = ' WHERE ' . $filter;
        } else {
            $filter = '';
        }
        $sql = "DELETE FROM questions $filter";
        return $this->db->execute($sql, "D");
    }

}
