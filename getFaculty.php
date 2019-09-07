<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "feedback_portal";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$dept = $_GET['department'];

$data = '
<table class="table table-sm table-bordered table-hover table-striped text-center">
    <thead class="table-success">
        <tr>
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
            <th scope="col">
                <button class="btn bg-light text-primary">
                    <strong>Modify</strong>
                </button>
            </th>
        </tr>
    </thead>
    <tbody>';


$qry = "SELECT * FROM load_distribution
        WHERE dept='$dept'";
// echo $qry;
$res = $conn->query($qry);

if ($res->num_rows > 0)
{
    while($row = $res->fetch_assoc())
    {
        $data .= '
        <tr>
            <td>'.$row['year'].'</td>
            <td>'.$row['block'].'</td>
            <td>'.$row['faculty'].'</td>
            <td>'.$row['course'].'</td>
            <td>'.$row['type'].'</td>
            <td>
                <span id="edit" class="far fa-edit" style="cursor: pointer;"></span>&emsp;
                <span id="delete" class="fas fa-trash" style="cursor: pointer;"></span>
            </td>
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