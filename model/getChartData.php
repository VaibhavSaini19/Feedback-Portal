<?php

    $filterBy = $_GET['filterBy'];

    require '../core/db.php';
    $db = new DB();
    require '../model/response_model.php';
    $rm = new ResponseModel($db);

    $data = array();
    $result = $rm->enlistResponse(["qid", "score"], ["dept='SCET'", "type='theory'"]);
    // var_dump($result);
    if($filterBy == 'block'){
    }
    foreach($result as $row){
        array_push($data, array("x"=> $row['qid'], "y"=> $row['score']));
    }
    $data = json_encode($data, JSON_NUMERIC_CHECK);
    // var_dump($data);
    echo $data;
?>

