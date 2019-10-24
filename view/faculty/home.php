<?php
    if(!isset($_SESSION))
        session_start();
    if(!isset($_SESSION['user'])){
        header('Location: index.php?act=login');
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php
        require_once 'view/header.php';
    ?>

    <title>Department</title>

    <!-- Our Custom CSS -->
    <!-- Our Custom Js -->
    <script>
        function showForm(){
            var cat = $("#cat").val();
            var dept = "<?php echo $deptName;?>";
            $.get("model/getForm.php", data={category: cat, department: dept, type: 'theory'}, function(data, status){
                $("#theoryQns").html(data);
            });
            $.get("model/getForm.php", data={category: cat, department: dept, type: 'lab'}, function(data, status){
                $("#labQns").html(data);
            });
            $("#formTab").removeClass("d-none");
        }

        function showFaculty(){
            var department = "<?php echo $deptName; ?>";
            $.get("model/getFaculty.php", data={modify: "yes", department: department}, function(data, status){
                $("#facultyTable").html(data);
            });
        }

        $(document).on('click','#edit',function(){
            var formElement = `
            <form action="?act=update_Load&mode=edit" method="POST" id="editForm">
                <input type="hidden" name="department" value="`+'<?php echo $deptName;?>'+`" />
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
                var dept = "<?php echo $deptName;?>";
                $.post("model/faculty/updateLoad.php?mode=delete", data={department:dept, arr:arr}, function(data, status){
                    // alert("Record deleted successfully");
                    alert(data);
                });
                // window.location.reload();
                showFaculty();
            }
        });

    </script>
    

</head>

<body onload="showFaculty()">
    <?php
        include 'view/navbar.php';
    ?>
    <div class="container col-10 shadow-lg border rounded m-3 mx-auto p-3">
        <div class="card">
            <div class="card-header">
                <?php
                if($dept_data && count($dept_data)){
                    $row = $dept_data[0];
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
                                                    if($cat_data && count($cat_data)){
                                                        foreach($cat_data as $cat){
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
                                                    <form action="?act=add_Load" method="POST">
                                                        <?php
                                                            echo '<input type="hidden" name="dept" value="'.$deptName.'" id="deptName" class="form-control">';
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

</html>