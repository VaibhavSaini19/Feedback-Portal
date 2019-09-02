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

$qry = "CREATE TABLE $catName (
    question varchar(100),
    option1 varchar(50),
    option2 varchar(50),
    option3 varchar(50),
    option4 varchar(50),
    option5 varchar(50)
    )";

echo $qry;
if ($conn->query($qry) === TRUE){
    echo "New table created successfully";
} else {
    echo "Error: <br>" . $conn->error;
}

$conn->close();

header('Location: ./index.php');

?>