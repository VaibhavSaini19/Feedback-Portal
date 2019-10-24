<?php

$deptOld = $_POST['deptOld'];
$deptNew = $_POST['deptNew'];

$unameOld = $_POST['unameOld'];
$unameNew = $_POST['unameNew'];

$desc = $_POST['desc'];
$password = $_POST['password'];

$hashed_password = password_hash($password, PASSWORD_DEFAULT);

require 'model/dept_model.php';
$dm = new DepartmentModel($db);

$res = $dm->updateDepartment(["name='$deptNew'", "description='$desc'", "admin='$unameNew'", "password='$hashed_password'"],
                            ["name='$deptOld'", "admin='$unameOld'"]);

if ($res === TRUE){
    echo "Record updated successfully";
    $url = 'Location: index.php?act=manage_Dept&dept='.$deptNew.'&msg=success';
} else {
    echo "Error: <br>" . $dm->db->conn->error;
    $url = 'Location: index.php?act=manage_Dept&dept='.$deptOld.'&msg=fail';
}

header($url);

?>