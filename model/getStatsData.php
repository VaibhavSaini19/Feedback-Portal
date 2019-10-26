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
$rm_qn_count = $rm->enlistResponse(["count(distinct(qid))"]);
$rm_qn_count = intval($rm_qn_count[0]['count(distinct(qid))']);

if(!$ldm_data){
    echo "No data available";
}else{
    foreach($ldm_data as $c=>$fac_data){
        $data = '
    <table class="table table-sm table-bordered table-hover table-striped text-center" id="'.$fac_data['fac_abbr'].'_'.$fac_data['course_abbr'].'_'.$fac_data['type'].'">
        <thead class="table-info">
            
            <tr>
                <th scope="col">
                    <button class="btn bg-light text-primary">
                        <strong>Name</strong>
                    </button>
                </th>
                <th scope="col">
                    <button class="btn bg-light text-primary">
                        <strong>Course / Type</strong>
                    </button>
                </th>
                ';
        for($i=1; $i<=$rm_qn_count; $i++){
            $data .= '
                <th scope="col">
                    <button class="btn bg-light text-primary">
                        <strong>Qn '.$i.'</strong>
                    </button>
                </th>';
        }   
        $data .= '
                <th scope="col">
                    <button class="btn bg-success text-light">
                        <strong>Avg</strong>
                    </button>
                </th>';
        $data .= '
            </tr>
        </thead>
        <tbody>';

        for($x=0; $x<2; $x++){
            $type = $types[$x];
            $rm_data = $rm->enlistResponse(["*", "sum(score) as score_sum", "count(qid) as qid_total"],
                                    ["faculty='$fac_data[fac_abbr]'", "type='$type'", "dept='$dept'", "year='$year'", "block='$block'"],
                                    ["qid"]);
            if($rm_data){
                $total = 0;
                $ctr = 0;
                $data .= '
            <tr>
                <td>'.$fac_data['fac_abbr'].'</td>
                <td>'.$rm_data[0]['course'].' / '.$type.'</td>
                ';
                foreach($rm_data as $fac_fb){
                    $total += $fac_fb['score_sum']/($fac_fb['qid_total']*5);
                    $data .= '
                <td>'.round($fac_fb['score_sum']/($fac_fb['qid_total']*5), 2).'</td>';
                    $ctr += 1;
                }
                for($i=$ctr; $i<$rm_qn_count; $i++){
                    $data .= '
                <td></td>';
                }
                $data .= '
                <td class="table-success">'.round($total/$ctr, 2).'</td>
            </tr>
            ';
            }
        }
        echo $data;
    }
}

?>


<?php

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