<?php

require_once './DB_connection.php';

$uname = $_POST['username'];
$password = $_POST['password'];
// $hashed_password = password_hash($password, PASSWORD_DEFAULT);

$qry = "SELECT * FROM department
        WHERE admin='$uname'";
echo $qry;
$res = $conn->query($qry);

if($res->num_rows > 0){
    $row = $res->fetch_array();
    if(password_verify($password, $row['password'])){
        if($row['admin'] == 'admin'){
            header('Location: ./index.php');
        }else{
            header('Location: ./department.php?dept='.$row['name']);
        }
    }else{
        header('Location: ./adminLogin?error="wrongPwd"');    
    }
}else{
    header('Location: ./adminLogin?error="noUsername"');
}
$conn->close();
?>