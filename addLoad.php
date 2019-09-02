<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "feedback_portal";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

$dept = $_POST['dept'];
$year = $_POST['year'];
$block = $_POST['block'];
$faculty = $_POST['faculty'];
$course = $_POST['course'];


$qry = "INSERT INTO faculty_load VALUES ('$dept', '$year', '$block', '$faculty', '$course')";
echo $qry;
if ($conn->query($qry) === TRUE){
    echo "New record created successfully";
} else {
    echo "Error: <br>" . $conn->error;
}

$conn->close();

header('Location: ./index.php');

?>