<?php

    $filterBy = $_GET['filterBy'];

    require 'model/response_model.php';
    $rm = new ResponseModel($db);
    $data = array();
    $result = $rm->getData(["qid", "score"], ["dept='SCET'", "type='theory'"]);
    foreach($result as $row){
        array_push($data, array("x"=> $row['qid'], "y"=> $row['score']));
    }
    echo json_encode($data, JSON_NUMERIC_CHECK);
?>

