<?php

$deptName = $_POST['department'];


if($_GET['mode'] == 'edit'){
    require 'model/load_dist_model.php';
    $ldm = new LoadDistributionModel($db);
    
    $facultyOld = $_POST['facultyOld'];
    $facultyNew = $_POST['facultyNew'];

    $res = $ldm->updateLoadDistribution(["faculty='$facultyNew'"], ["faculty='$facultyOld'"]);

    if ($res === TRUE){
        echo "Record updated successfully";
        $url = 'Location: index.php?act=home&msg=success';
    } else {
        echo "Error: <br>" . $ldm->db->conn->error;
        $url = 'Location: index.php?act=home&msg=fail';
    }
    header($url);

}else if($_GET['mode'] == 'delete'){
    require '../../core/db.php';
    $db = new DB();
    require '../load_dist_model.php';
    $ldm = new LoadDistributionModel($db);
    
    $colnames = ["year", "block", "faculty", "course", "type"];
    $values = explode(",", $_POST['arr']);
    $filter = "dept='$deptName'";
    foreach($values as $i=>$val){
        $filter .= " AND $colnames[$i]='$val'";
    }

    $res = $ldm->deleteLoadDistribution($filter);

    if ($res === TRUE){
        echo "Record deleted successfully";
        $url = 'Location: index.php?act=home&msg=success';
    } else {
        echo "Error: <br>" . $ldm->db->conn->error;
        $url = 'Location: index.php?act=home&msg=fail';
    }
    // header($url);
}

?>