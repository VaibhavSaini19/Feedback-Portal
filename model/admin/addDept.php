<?php
    $deptName = $_POST['deptName'];
    $desc = $_POST['desc'];
    $uname = $_POST['uname'];
    $password = $_POST['password'];

    require 'model/dept_model.php';

    $dm = new DepartmentModel($db);

    $status = $dm->addDepartment($deptName, $desc, $uname, $password);

    if ($status === TRUE){
        echo "New record created successfully";
        $url = 'Location: index.php?act=home&tab=dept&msg=success';
    } else {
        echo "Error: <br>" . $dm->db->conn->error;
        $url = 'Location: index.php?act=home&tab=dept&msg=fail';
    }
    header($url);
?>