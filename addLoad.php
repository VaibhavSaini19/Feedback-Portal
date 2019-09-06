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
$fac_abbr = $_POST['fac_abbr']; 
$course = $_POST['course'];
$course_abbr = $_POST['course_abbr']; 
$course_type = $_POST['course_type'];


$qry = "INSERT INTO load_distribution 
        VALUES ('$dept', '$year', '$block', '$faculty', '$fac_abbr', '$course', '$course_abbr', '$course_type')";
echo $qry;
if ($conn->query($qry) === TRUE){
    echo "New record created successfully";
} else {
    echo "Error: <br>" . $conn->error;
}

$conn->close();

header('Location: ./index.php#load');

?>