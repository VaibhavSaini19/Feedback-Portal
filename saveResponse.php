<?php

require_once './DB_connection.php';

// var_dump($_POST);


$qry = "INSERT INTO response
        VALUES ";
$flag = 0;
foreach($_POST as $desc=>$score){
    $desc = explode("_", $desc);
    $qid = $desc[0];
    $faculty = $desc[1];
    $course = $desc[2];
    $type = $desc[3];
    $token = $desc[4];
    $score = (int)$score;

    if($flag){
        $qry .= ", ";
    }
    $qry .= "('$faculty', '$course', '$type', $qid, $score, '$token')";

    $flag = 1;
}
    // echo $qry;
    
    if ($conn->query($qry) === TRUE){
        echo "New record created successfully";
    } else {
        echo "Error: <br>" . $conn->error;
    }
$conn->close();
?>