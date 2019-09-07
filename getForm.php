<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "feedback_portal";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$cat = $_GET['category'];
$type = $_GET['type'];
if(isset($_GET['token'])){
    $token = $_GET['token'];
}else{
    $token = "";
}

$conditions = "";
if(isset($_GET['department']))
    $conditions .= "dept='" . $_GET['department'] .= "'";
if(isset($_GET['year']))
    $conditions .= " AND year='" . $_GET['year'] .= "'";
if(isset($_GET['block']))
    $conditions .= " AND block='" . $_GET['block'] .= "'";
if(isset($_GET['type']))
    $conditions .= " AND type='" . $_GET['type'] .= "'";
// echo $conditions;

$fac_list = $conn->query(
                    "SELECT * FROM load_distribution
                    WHERE $conditions"
                    );
$fac_list = $fac_list->fetch_all();


$qry = "SELECT * FROM questions
        WHERE category='$cat' AND type='$type'
        ORDER BY id";
// echo $qry;

$res = $conn->query($qry);

$data = '
<table class="table table-hover table-responsive-sm table-bordered">
    <tbody>';
if($res->num_rows > 0){
    while($row = $res->fetch_assoc()){
        $data .= '
        <tr>
            <td colspan="2"></td>
            <td colspan="5" scope="row" class="bg-light">
                <strong>'.$row['question'].'</strong>
            </td>
        </tr>
        ';
        foreach($fac_list as $fac){
            $data .= '
        <tr>';
            $data .='
            <td width="8%" class="bg-light">
                '.$fac[4].'
            </td>
            <td width="7%" class="bg-light">
                '.$fac[6].'
            </td>';
            for($i=1; $i<=5; $i++){
                if(isset($row['option'.$i])){
                    $data .= '
                    <td scope="col">
                        <input type="radio" name="'.$row['id'].'_'.$fac[4].'_'.$fac[6].'_'.$type.'_'.$token.'" value="'.(6-$i).'" style="transform: scale(1.3);">
                            &nbsp;'.$row['option'.$i].'
                    </td>';
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
