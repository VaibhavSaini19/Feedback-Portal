<?php

require 'model/qns_model.php';

$qm = new QuestionsModel($db);

$category = $_POST['cat'];
$type = $_POST['type'];

$res = $qm->deleteQuestions(["category='$category'", "type='$type'"]);

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
        // echo $qry;
        
        if ($qm->addQuestion($qry) === TRUE){
            echo "New record created successfully";
        } else {
            echo "Error: <br>" . $conn->error;
        }
    }
    echo "<br>";
}

// $conn->close();

header('Location: index.php?act=create_fb&cat='.$category);

?>