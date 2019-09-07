<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "feedback_portal";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta http-equiv="X-UA-Compatible" content="ie=edge" />
        <title>Home</title>

        <!-- Our Custom CSS -->

        <!-- FontAwesome kit -->
        <script src="https://kit.fontawesome.com/728d1d3dec.js"></script>
        <!-- jQuery CDN - Slim version (=without AJAX) -->
        <script
            src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
            integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
            crossorigin="anonymous"
        ></script>
        <!-- Popper.JS -->
        <script
            src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"
            integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ"
            crossorigin="anonymous"
        ></script>
        <!-- Bootstrap CSS CDN -->
        <link
            rel="stylesheet"
            href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css"
            integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4"
            crossorigin="anonymous"
        />
        <!-- Bootstrap JS -->
        <script
            src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js"
            integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm"
            crossorigin="anonymous"
        ></script>

        
        <script>
            function showActive(){
                var url = (window.location.href).toString();
                var tag = url.split("#")[1];
                // alert(tag);
                if(tag){
                    $(".nav-link").removeClass("active");
                    $("#"+tag+'-tab').addClass("active");
                    $(".tab-pane").removeClass("show active");
                    $("#"+tag).addClass("show active");
                }
            }
        </script>
    </head>
    <body onload="showActive()">
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
                                <form action="./addDept.php" method="POST">
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
                    <div class="row m-3 justify-content-around text-center">
                    <?php
                    $qry = "SELECT * from department";
                    $res = $conn->query($qry);
                    if($res->num_rows > 0){
                        while($dept = $res->fetch_assoc())
                        {
                            echo '
                        <div class="col-3">
                            <div class="card shadow">
                                <div class="card-header">
                                    <h3>
                                        <u>'.$dept['name'].'</u>
                                    </h3>
                                </div>
                                <div class="card-body">
                                    '.$dept['description'].'
                                </div>
                                <div class="card-footer">
                                    <a href="./manageDept?dept='.$dept['name'].'" class="btn btn-primary">
                                        <i class="far fa-edit"></i>&nbsp;Manage
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
                                <form action="./addCategory.php" method="POST">
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
                            <form action="./feedback.php" method="GET">
                                <div class="row justify-content-center">
                                    <div class="form-group col-6">
                                        <label for="cat">Category</label>
                                        <select class="form-control" name="cat" id="cat" required>
                                            <option value="" disabled selected hidden>Select Category</option>
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
                                <div class="form-group">
                                    <input type="submit" id="CatBtn" class="btn btn-success my-2" value="Submit" />
                                </div>
                            </form>
                        </div>
                    </div>                    
                </div>
                <div class="tab-pane fade" id="questions" role="tabpanel" aria-labelledby="questions-tab">...</div>
                <div class="tab-pane fade" id="load" role="tabpanel" aria-labelledby="load-tab">
                    <div class="row justify-content-center">
                        <div class="btn btn-lg btn-info m-3"  data-toggle="collapse" href="#addLoadForm" role="button" aria-expanded="false" aria-controls="addLoadForm">
                            <i class="fas fa-plus"></i>&nbsp;Add
                        </div>
                    </div>
                    <div class="collapse" id="addLoadForm">
                        <div class="card shadow-md text-center mx-auto col-10">
                            <div class="card-body">
                                <form action="./addLoad.php" method="POST">
                                    <div class="row text-left">
                                        <div class="form-group col-4">
                                            <label for="department">Department:</label>
                                            <select class="form-control" name="dept" id="dept" required>
                                                <option value="" disabled selected hidden>Select Department</option>
                                                <?php
                                                $qry = "SELECT * FROM department";
                                                $res = $conn->query($qry);
                                                if ($res->num_rows > 0){
                                                    while($dept = $res->fetch_assoc()){
                                                        echo '
                                                <option value="'.$dept['name'].'">'.$dept['name'].'</option>
                                                        ';
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
										<div class="form-group col">
											<label for="course_abbr">Course abbreviation:</label>
                                            <input type="text" name="course_abbr" maxlength="5" required="true" id="course_abbr" class="form-control" placeholder="Course abbr">
                                        </div>
                                        <div class="form-group col-4">
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
                                                <input type="radio" name="course_type" value="Theory"class="mx-3" style="transform: scale(1.5);" id="theory" placeholder="Course abbr">Theory
                                                <input type="radio" name="course_type" value="Lab"class="mx-3" style="transform: scale(1.5);" id="lab" placeholder="Course abbr">Lab
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
                        <div class="card-body">
                            <h3>    
                                <u>Added faculties</u>
                            </h3>
							<table class="table table-bordered table-hover table-striped">
								<thead class="table-success">
									<tr>
										<th scope="col">
											<button class="btn bg-light text-primary">
												<strong>Department</strong>
											</button>
										</th>
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
									</tr>
								</thead>
								<tbody>
								<?php
								$qry = "SELECT * FROM load_distribution";
								$res = $conn->query($qry);
								if ($res->num_rows > 0)
								{
									while($row = $res->fetch_assoc())
									{
										echo '
									<tr>
										<td>'.$row['dept'].'</td>
										<td>'.$row['year'].'</td>
										<td>'.$row['block'].'</td>
										<td>'.$row['faculty'].'</td>
										<td>'.$row['course'].'</td>
										<td>'.$row['type'].'</td>
									</tr>
									';
									}
								}
								?>
								</tbody>
							</table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
<?php
$conn->close();
?>