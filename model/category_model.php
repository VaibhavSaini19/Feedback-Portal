<?php
class CategoryModel {
    var $data = null;
    var $db = null;

    function __construct($db) {
        $this->db = $db;
    }
   
    function enlistCategory(){
        $sql = "SELECT * from category_list";
        $this->data = $this->db->execute($sql,"S");
        return $this->data;
    }

    function addCategory($catName){
        if (!empty($catName)){
            $db = new DB;
            $sql = "INSERT INTO category_list VALUES ('$catName')";
            // echo $qry;
            return $db->execute($sql,'I');
        }
        return false;
    }

}
