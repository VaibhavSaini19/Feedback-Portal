<?php
class QuestionsModel {
    var $data = null;
    var $db = null;

    function __construct($db) {
        $this->db = $db;
    }
   
    function enlistQuestions($filter=[], $orderBy=''){
        if($filter != []){
            $filter = implode(' AND ', $filter);
            $filter = ' WHERE ' . $filter;
        } else {
            $filter = '';
        }
        if($orderBy != ''){
            $orderBy = ' ORDER BY ' . $orderBy;
        } else {
            $orderBy = '';
        }
        $sql = "SELECT * from questions $filter $orderBy";
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
