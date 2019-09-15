<?php

require_once './DB_connection.php';

$deptName = $_POST['deptName'];
$desc = $_POST['desc'];
$uname = $_POST['uname'];
$password = $_POST['password'];

$hashed_password = password_hash($password, PASSWORD_DEFAULT);


$qry = "INSERT INTO department VALUES ('$deptName', '$desc', '$uname', '$hashed_password')";
// echo $qry;
if ($conn->query($qry) === TRUE){
    echo "New record created successfully";
} else {
    echo "Error: <br>" . $conn->error;
}

$conn->close();

header('Location: ./index.php#department');

?>