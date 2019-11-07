<!DOCTYPE html>
<html lang="en">
    <head>
        <?php
            require 'view/header.php';
        ?>
        <title>Home</title>
        <script src="js/home.js"></script>
    </head>
    <body onload="showActive(); showFaculty()">
        <?php
            include 'view/navbar.php';
        ?>
        <div class="container col-10 shadow-lg border rounded m-3 mx-auto p-3">
            <ul class="nav nav-tabs nav-fill" id="myTab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="department-tab" data-toggle="tab" href="#department" role="tab"
                        aria-controls="department" aria-selected="true">
                        Department
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="category-tab" data-toggle="tab" href="#category" role="tab"
                        aria-controls="category" aria-selected="false">
                        Category
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="questions-tab" data-toggle="tab" href="#questions" role="tab"
                        aria-controls="questions" aria-selected="false">
                        Questions
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="load-tab" data-toggle="tab" href="#load" role="tab"
                        aria-controls="load" aria-selected="false">
                        Load distribution
                    </a>
                </li>
            </ul>
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="department" role="tabpanel" aria-labelledby="department-tab">
                    <div class="row justify-content-center">
                        <div class="btn btn-lg btn-info m-3"  data-toggle="collapse" href="#addDeptForm" role="button" aria-expanded="false" aria-controls="addDeptForm">
                            <i class="fas fa-plus"></i>&nbsp;Add
                        </div>
                    </div>
                    <div class="collapse" id="addDeptForm">
                        <div class="card shadow-md mx-auto">
                            <div class="card-body">
                                <form action="?act=add_Dept" method="POST">
                                    <div class="row mx-5">
                                        <div class="form-group col">
                                            <label for="course">Department Name</label>
                                            <input type="text" name="deptName" required="true" id="deptName" class="form-control" placeholder="Enter department name">
                                        </div>
                                        <div class="form-group col">
                                            <label for="uname">Admin Username</label>
                                            <input type="text" name="uname" required="true" id="uname" class="form-control" placeholder="Enter Admin Username">
                                        </div>
                                    </div>
                                    <div class="row mx-5">
                                        <div class="form-group col">
                                            <label for="description">Description</label>
                                            <textarea name="desc" id="desc" class="col border rounded" placeholder="Enter description of department..."></textarea>
                                        </div>
                                        <div class="form-group col">
                                            <label for="password">Admin Password</label>
                                            <input type="password" name="password" required="true" id="password" class="form-control" placeholder="Enter password">
                                        </div>
                                    </div>
                                    <div class="form-group text-center">
                                        <input type="submit" id="addDeptBtn" class="btn btn-success my-2" value="Submit" />
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="row m-3 justify-content-around align-items-center text-center">
                    <?php
                        if ($dm->db->getNoOfRows()) {
                            foreach($dept_data as $dept){
                                echo '
                                    <div class="col-3 m-3">
                                        <div class="card shadow" style="min-height:14em;">
                                            <div class="card-header">
                                                <h3>
                                                    <u>'.$dept['name'].'</u>
                                                </h3>
                                            </div>
                                            <div class="card-body">
                                                '.$dept['description'].'
                                            </div>
                                            <div class="card-footer">
                                                <a href="?act=manage_Dept&dept='.$dept['name'].'" class="btn btn-primary mx-1">
                                                    <i class="far fa-edit"></i>&nbsp;Manage
                                                </a>
                                                <a href="?act=del_Dept&deptName='.$dept['name'].'" class="btn btn-danger mx-1" onclick="return confirm(\'Are you sure you want to delete this?\');">
                                                    <i class="fas fa-trash-alt"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    ';
                            }
                        }
                    ?>
                    </div>
                </div>
                <div class="tab-pane fade" id="category" role="tabpanel" aria-labelledby="category-tab">
                    <div class="row justify-content-center">
                        <div class="btn btn-lg btn-info m-3"  data-toggle="collapse" href="#addCatForm" role="button" aria-expanded="false" aria-controls="addCatForm">
                            <i class="fas fa-plus"></i>&nbsp;Add
                        </div>
                    </div>
                    <div class="collapse" id="addCatForm">
                        <div class="card shadow-md text-center mx-auto">
                            <div class="card-body">
                                <form action="?act=add_Category" method="POST">
                                    <div class="row justify-content-center">
                                        <div class="form-group col-6">
                                            <label for="course">Category Name</label>
                                            <input type="text" name="catName" required="true" id="catName" class="form-control" placeholder="Enter category name">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <input type="submit" id="addCatBtn" class="btn btn-success my-2" value="Submit" />
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="card shadow-md text-center mx-auto">
                        <div class="card-header">
                            <h3>
                                Modify form for:
                            </h3>
                        </div>
                        <div class="card-body">
                            <form action="?act=create_fb" method="POST">
                                <div class="row justify-content-center">
                                    <div class="form-group col-6">
                                        <label for="cat">Category</label>
                                        <select class="form-control" name="cat" id="cat" required>
                                            <option value="" disabled selected hidden>Select Category</option>
                                            <?php
                                                if ($cm->db->getNoOfRows()){
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
                                <div class="form-group">
                                    <input type="submit" id="CatBtn" class="btn btn-success my-2" value="Submit" />
                                </div>
                            </form>
                        </div>
                    </div>                    
                </div>
                <div class="tab-pane fade" id="questions" role="tabpanel" aria-labelledby="questions-tab">
                    ...
                </div>
                <div class="tab-pane fade" id="load" role="tabpanel" aria-labelledby="load-tab">
                    <div class="row justify-content-center">
                        <div class="btn btn-lg btn-info m-3"  data-toggle="collapse" href="#addLoadForm" role="button" aria-expanded="false" aria-controls="addLoadForm">
                            <i class="fas fa-plus"></i>&nbsp;Add
                        </div>
                    </div>
                    <div class="collapse" id="addLoadForm">
                        <div class="card shadow-md text-center mx-auto col-10">
                            <div class="card-body">
                                <form action="?act=add_Load" method="POST">
                                    <div class="row text-left">
                                        <div class="form-group col-4">
                                            <label for="department">Department:</label>
                                            <select class="form-control" name="dept" id="dept" required>
                                                <option value="" disabled selected hidden>Select Department</option>
                                                <?php
                                                if ($dm->db->getNoOfRows()){
                                                    foreach($dept_data as $dept){
                                                        if($dept['type'] != 'A'){
                                                            echo '
                                                    <option value="'.$dept['name'].'">'.$dept['name'].'</option>
                                                            ';
                                                        }
                                                    }
                                                }
                                                ?>
                                            </select>
										</div>
										<div class="form-group col-5">
											<label for="faculty">Faculty:</label>
                                            <input type="text" name="faculty" required="true" id="faculty" class="form-control" placeholder="Enter Faculty name">
                                        </div>
										<div class="form-group col">
											<label for="fac_abbr">Faculty abbreviation:</label>
                                            <input type="text" name="fac_abbr" maxlength="4" required="true" id="fac_abbr" class="form-control" placeholder="Faculty abbr">
                                        </div>
                                        <div class="form-group col-4">
                                            <label for="year">Year:</label>
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
										<div class="form-group col">
											<label for="course_abbr">Course abbreviation:</label>
                                            <input type="text" name="course_abbr" maxlength="5" required="true" id="course_abbr" class="form-control" placeholder="Course abbr">
                                        </div>
                                        <div class="form-group col-4">
                                            <label for="block">Block:</label>
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
                                    <div class="form-group">
                                        <input type="submit" id="addFacBtn" class="btn btn-success my-2" value="Submit" />
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="card text-center">
                        <div class="card-header">
                            <h3>    
                                <u>Added faculties:</u>
                            </h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="form-group col">
                                    <label for="department">Department:</label>
                                    <select class="form-control" name="deptFilter" id="deptFilter" required onchange="showFaculty()">
                                        <option value="" selected>Select Department</option>
                                        <?php
                                        if ($dm->db->getNoOfRows()){
                                            foreach($dept_data as $dept){
                                                if($dept['type'] != 'A'){
                                                    echo '
                                            <option value="'.$dept['name'].'">'.$dept['name'].'</option>
                                                    ';
                                                }
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group col">
                                    <label for="year">Year:</label>
                                    <select class="form-control" name="year" id="yearFilter" onchange="showFaculty()">
                                    <option value="" selected>Select Year</option>
                                        <option value="FY">FY</option>
                                        <option value="SY">SY</option>
                                        <option value="TY">TY</option>
                                        <option value="BE">BE</option>
                                    </select>
                                </div>
                                <div class="form-group col">
                                    <label for="block">Block:</label>
                                    <select class="form-control" name="blockFilter" id="blockFilter" onchange="showFaculty()">
                                    <option value="" selected>Select Block</option>
                                        <option value="B1">B1</option>
                                        <option value="B2">B2</option>
                                        <option value="B3">B3</option>
                                        <option value="B4">B4</option>
                                        <option value="B5">B5</option>
                                        <option value="B6">B6</option>
                                    </select>
                                </div>
                                <div class="form-group col">
                                    <label for="course">Course:</label>
                                    <select class="form-control" name="courseFilter" id="courseFilter" onchange="showFaculty()">
                                        <option value="" selected>Select Course</option>
                                        <?php
                                        if ($ldm->db->getNoOfRows()){
                                            // while($row = $ld_data->fetch_assoc()){
                                            foreach($ld_data as $row){
                                                echo '
                                        <option value="'.$row['course'].'">'.$row['course'].'</option>
                                                ';
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group col">
                                    <label for="type">Type:</label>
                                    <select class="form-control" name="typeFilter" id="typeFilter" onchange="showFaculty()">
                                    <option value="" selected>Select Type</option>
                                        <option value="Theory">Theory</option>
                                        <option value="Lab">Lab</option>
                                    </select>
                                </div>
                            </div>
                            <div id="facultyTable"></div>
						</div>
                    </div>
                </div>
            </div>
        </div>
    </body>
    
</html>
<?php
// $conn->close();
?>