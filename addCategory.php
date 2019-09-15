<?php

require_once './DB_connection.php';

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