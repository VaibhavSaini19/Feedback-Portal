<?php
    if(!isset($_SESSION))
        session_start();
    if($_SESSION['user']['type']!='A'){
        header('Location: index.php?act=login');
    }
    $dataPoints = "";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php
        require 'view/header.php';
    ?>
    <title>Manage Department</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.5.3/jspdf.min.js"></script>
    <script src="js/html2canvas.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>

    <script type="text/javascript">
        function saveTable2PDF(el=null) {
            if (el){
                var tables = $(".table-result");
                let name = $(el).closest('table').attr('id');
                for(var i=0; i<tables.length; i++){
                    if (name == tables[i].id){
                        html2canvas(tables[i], {
                                scale: window.devicePixelRatio,
                                logging: true,
                                profile: true,
                                useCORS: false
                            }).then(function (canvas) {
                                    var data = canvas.toDataURL('image/jpeg', 1);
                                    var src = encodeURI(data);
                                    var pdf = jsPDF("l", "mm", "a4");
                                    const imgProps= pdf.getImageProperties(data);
                                    const pdfWidth = pdf.internal.pageSize.getWidth();
                                    const pdfHeight = (imgProps.height * pdfWidth) / imgProps.width;
                                    pdf.text(15, 10, 'Result');
                                    pdf.addImage(src, 'JPEG', 0, 0, pdfWidth, pdfHeight);
                                    pdf.save(name+'.pdf');
                            });
                        break;
                    }
                }
            }else{
                var tables = $(".table-result");
                for(var i=0; i<tables.length; i++){
                    let name = tables[i].id;
                    html2canvas(tables[i], {
                        scale: window.devicePixelRatio,
                        logging: true,
                        profile: true,
                        useCORS: false
                    }).then(function (canvas) {
                            var data = canvas.toDataURL('image/jpeg', 1);
                            var src = encodeURI(data);
                            var pdf = jsPDF("l", "mm", "a4");
                            const imgProps= pdf.getImageProperties(data);
                            const pdfWidth = pdf.internal.pageSize.getWidth();
                            const pdfHeight = (imgProps.height * pdfWidth) / imgProps.width;
                            pdf.text(15, 10, 'Result');
                            pdf.addImage(src, 'JPEG', 0, 0, pdfWidth, pdfHeight);
                            pdf.save(name+'.pdf');
                    });
                }
            }
        }
    </script>
    
    <!-- Our Custom CSS -->
    <!-- Our Custom Js -->
    <script type="text/javascript">
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

        function isValid(){
            if($("#yearDataFilter").val()!=null && $("#blockDataFilter").val()!=null)
                $("#statsBtn").removeClass("d-none");
            else
                $("#statsBtn").addClass("d-none");
        }

        function getStats(){
            var department = "<?php echo $deptName; ?>";
            var year = $("#yearDataFilter").val();
            var block = $("#blockDataFilter").val();
            $.get("model/getStatsData.php", data={dept: department, year: year, block: block}, function(data, status){
                $("#statsTable").html(data);
                $("table").css("page-break-after", "always");
            }).then(()=>{
                $("#statsDownloadBtn").removeClass("d-none");
            });
        }

        function getChart(){
            var department = "<?php echo $deptName; ?>";
            var graphYear = $("#graphYear").val();
            var filterBy = $("#filterby").val();
            var dataPoints = null;
            var x_labels_list = {"block": Array.from({length: 30}, (v, k) => "Qn "+(k+1)), "subject": Array.from({length: 30}, (v, k) => "Qn "+(k+1)), "question": Array.from({length: 30}, (v, k) => "Option "+(k+1))};
            var y_labels_list = {"block": "Avg.score", "subject": "Avg.score", "question": "Student count"}
            var innerColors = ['rgba(255, 99, 132, 0.2)', 'rgba(54, 162, 235, 0.2)', 'rgba(255, 206, 86, 0.2)', 'rgba(75, 192, 192, 0.2)', 'rgba(153, 102, 255, 0.2)', 'rgba(255, 159, 64, 0.2)'];
            var borderColors = ['rgba(255, 99, 132, 1)', 'rgba(54, 162, 235, 1)', 'rgba(255, 206, 86, 1)', 'rgba(75, 192, 192, 1)', 'rgba(153, 102, 255, 1)', 'rgba(255, 159, 64, 1)'];
            var backgroundColor_list = replicateArray(innerColors, 5);
            var borderColor_list = replicateArray(borderColors, 5);
            
            $("#chartContainer").empty();
            $.get("model/getChartData.php", data={dept: department, year: graphYear, filterBy: filterBy}, function(data, status){
                // console.log(data);
                dataPoints = eval(data);
                // console.log(dataPoints);
                var titles_list = dataPoints[0];
                dataPoints = dataPoints.slice(1, dataPoints.length);
                for(var i=0; i<dataPoints.length; i++){
                    var chart_id = "chart" + i;
                    $("#chartContainer").append('<canvas id="'+chart_id+'"></canvas>'); 
                    var ctx = document.getElementById(chart_id).getContext('2d');
                    var myChart = new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: x_labels_list[filterBy].slice(0, dataPoints[i].length),
                            datasets: [{
                                label: y_labels_list[filterBy],
                                data: dataPoints[i],
                                backgroundColor: backgroundColor_list.slice(0, dataPoints[i].length),
                                borderColor: borderColor_list.slice(0, dataPoints[i].length),
                                borderWidth: 1
                            }]
                        },
                        options: {
                            title: { display: true, text: titles_list[i]},
                            scales: { yAxes: [{ ticks: { beginAtZero: true } }] }
                        }
                    });
                }
            });
        }

        function replicateArray(array, n) {
            var arrays = Array.apply(null, new Array(n)); // Create an array of size "n" with undefined values
            arrays = arrays.map(function() { return array }); // Replace each "undefined" with our array, resulting in an array of n copies of our array
            return [].concat.apply([], arrays); // Flatten our array of arrays
        }
    </script>

</head>

<body onload="showFaculty();">
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
                        <a class="list-group-item list-group-item-action" id="list-edit-list" 
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
                                            <label for="cat">Show form for:</label>
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
                                    <div class="row justify-content-center border rounded m-2" id="facultyTable">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="list-results" role="tabpanel" 
                            aria-labelledby="list-results-list">
                            <div class="card">
                                <div class="card-body">
                                    <div class="justify-content-center" id="dataTab">
                                        <ul class="nav nav-tabs nav-fill" role="tablist">
                                            <li class="nav-item">
                                                <a class="nav-link active" id="stats-tab" data-toggle="tab" href="#stats" role="tab"
                                                    aria-controls="stats" aria-selected="true">
                                                    <h4><u>Statistics</u></h4>
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" id="graph-tab" data-toggle="tab" href="#graph" role="tab"
                                                    aria-controls="graph" aria-selected="false">
                                                    <h4><u>Graphs</u></h4>
                                                </a>
                                            </li>
                                        </ul>
                                        <div class="tab-content" id="myDataTabContent">
                                            <div class="tab-pane fade show active" id="stats" role="tabpanel" aria-labelledby="stats-tab">
                                                <div class="row justify-content-center m-1">
                                                    <div class="form-group col-4">
                                                        <label for="year">Year:</label>
                                                        <select class="form-control" name="yearDataFilter" id="yearDataFilter" onchange="isValid();">
                                                        <option value="" selected hidden disabled>Select Year</option>
                                                            <option value="FY">FY</option>
                                                            <option value="SY">SY</option>
                                                            <option value="TY">TY</option>
                                                            <option value="BE">BE</option>
                                                        </select>
                                                    </div>
                                                    <div class="form-group col-4">
                                                        <label for="block">Block:</label>
                                                        <select class="form-control" name="blockDataFilter" id="blockDataFilter" onchange="isValid();">
                                                        <option value="" selected hidden disabled>Select Block</option>
                                                            <option value="B1">B1</option>
                                                            <option value="B2">B2</option>
                                                            <option value="B3">B3</option>
                                                            <option value="B4">B4</option>
                                                            <option value="B5">B5</option>
                                                            <option value="B6">B6</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="row d-none" id="statsBtn">
                                                    <button class="btn btn-success mx-auto" id="statsSubmitBtn" type="submit" onclick="getStats()">Submit</button>
                                                    <button class="btn btn-info mx-auto d-none" id="statsDownloadBtn" onclick="saveTable2PDF()">Download All</button>
                                                </div>
                                                <img src="" alt="" id="screenshot">
                                                <div class="row justify-content-center border rounded m-2 p-2" id="statsTable">
                                                </div>
                                            </div>
                                            <div class="tab-pane fade" id="graph" role="tabpanel" aria-labelledby="graph-tab">
                                                <div class="row justify-content-center m-1">
                                                    <div class="form-group col-4">
                                                        <label for="year">Year:</label>
                                                        <select class="form-control" name="graphYear" id="graphYear" required>
                                                            <option value="" selected hidden disabled>Select Year</option>
                                                            <option value="FY">FY</option>
                                                            <option value="SY">SY</option>
                                                            <option value="TY">TY</option>
                                                            <option value="BE">BE</option>
                                                        </select>
                                                    </div>
                                                    <div class="form-group col-4">
                                                        <label for="filterby">Display graph by:</label>
                                                        <select class="form-control" name="filterby" id="filterby" required onchange="$('#graphBtn').removeClass('d-none');">
                                                            <option value="" selected hidden disabled>Select filter</option>
                                                            <option value="block" >Block-wise</option>
                                                            <option value="subject">Subject-wise</option>
                                                            <option value="question">Question-wise</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="row" id="graphBtn">
                                                    <button class="btn btn-info mx-auto" onclick="getChart()" type="submit">Submit</button>
                                                </div>
                                                <div class="mx-auto" id="chartContainer" style="width: 40em;">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
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