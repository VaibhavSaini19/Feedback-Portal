<?php

    $catName = $_POST['catName'];

    require 'model/category_model.php';
    $cm = new CategoryModel($db);

    $status = $cm->addCategory($catName);

    if ($status === TRUE){
        // echo "New record created successfully";
        $url = 'Location: index.php?act=home&tab=cat&msg=success';
    } else {
        // echo "Error: <br>" . $db->conn->error;
        $url = 'Location: index.php?act=home&tab=cat&msg=fail';
    }
    header($url);

?>