<?php

var_dump($_POST);

// echo count($_POST);


$servername = "localhost";
$username = "root";
$password = "";
$dbname = "feedback_portal";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

// $tableName = 'test';
$tableName = $_POST['tableName'];

$conn->query("TRUNCATE TABLE $tableName");

foreach($_POST as $k=>$v){
    if(strpos($k, 'question') !== false){
        $num = (int) filter_var($k, FILTER_SANITIZE_NUMBER_INT);
        $qn = $_POST['question'.$num];
        $opts = $_POST['response'.$num];
        $qry = "INSERT into $tableName (question";
        for($l=1; $l<=sizeof($opts); $l++){
            $qry .= ", option$l";
        }
        $qry .= ")";
        $qry .= " VALUES ('".$qn."'";
        foreach($opts as $opt){
            $qry .= ", '$opt'";
        }
        $qry .= ")";
        echo $qry;
        if ($conn->query($qry) === TRUE){
            echo "New record created successfully";
        } else {
            echo "Error: <br>" . $conn->error;
        }
    }
    echo "<br>";
}

$conn->close();

header('Location: ./feedback.php?cat='.$tableName.'');

?>