<?php

$dept = $_GET['dept'];
$year = $_GET['year'];
$block = $_GET['block'];

require '../core/db.php';
$db = new DB();

require 'load_dist_model.php';
$ldm = new LoadDistributionModel($db);
$ldm_data = $ldm->enlistLoadDistribution([], ["dept='$dept'", "year='$year'", "block='$block'"], ["fac_abbr"]);
$types = ['Theory', 'Lab'];

require 'response_model.php';
$rm = new ResponseModel($db);


if(!$ldm_data){
    echo "No data available";
}else{
    foreach($ldm_data as $c=>$fac_data){
        for($a=0; $a<2; $a++){
            $type = $types[$a];
            $rm_qn_count = intval(($rm->enlistResponse(["count(distinct(qid))"], ["type='$type'"]))[0]['count(distinct(qid))']);
            // var_dump($rm_qn_count);
            $rm_data = $rm->enlistResponse(["*", "count(score) as score_count"],
                                    ["faculty='$fac_data[fac_abbr]'", "type='$type'", "dept='$dept'", "year='$year'", "block='$block'"],
                                    ["qid", "score"], ["qid ASC", "score DESC"]);
            if($rm_data){
                $data = '
    <table class="table-result table table-sm table-bordered table-hover table-striped text-center" id="'.$fac_data['dept'].'_'.$fac_data['year'].'_'.$fac_data['block'].'_'.$fac_data['fac_abbr'].'_'.$fac_data['course_abbr'].'_'.$type.'">
        <thead class="table-info">
            <tr>
                <th colspan="50" class="table-warning">
                    <strong>'.$fac_data['dept'].'_'.$fac_data['year'].'_'.$fac_data['block'].'_'.$fac_data['fac_abbr'].'_'.$fac_data['course_abbr'].'_'.$type.'</strong>
                </th>
            </tr>
            <tr>
                <th>
                    <button class="btn bg-light text-primary">
                        <strong>Question no.</strong>
                    </button>
                </th>';
                for($i=1; $i<=5; $i++){
                    $data .= '
                <th>
                    <button class="btn bg-light text-primary">
                        Option '.$i.'
                    </button>
                </th>';
                }
                $data .= '
                <th>
                    <button class="btn bg-success text-light">
                        <strong>Score</strong>
                    </button>
                </th>
            </tr>
        </thead>
        <tbody>';
        
                // var_dump(count($rm_data));
                $avg = 0;
                for($i=1; $i<=$rm_qn_count; $i++){
                    $x = 5;
                    $j = 0;
                    $ctr = 1;
                    $total = 0;
                    $stu_ctr = 0;
                    $data .= '
            <tr>
                <td><strong>'.$i.'</strong></td>';
                    while($j < count($rm_data)){
                        if($rm_data[$j]['qid'] == $i){
                            if($rm_data[$j]['score'] == $x){
                                $data .= '
                <td>'.$rm_data[$j]['score_count'].'</td>';
                                $stu_ctr += $rm_data[$j]['score_count'];
                                $total += $rm_data[$j]['score']*$rm_data[$j]['score_count']/5;
                            }else{
                                $j -= 1;
                                $data .= '
                                <td>0</td>';
                            }
                            $x -= 1;
                            $ctr += 1;
                        }
                        $j += 1;
                    }
                    for($k=$ctr;$k<=5;$k++){
                        $data .= '
                <td>-</td>';
                    }
                    $avg += $total/$stu_ctr;
                    $data .= '
                <td class="table-primary">'.round($total/$stu_ctr, 2).'</td>
            </tr>';
                }
                $avg = round($avg/$rm_qn_count, 2);
                $data .= '
            <tr>
                <td colspan="6"><strong>Average:</strong></td>
                <td class="table-success"><strong>'.$avg.'</strong></td>
            </tr>
        </tbody>
    </table>';
                echo $data;
            }
        }
    }
}
    
?>


<?php
// /* Tables for each faculty w/o options data */

// $dept = $_GET['dept'];
// $year = $_GET['year'];
// $block = $_GET['block'];

// require '../core/db.php';
// $db = new DB();

// require 'load_dist_model.php';
// $ldm = new LoadDistributionModel($db);
// $ldm_data = $ldm->enlistLoadDistribution([], ["dept='$dept'", "year='$year'", "block='$block'"], ["fac_abbr"]);
// $types = ['Theory', 'Lab'];

// require 'response_model.php';
// $rm = new ResponseModel($db);
// $rm_qn_count = $rm->enlistResponse(["count(distinct(qid))"]);
// $rm_qn_count = intval($rm_qn_count[0]['count(distinct(qid))']);

// if(!$ldm_data){
//     echo "No data available";
// }else{
//     foreach($ldm_data as $c=>$fac_data){
//         $data = '
//     <table class="table table-sm table-bordered table-hover table-striped text-center" id="'.$fac_data['fac_abbr'].'_'.$fac_data['course_abbr'].'_'.$fac_data['type'].'">
//         <thead class="table-info">
            
//             <tr>
//                 <th scope="col">
//                     <button class="btn bg-light text-primary">
//                         <strong>Name</strong>
//                     </button>
//                 </th>
//                 <th scope="col">
//                     <button class="btn bg-light text-primary">
//                         <strong>Course / Type</strong>
//                     </button>
//                 </th>
//                 ';
//         for($i=1; $i<=$rm_qn_count; $i++){
//             $data .= '
//                 <th scope="col">
//                     <button class="btn bg-light text-primary">
//                         <strong>Qn '.$i.'</strong>
//                     </button>
//                 </th>';
//         }   
//         $data .= '
//                 <th scope="col">
//                     <button class="btn bg-success text-light">
//                         <strong>Avg</strong>
//                     </button>
//                 </th>';
//         $data .= '
//             </tr>
//         </thead>
//         <tbody>';
//         for($x=0; $x<2; $x++){
//             $type = $types[$x];
//             $rm_data = $rm->enlistResponse(["*", "sum(score) as score_sum", "count(qid) as qid_total"],
//                                     ["faculty='$fac_data[fac_abbr]'", "type='$type'", "dept='$dept'", "year='$year'", "block='$block'"],
//                                     ["qid"]);
//             if($rm_data){
//                 $total = 0;
//                 $ctr = 0;
//                 $data .= '
//             <tr>
//                 <td>'.$fac_data['fac_abbr'].'</td>
//                 <td>'.$rm_data[0]['course'].' / '.$type.'</td>
//                 ';
//                 foreach($rm_data as $fac_fb){
//                     $total += $fac_fb['score_sum']/($fac_fb['qid_total']*5);
//                     $data .= '
//                 <td>'.round($fac_fb['score_sum']/($fac_fb['qid_total']*5), 2).'</td>';
//                     $ctr += 1;
//                 }
//                 for($i=$ctr; $i<$rm_qn_count; $i++){
//                     $data .= '
//                 <td></td>';
//                 }
//                 $data .= '
//                 <td class="table-success">'.round($total/$ctr, 2).'</td>
//             </tr>
//             ';
//             }
//         }
//         echo $data;
//     }
// }

?>


<?php
// /* All faculty data in 1 table */

// $dept = $_GET['dept'];
// $year = $_GET['year'];
// $block = $_GET['block'];

// require '../core/db.php';
// $db = new DB();

// require 'load_dist_model.php';
// $ldm = new LoadDistributionModel($db);
// $ldm_data = $ldm->enlistLoadDistribution(["fac_abbr", "course_abbr", "type"], ["dept='$dept'", "year='$year'", "block='$block'"]);

// require 'response_model.php';
// $rm = new ResponseModel($db);
// $rm_qn_count = $rm->enlistResponse(["count(distinct(qid))"], []);
// $rm_qn_count = intval($rm_qn_count[0]['count(distinct(qid))']);


// if(!$ldm_data){
//     echo "No data available";
// }else{
//     $data = '
//     <table class="table table-sm table-bordered table-hover table-striped text-center">
//         <thead class="table-info">
//             <tr class="table-warning">
//                 <th colspan="2"><h4>Faculty</h4></th>
//                 <th colspan="50"><h4>Scores</h4></th>
//             </tr>
//             <tr>
//                 <th scope="col">
//                     <button class="btn bg-light text-primary">
//                         <strong>Name</strong>
//                     </button>
//                 </th>
//                 <th scope="col">
//                     <button class="btn bg-light text-primary">
//                         <strong>Course / Type</strong>
//                     </button>
//                 </th>
//                 ';
//     for($i=1; $i<=$rm_qn_count; $i++){
//         $data .= '
//                 <th scope="col">
//                     <button class="btn bg-light text-primary">
//                         <strong>Qn '.$i.'</strong>
//                     </button>
//                 </th>';
//     }   
//     $data .= '
//                 <th scope="col">
//                     <button class="btn bg-success text-light">
//                         <strong>Avg</strong>
//                     </button>
//                 </th>';
//     $data .= '
//             </tr>
//         </thead>
//         <tbody>';
//     foreach($ldm_data as $fac_data){
//         $rm_data = $rm->enlistResponse(["*", "sum(score) as score_sum", "count(qid) as qid_total"],
//                                     ["faculty='$fac_data[fac_abbr]'", "type='$fac_data[type]'", "dept='$dept'", "year='$year'", "block='$block'"],
//                                     ["qid"]);
//         $total = 0;
//         $ctr = 0;
//         $data .= '
//             <tr>
//                 <td>'.$fac_data['fac_abbr'].'</td>
//                 <td>'.$fac_data['course_abbr'].' / '.$fac_data['type'].'</td>
//                 ';
//         foreach($rm_data as $fac_fb){
//             $total += $fac_fb['score_sum']/($fac_fb['qid_total']*5);
//             $data .= '
//                 <td>'.$fac_fb['score_sum']/($fac_fb['qid_total']*5).'</td>';
//             $ctr += 1;
//         }
//         for($i=$ctr; $i<$rm_qn_count; $i++){
//             $data .= '
//                 <td></td>';
//         }
//         $data .= '
//                 <td class="table-success">'.($total/$ctr).'</td>
//             </tr>
//         ';
//     }
//         echo $data;
// }
?>