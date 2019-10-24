<?php
    $deptName = $_GET['deptName'];

    require 'model/dept_model.php';

    $dm = new DepartmentModel($db);

    $status = $dm->deleteDepartment($deptName);

    if ($status === TRUE){
        echo "New record created successfully";
        $url = 'Location: index.php?act=home&tab=dept&msg=success';
    } else {
        echo "Error: <br>" . $dm->db->conn->error;
        $url = 'Location: index.php?act=home&tab=dept&msg=fail';
    }
    header($url);
?>