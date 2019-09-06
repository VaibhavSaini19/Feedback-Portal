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

$category = $_POST['cat'];
$type = $_POST['type'];

$delQry = "DELETE FROM questions
            WHERE category='$category' AND type='$type'";
$conn->query($delQry);

$id = 0;
foreach($_POST as $k=>$v){
    if(strpos($k, 'question') !== false){
        $num = (int) filter_var($k, FILTER_SANITIZE_NUMBER_INT);
        if (empty($_POST['question'.$num])){
            // echo 'Skipping'.$num;
            continue;
        }
        // sleep(5);
        $id += 1;
        $qn = $_POST['question'.$num];
        $opts = $_POST['response'.$num];

        $qry = "INSERT into questions (question";
        for($l=1; $l<=sizeof($opts); $l++){
            $qry .= ", option$l";
        }
        $qry .= ", category, id, type)";

        $qry .= " VALUES ('".$qn."'";
        foreach($opts as $opt){
            $qry .= ", '$opt'";
        }
        $qry .= ", '$category', '$id', '$type')";
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

header('Location: ./feedback.php?cat='.$category);

?>