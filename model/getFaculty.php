<?php

// require_once './DB_connection.php';

$conditions = array();

if(!empty($_GET['department']))
    array_push($conditions, "dept='".$_GET['department']."'");
if(!empty($_GET['year']))
    array_push($conditions, "year='".$_GET['year']."'");
if(!empty($_GET['block']))
    array_push($conditions, "block='".$_GET['block']."'");
if(!empty($_GET['course']))
    array_push($conditions, "course='".$_GET['course']."'");
if(!empty($_GET['type']))
    array_push($conditions, "type='".$_GET['type']."'");


$modifiable = $_GET['modify'];
$showDept = ($_GET['department'] == null);
// $showDept = isset($_GET['department']);

$data = '
<table class="table table-sm table-bordered table-hover table-striped text-center">
    <thead class="table-success">
        <tr>
        ';
        if($showDept)
        {
        $data .= '
            <th scope="col">
                <button class="btn bg-light text-primary">
                    <strong>Department</strong>
                </button>
            </th>
        ';
        }
        $data .= '
            <th scope="col">
                <button class="btn bg-light text-primary">
                    <strong>Year</strong>
                </button>
            </th>
            <th scope="col">
                <button class="btn bg-light text-primary">
                    <strong>Block</strong>
                </button>
            </th>
            <th scope="col">
                <button class="btn bg-light text-primary">
                    <strong>Faculty</strong>
                </button>
            </th>
            <th scope="col">
                <button class="btn bg-light text-primary">
                    <strong>Course</strong>
                </button>
            </th>
            <th scope="col">
                <button class="btn bg-light text-primary">
                    <strong>Type</strong>
                </button>
            </th>
            ';
            if($modifiable == "yes"){
                $data .= '
            <th scope="col">
                <button class="btn bg-light text-primary">
                    <strong>Modify</strong>
                </button>
            </th>
            ';
            }
            $data .= '
        </tr>
    </thead>
    <tbody>';


require '../core/db.php';
$db = new DB();

require 'load_dist_model.php';
$ldm = new LoadDistributionModel($db);

$res = $ldm->enlistLoadDistribution(["*"], $conditions);

if ($res && count($res))
{
    foreach($res as $row){
        $data .= '
        <tr>
        ';
        if($showDept){
            $data .= '
            <td>'.$row['dept'].'</td>
            ';
        }
        $data .= '
            <td>'.$row['year'].'</td>
            <td>'.$row['block'].'</td>
            <td>'.$row['faculty'].' ('.$row['fac_abbr'].')</td>
            <td>'.$row['course'].' ('.$row['course_abbr'].')</td>
            <td>'.$row['type'].'</td>
            ';
        if($modifiable == "yes"){
            $data .= '
            <td>
                <span id="edit" class="far fa-edit" style="cursor: pointer;"></span>&emsp;
                <span id="delete" class="fas fa-trash" style="cursor: pointer;"></span>
            </td>
            ';
        }
        $data .= ' 
        </tr>
    ';  
    }
}else{
    $data .= '
        <tr>
            <td colspan="6">No faculties to show</td>
        </tr>
    ';
}

$data .= '
    </tbody>
</table>
';

echo $data;
?>