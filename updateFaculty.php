<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "feedback_portal";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$dept = $_REQUEST['department'];

if($_GET['mode'] == 'edit'){

    $facultyOld = $_POST['facultyOld'];
    $facultyNew = $_POST['facultyNew'];

    $qry = "UPDATE load_distribution
            SET faculty='$facultyNew'
            WHERE faculty='$facultyOld'";

    if ($conn->query($qry) === TRUE){
        echo "Record updated successfully";
    } else {
        echo "Error: <br>" . $conn->error;
    }
    $conn->close();
    header('Location: ./department?dept='.$dept);

}else if($_GET['mode'] == 'delete'){
    $colnames = ["year", "block", "faculty", "course", "type"];
    $values = explode(",", $_POST['arr']);
    $qry = "DELETE FROM load_distribution
            WHERE dept='$dept'";
    foreach($values as $i=>$val){
        $qry .= " AND $colnames[$i]='$val'";
    }
    // echo $qry;
    if ($conn->query($qry) === TRUE){
        echo "Record deleted successfully";
    } else {
        echo "Error: <br>" . $conn->error;
    }
    $conn->close();
}

?>