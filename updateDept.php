<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "feedback_portal";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$deptOld = $_POST['deptOld'];
$deptNew = $_POST['deptNew'];

$unameOld = $_POST['unameOld'];
$unameNew = $_POST['unameNew'];

$desc = $_POST['desc'];
$password = $_POST['password'];

$hashed_password = password_hash($password, PASSWORD_DEFAULT);

$qry = "UPDATE department
        SET name='$deptNew', description='$desc', admin='$unameNew', password='$hashed_password'
        WHERE name='$deptOld' AND admin='$unameOld'";

if ($conn->query($qry) === TRUE){
    echo "Record updated successfully";
} else {
    echo "Error: <br>" . $conn->error;
}

$conn->close();
header('Location: ./manageDept?dept='.$deptNew);

?>