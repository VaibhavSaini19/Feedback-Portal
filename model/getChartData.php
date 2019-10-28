<?php

    $dept = $_GET['dept'];
    $year = $_GET['year'];
    $filterBy = $_GET['filterBy'];

    require '../core/db.php';
    $db = new DB();
    require '../model/response_model.php';
    $rm = new ResponseModel($db);

    if($filterBy == 'block'){
        $titles = array();
        $data = array();
        require '../model/load_dist_model.php';
        $ldm = new LoadDistributionModel($db);
        $block_list = $ldm->enlistLoadDistribution(["distinct(block)"], ["dept='$dept'", "year='$year'"], [], ["block"]);
        foreach($block_list as $block_data){
            $arr = array();
            $block = $block_data['block'];
            array_push($titles, $block);
            $result = $rm->enlistResponse(["*", "sum(score) as score_sum", "count(token) as token_ctr"],
                                        ["dept='$dept'", "year='$year'", "block='$block'"],
                                        ["qid"]);
            if($result){
                foreach($result as $row){;
                    array_push($arr, array("x"=> $row['qid'], "y"=> round($row['score_sum']/($row['token_ctr']*5), 2)));
                }
            }
            array_push($data, $arr);
        }
        array_unshift($data, $titles);
        $data = json_encode($data ,JSON_NUMERIC_CHECK);
        echo $data;
    }
    if($filterBy == 'subject'){
        $titles = array();
        $data = array();
        require '../model/load_dist_model.php';
        $ldm = new LoadDistributionModel($db);
        $course_list = $ldm->enlistLoadDistribution(["distinct(course_abbr)"], ["dept='$dept'", "year='$year'"]);
        foreach($course_list as $course_data){
            $arr = array();
            $course = $course_data['course_abbr'];
            array_push($titles, $course);
            $result = $rm->enlistResponse(["*", "sum(score) as score_sum", "count(token) as token_ctr"],
                                        ["dept='$dept'", "year='$year'", "course='$course'"],
                                        ["qid"]);
            if($result){
                foreach($result as $row){;
                    array_push($arr, array("x"=> $row['qid'], "y"=> round($row['score_sum']/($row['token_ctr']*5), 2)));
                }
            }
            array_push($data, $arr);
        }
        array_unshift($data, $titles);
        $data = json_encode($data ,JSON_NUMERIC_CHECK);
        echo $data;
    }
    if($filterBy == 'question'){
        $titles = array();
        $data = array();
        require '../model/qns_model.php';
        $qm = new QuestionsModel($db);
        $qns_list = $qm->enlistQuestions([], [], [], ["id"]);
        foreach($qns_list as $qns_data){
            $arr = array();
            $qid = $qns_data['id'];
            $qn = $qns_data['question'];
            $type = $qns_data['type'];
            array_push($titles, ucfirst($type).' '.$qn);
            $result = $rm->enlistResponse(["*", "sum(score) as score_sum", "count(token) as token_ctr"],
                                        ["dept='$dept'", "year='$year'", "type='$type'", "qid='$qid'"],
                                        ["score"]);
            if($result){
                $remaining = ["1", "2", "3", "4", "5"];
                foreach($result as $row){;
                    array_push($arr, array("x"=> $row['score'], "y"=> $row['token_ctr']));
                    unset($remaining[array_search($row['score'], $remaining)]);
                }
            }
            foreach($remaining as $ele){
                array_push($arr, array("x"=> $ele, "y"=> 0));
            }
            usort($arr, function($a, $b) { return $a["x"] > $b["x"];});
            array_push($data, $arr);
        }
        array_unshift($data, $titles);
        $data = json_encode($data ,JSON_NUMERIC_CHECK);
        echo $data;
    }
    
?>

