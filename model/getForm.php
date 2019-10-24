<?php

$cat = $_GET['category'];
$type = $_GET['type'];

if(isset($_GET['token'])){
    $token = $_GET['token'];
    $listFaculty = true;
}else{
    $token = "";
    $listFaculty = false;
}

$conditions = array();

if(!empty($_GET['department']))
    array_push($conditions, "dept='".$_GET['department']."'");
if(!empty($_GET['year']))
    array_push($conditions, "year='".$_GET['year']."'");
if(!empty($_GET['block']))
    array_push($conditions, "block='".$_GET['block']."'");
if(!empty($_GET['type']))
    array_push($conditions, "type='".$_GET['type']."'");

// var_dump($conditions);

require '../core/db.php';
$db = new DB();

require 'load_dist_model.php';
$ldm = new LoadDistributionModel($db);


require 'qns_model.php';
$qm = new QuestionsModel($db);


$fac_list = $ldm->enlistLoadDistribution(["*"], $conditions);
$res = $qm->enlistQuestions(["category='$cat'", "type='$type'"], 'id');

$data = '
<table class="table table-hover table-responsive-sm table-bordered">
    <tbody>';
if($res && count($res)){
    foreach($res as $row){
        $data .= '
        <tr>
            <td colspan="2"></td>
            <td colspan="5" scope="row" class="bg-light">
                <strong>'.$row['question'].'</strong>
            </td>
        </tr>
        ';
        if($listFaculty){
            foreach($fac_list as $fac){
                $data .= '
            <tr>';
                $data .='
                <td width="8%" class="bg-light">
                    '.$fac['fac_abbr'].'
                </td>
                <td width="7%" class="bg-light">
                    '.$fac['course_abbr'].'
                </td>';
                for($i=1; $i<=5; $i++){
                    if(isset($row['option'.$i])){
                        $data .= '
                <td scope="col">
                    <label style="display: block; cursor: pointer;">
                        <input type="radio" name="'.$row['id'].'_'.$fac['fac_abbr'].'_'.$fac['course_abbr'].'_'.$type.'_'.$token.'" value="'.(6-$i).'" style="transform: scale(1.3);">
                            &nbsp;'.$row['option'.$i].'
                    </label>
                </td>
                        ';
                    }
                }
                $data .= '
            </tr>';
            }
        } else {
            $data .= '
            <tr>';
            $data .= '
                <td colspan=2></td>';
            for($i=1; $i<=5; $i++){
                if(isset($row['option'.$i])){
                    $data .= '
                <td scope="col">
                    <label style="display: block; cursor: pointer;">
                        <input type="radio" name="" value="" style="transform: scale(1.3);">
                            &nbsp;'.$row['option'.$i].'
                    </label>
                </td>
                    ';
                }
            }
            $data .= '
        </tr>';
        }
    }
}else{
    $data .= ' 
    <tr>
        <td colspan="6">No Questions to display</td>
    </tr>
    ';
}
$data .= ' 
    </tbody>
</table>';

echo $data;

?>