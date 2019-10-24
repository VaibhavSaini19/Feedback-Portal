<?php
    if(!isset($_SESSION))
        session_start();
    if($_SESSION['user']['type']!='A'){
        header('Location: index.php?act=login');
    }

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php
        require 'view/header.php';
    ?>
    <title>Manage Department</title>

    <!-- Our Custom CSS -->
    <!-- Our Custom Js -->
    <script>
        function showForm(){
            var cat = $("#cat").val();
            var dept = "<?php echo $deptName;?>";
            $.get("model/getForm.php", data={category: cat, department: dept, type: 'theory'}, function(data, status){
                $("#theory").html(data);
            });
            $.get("model/getForm.php", data={category: cat, department: dept, type: 'lab'}, function(data, status){
                $("#lab").html(data);
            });

            $("#formTab").removeClass("d-none");
        }

        function showFaculty(){
            var department = "<?php echo $deptName; ?>";
            $.get("model/getFaculty.php", data={modify: "no", department: department}, function(data, status){
                $("#facultyTable").html(data);
            });
        }
    </script>

</head>

<body onload="showFaculty()">
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
                ?><a href="./index.php" class="btn btn-primary m-1" style="position:absolute; top:10px; right:10px;">
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
                            Faculty & form
                        </a>
                        <a class="list-group-item list-group-item-action" id="list-results-list" 
                            data-toggle="list" href="#list-results" role="tab" aria-controls="results">
                            Results
                        </a>
                        <a class="list-group-item list-group-item-action" id="list-results-list" 
                            data-toggle="list" href="#list-edit" role="tab" aria-controls="edit">
                            Edit Dept. info
                        </a>
                    </div>
                </div>
                <div class="col">
                    <div class="tab-content" id="nav-tabContent">
                        <div class="tab-pane fade show active" id="list-form" role="tabpanel"
                            aria-labelledby="list-form-list">
                            <div class="card">
                                <div class="card-body">
                                    <?php
                                    echo '
                                    <input type="hidden" name="dept" id="dept" value="'.$deptName.'">
                                    ';
                                    ?>
                                    <div class="row justify-content-center">
                                        <div class="form-group col-6">
                                            <label for="cat">Form Category:</label>
                                            <select class="form-control" name="cat" id="cat" onchange="showForm()" required>
                                                <option value="" hidden disabled selected>Select category</option>
                                                <?php
                                                if ($cat_data && count($cat_data)){
                                                    foreach($cat_data as $cat){
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
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="list-results" role="tabpanel" 
                            aria-labelledby="list-results-list">
                            <div class="card">
                                <div class="card-body"></div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="list-edit" role="tabpanel" 
                            aria-labelledby="list-edit-list">
                            <div class="card">
                                <div class="card-body">
                                    <?php
                                        $res = $dept_data[0];
                                    ?>
                                    <form action="?act=update_Dept" method="POST">
                                        <input type="hidden" name="deptOld" id="deptOld" value="<?php echo $res['name'] ?>">
                                        <input type="hidden" name="unameOld" id="unameOld" value="<?php echo $res['admin'] ?>">
                                        <div class="row mx-5">
                                            <div class="form-group col">
                                                <label for="course">Department Name</label>
                                                <input type="text" name="deptNew" value="<?php echo $res['name'] ?>" required="true" id="deptName" class="form-control" placeholder="Enter department name">
                                            </div>
                                            <div class="form-group col">
                                                <label for="uname">Admin Username</label>
                                                <input type="text" name="unameNew" value="<?php echo $res['admin'] ?>" required="true" id="uname" class="form-control" placeholder="Enter Admin Username">
                                            </div>
                                        </div>
                                        <div class="row mx-5">
                                            <div class="form-group col">
                                                <label for="description">Description</label>
                                                <textarea name="desc" id="desc" class="col border rounded" placeholder="Enter description of department..."><?php echo $res['description'] ?></textarea>
                                            </div>
                                            <div class="form-group col">
                                                <label for="password">Admin Password</label>
                                                <input type="password" name="password" required="true" id="password" class="form-control" placeholder="Enter New password">
                                            </div>
                                        </div>
                                        <div class="form-group text-center">
                                            <input type="submit" id="updateDeptBtn" class="btn btn-success" value="Update" />
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>

</html>