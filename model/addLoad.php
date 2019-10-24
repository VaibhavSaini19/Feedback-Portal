<?php

$dept = $_POST['dept'];
$year = $_POST['year'];
$block = $_POST['block'];
$faculty = $_POST['faculty'];
$fac_abbr = $_POST['fac_abbr']; 
$course = $_POST['course'];
$course_abbr = $_POST['course_abbr']; 
$course_type = $_POST['course_type'];

require 'model/load_dist_model.php';

$ldm = new LoadDistributionModel($db);

$res = $ldm->addLoadDistribution($dept, $year, $block, $faculty, $fac_abbr, $course, $course_abbr, $course_type);

// echo $qry;
if ($res === TRUE){
    echo "New record created successfully";
    $url = 'Location: index.php?act=home&msg=success#load';
} else {
    echo "Error: <br>" . $res->conn->error;
    $url = 'Location: index.php?act=home&msg=fail#load';
}

header($url);

?>