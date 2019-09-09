<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "feedback_portal";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// $dept = $_POST['dept'];
$dept = $_GET['dept'];

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>Department</title>

    <!-- Our Custom CSS -->

    <!-- FontAwesome kit -->
    <script src="https://kit.fontawesome.com/728d1d3dec.js"></script>
    <!-- jQuery CDN -->
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
                $qry = "SELECT name, description FROM department WHERE name='$dept'";
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
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-2">
                        <div class="list-group sticky-top" id="list-tab" role="tablist">
                            <a class="list-group-item list-group-item-action active" id="list-form-list" 
                                data-toggle="list" href="#list-form" role="tab" aria-controls="form">
                                Manage Faculty & Forms
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
                                    <div class="card-body justify-content-center">
                                        <div class="row text-center">
                                            <div class="form-group col-6">
                                                <label for="cat">Form Category:</label>
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
                                            <div class="form-group col-6">
                                                <label for=""></label>
                                                <div class="mt-2">
                                                    <button class="btn btn-sm btn-info"  data-toggle="collapse" href="#addFacultyForm" role="button" aria-expanded="false" aria-controls="addFacultyForm">
                                                        <i class="fas fa-plus"></i>&nbsp;Add faculty
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="collapse" id="addFacultyForm">
                                            <div class="card shadow-md mx-auto">
                                                <div class="card-body">
                                                    <form action="./addLoad.php" method="POST">
                                                        <?php
                                                            echo '<input type="hidden" name="dept" value="'.$dept.'" id="deptName" class="form-control">';
                                                        ?>
                                                        <div class="row text-left">
                                                            <div class="form-group col-5">
                                                                <label for="faculty">Faculty:</label>
                                                                <input type="text" name="faculty" required="true" id="faculty" class="form-control" placeholder="Enter Faculty name">
                                                            </div>
                                                            <div class="form-group col-4">
                                                                <label for="fac_abbr">Faculty abbreviation:</label>
                                                                <input type="text" name="fac_abbr" maxlength="4" required="true" id="fac_abbr" class="form-control" placeholder="Faculty abbr">
                                                            </div>
                                                            <div class="form-group col-3">
                                                                <label for="course">Year:</label>
                                                                <select class="form-control" name="year" id="year" required>
                                                                <option value="" disabled selected hidden>Select Year</option>
                                                                    <option value="FY">FY</option>
                                                                    <option value="SY">SY</option>
                                                                    <option value="TY">TY</option>
                                                                    <option value="BE">BE</option>
                                                                </select>
                                                            </div>
                                                            <div class="form-group col-5">
                                                                <label for="course">Course:</label>
                                                                <input type="text" name="course" required="true" id="course" class="form-control" placeholder="Enter Course name">
                                                            </div>
                                                            <div class="form-group col-4">
                                                                <label for="course_abbr">Course abbreviation:</label>
                                                                <input type="text" name="course_abbr" maxlength="5" required="true" id="course_abbr" class="form-control" placeholder="Course abbr">
                                                            </div>
                                                            <div class="form-group col-3">
                                                                <label for="course">Block:</label>
                                                                <select class="form-control" name="block" id="block" required>
                                                                    <option value="" disabled selected hidden>Select Block</option>
                                                                    <option value="B1">B1</option>
                                                                    <option value="B2">B2</option>
                                                                    <option value="B3">B3</option>
                                                                    <option value="B4">B4</option>
                                                                    <option value="B5">B5</option>
                                                                    <option value="B6">B6</option>
                                                                </select>
                                                            </div>
                                                            <div class="form-group col">
                                                                <label for="course_type">Course type:</label>
                                                                <div class="row justicy-content-center align-items-center">
                                                                    <input type="radio" name="course_type" required value="Theory"class="mx-3" style="transform: scale(1.5);" id="theory" placeholder="Course abbr">Theory
                                                                    <input type="radio" name="course_type" required value="Lab"class="mx-3" style="transform: scale(1.5);" id="lab" placeholder="Course abbr">Lab
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group text-center">
                                                            <input type="submit" id="addFacultyBtn" class="btn btn-success" value="Submit" />
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row justify-content-center border rounded m-2" id="facultyTable">
                                        </div>
                                        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="myModalLabel">Update Faculty</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancle</button>
                                                        <button type="submit" form="editForm" class="btn btn-primary">Save</button>
                                                    </div>
                                                </div>
                                            </div>
                                            </div>
                                        <div class="justify-content-center d-none" id="formTab">
                                            <ul class="nav nav-tabs nav-fill" role="tablist">
                                                <li class="nav-item">
                                                    <a class="nav-link active" id="theory-tab" data-toggle="tab" href="#theoryQns" role="tab"
                                                        aria-controls="theory" aria-selected="true">
                                                        <h4><u>Theory</u></h4>
                                                    </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link" id="lab-tab" data-toggle="tab" href="#labQns" role="tab"
                                                        aria-controls="lab" aria-selected="false">
                                                        <h4><u>Lab</u></h4>
                                                    </a>
                                                </li>
                                            </ul>
                                            <div class="tab-content" id="myTabContent">
                                                <div class="tab-pane fade show active" id="theoryQns" role="tabpanel" aria-labelledby="theory-tab">
                                                </div>
                                                <div class="tab-pane fade" id="labQns" role="tabpanel" aria-labelledby="lab-tab">
                                                </div>
                                            </div>
                                        </div>
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
            $("#theoryQns").html(data);
        });
        $.get("getForm.php", data={category: cat, department: dept, type: 'lab'}, function(data, status){
            $("#labQns").html(data);
        });

        $("#formTab").removeClass("d-none");
    }

    function showFaculty(){
        var department = "<?php echo $dept; ?>";
        $.get("getFaculty.php", data={modify: "yes", department: department}, function(data, status){
            $("#facultyTable").html(data);
        });
    }

    $(document).on('click','#edit',function(){
        var formElement = `
        <form action="updateFaculty.php?mode=edit" method="POST" id="editForm">
            <input type="hidden" name="department" value="`+'<?php echo $dept;?>'+`" />
            <input type="hidden" name="facultyOld" value="`+$(this).closest("tr").find("td:eq(2)").html()+`" />
            <label for="faculty">Faculty name:</label>
            <input type="text" name="facultyNew" required="true" id="faculty" class="form-control"  
                placeholder="Enter Faculty name" value="`+$(this).closest("tr").find("td:eq(2)").html()+`">
        </form>`;
        $(".modal-body").html(formElement);
        $("#myModal").modal("toggle");
    });

    $(document).on('click','#delete',function(){
        if(confirm("Are you sure you want to delete this record?")==true){
            var arr = [];
            for(var i=0; i<5; i++){
                arr.push($(this).closest("tr").find("td:eq("+i+")").html());
            }
            arr = arr.join(",");
            var dept = "<?php echo $dept;?>";
            $.post("updateFaculty.php?mode=delete", data={department:dept, arr:arr}, function(data, status){
                // alert("Record deleted successfully");
                alert(data);
            });
            // window.location.reload();
            showFaculty();
        }
    });

</script>

</html>