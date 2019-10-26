<?php
class LoadDistributionModel {
    var $data = null;
    var $db = null;

    function __construct($db) {
        $this->db = $db;
    }
   
    function enlistLoadDistribution($project=[], $filter=[], $groupby=[]){
        if($project != []){
            $project = implode(', ', $project);
        }else{
            $project = "*";
        }
        if($filter != []){
            $filter = implode(' AND ', $filter);
            $filter = ' WHERE ' . $filter;
        }else{
            $filter = "";
        }
        if($groupby != []){
            $groupby = ' GROUP BY ' . implode(', ', $groupby);
        }else{
            $groupby = "";
        }
        $sql = "SELECT $project from load_distribution $filter $groupby";
        // var_dump($sql);
        $this->data = $this->db->execute($sql,"S");
        return $this->data;
    }

    function addLoadDistribution($dept, $year, $block, $faculty, $fac_abbr, $course, $course_abbr, $course_type){
        $sql = "INSERT INTO load_distribution VALUES ('$dept', '$year', '$block', '$faculty', '$fac_abbr', '$course', '$course_abbr', '$course_type')";
        return $this->db->execute($sql, "I");
    }

    function updateLoadDistribution($set, $filter){
        if(!empty($set) && !empty($filter)){
            $set = implode(', ', $set);
            $filter = ' WHERE ' . implode(' AND ', $filter);
            $sql = "UPDATE load_distribution SET $set $filter";
            return $this->db->execute($sql, "U");
        }
        return false;
    }

    function deleteLoadDistribution($filter){
        if(!empty($filter)){
            $filter = ' WHERE ' . $filter;
            $sql = "DELETE FROM load_distribution $filter";
            // var_dump($sql);
            return $this->db->execute($sql, "D");
        }
        return false;
    }

}
