<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "feedback_portal";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$dept = $_GET['dept'];

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>Manage department</title>

    <!-- Our Custom CSS -->

    <!-- FontAwesome kit -->
    <script src="https://kit.fontawesome.com/728d1d3dec.js"></script>
    <!-- jQuery CDN - Slim version (=without AJAX) -->
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <!-- Popper.JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous"></script>
    <!-- Bootstrap CSS CDN -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous" />
    <!-- Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js" integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" crossorigin="anonymous"></script>
</head>

<body onload="showFaculty()">
    <div class="container col-10 shadow-lg border rounded m-3 mx-auto p-3">
        <div class="card">
            <div class="card-header">
                <?php
                $qry = "SELECT * FROM department WHERE name='$dept'";
                $res = $conn->query($qry);
                if ($res->num_rows > 0){
                    $row = $res->fetch_assoc();
                    echo '
                <div class="row">
                    <div class="col-3 text-info">
                        <h2>
                            <u id="dept">'.$row['name'].'</u>
                        </h2>
                    </div>
                    <div class="col-1" style="border-left: 1px solid #9b9b9b;margin: 0 1em;"></div>
                    <div class="col text-secondary">
                        <h4>
                            '.$row['description'].'
                        </h4>
                    </div>
                </div>
                    ';
                }
                ?>
                
                <a href="./index.php" class="btn btn-primary m-1" style="position:absolute; top:10px; right:10px;">
                    <i class="fas fa-home"></i>&nbsp;
                    Home
                </a>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-2">
                        <div class="list-group sticky-top" id="list-tab" role="tablist">
                            <a class="list-group-item list-group-item-action active" id="list-form-list" 
                                data-toggle="list" href="#list-form" role="tab" aria-controls="form">
                                Generate form
                            </a>
                            <a class="list-group-item list-group-item-action" id="list-results-list" 
                                data-toggle="list" href="#list-results" role="tab" aria-controls="results">
                                Results
                            </a>
                        </div>
                    </div>
                    <div class="col">
                        <div class="tab-content" id="nav-tabContent">
                            <div class="tab-pane fade show active" id="list-form" role="tabpanel"
                                aria-labelledby="list-form-list">
                                <div class="card">
                                    <div class="card-body">
                                        <form action="" method="POST">
                                            <?php
                                            echo '
                                            <input type="hidden" name="dept" id="dept" value="'.$dept.'">
                                            ';
                                            ?>
                                            <div class="row justify-content-center">
                                                <div class="form-group col-6">
                                                    <label for="cat">Category:</label>
                                                    <select class="form-control" name="cat" id="cat" onchange="showForm()" required>
                                                        <option value="" hidden disabled selected>Select category</option>
                                                        <?php
                                                        $qry = "SELECT * FROM category_list";
                                                        $res = $conn->query($qry);
                                                        if ($res->num_rows > 0){
                                                            while($cat = $res->fetch_assoc()){
                                                                echo '
                                                        <option value="'.$cat['name'].'">'.$cat['name'].'</option>
                                                                ';
                                                            }
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row justify-content-center border rounded m-2" id="facultyTable">
                                            </div>
                                            <div class="justify-content-center d-none" id="formTab">
                                                <ul class="nav nav-tabs nav-fill" role="tablist">
                                                    <li class="nav-item">
                                                        <a class="nav-link active" id="theory-tab" data-toggle="tab" href="#theory" role="tab"
                                                            aria-controls="theory" aria-selected="true">
                                                            <h4><u>Theory</u></h4>
                                                        </a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a class="nav-link" id="lab-tab" data-toggle="tab" href="#lab" role="tab"
                                                            aria-controls="lab" aria-selected="false">
                                                            <h4><u>Lab</u></h4>
                                                        </a>
                                                    </li>
                                                </ul>
                                                <div class="tab-content" id="myTabContent">
                                                    <div class="tab-pane fade show active" id="theory" role="tabpanel" aria-labelledby="theory-tab">
                                                    </div>
                                                    <div class="tab-pane fade" id="lab" role="tabpanel" aria-labelledby="lab-tab">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group text-center">
                                                <input type="submit" id="addDeptBtn" class="btn btn-success" value="Submit" />
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="list-results" role="tabpanel" 
                                aria-labelledby="list-results-list">
                                ...
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
<script>
    function showForm(){
        var cat = $("#cat").val();
        var dept = "<?php echo $dept;?>";
        $.get("getForm.php", data={category: cat, department: dept, type: 'theory'}, function(data, status){
            $("#theory").html(data);
        });
        $.get("getForm.php", data={category: cat, department: dept, type: 'lab'}, function(data, status){
            $("#lab").html(data);
        });

        $("#formTab").removeClass("d-none");

        if(cat != 'Student'){
            $("#year").prop('disabled', true);
            $("#block").prop('disabled', true);
            $("#facultyTable").hide();
        }else{
            $("#year").prop('disabled', false);
            $("#block").prop('disabled', false);
            $("#facultyTable").show();
        }
    }

    function showFaculty(){
        var department = "<?php echo $dept; ?>";
        
        $.get("getFaculty.php", data={department: department}, function(data, status){
            $("#facultyTable").html(data);
        });
    }
</script>

</html>