<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "feedback_portal";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

$catName = $_POST['catName'];

$qry = "INSERT INTO category_list VALUES ('$catName')";
echo $qry;
if ($conn->query($qry) === TRUE){
    echo "New record inserted successfully";
} else {
    echo "Error: <br>" . $conn->error;
}

$conn->close();

header('Location: ./index.php#category');

?>