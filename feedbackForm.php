<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "feedback_portal";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$token = "XA1P5WN7F";
$dept = 'SCET';
$year = 'FY';
$block = 'B2';

// $token = $_POST['token'];

// $qry = "SELECT * FROM student_tokens
//         WHERE token='$token'";
// $res = $conn->query($qry)->fetch_array();

// $dept = $res['dept'];
// $year = $res['year'];
// $block = $res['block'];

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta http-equiv="X-UA-Compatible" content="ie=edge" />
        <title>Feedback Form</title>

        <!-- Our Custom CSS -->

        <!-- FontAwesome kit -->
        <script src="https://kit.fontawesome.com/728d1d3dec.js"></script>
        <!-- jQuery CDN  -->
        <script
            src="https://code.jquery.com/jquery-3.3.1.min.js"
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
    </head>
    <body onload="loadForm()">
    <div class="container col-10 shadow-lg border rounded m-3 mx-auto p-3">
        <div class="card">
            <div class="card-header">
                <h2 class="text-primary">
                    Feedback Form:
                </h2>
            </div>
            <div class="card-body">
                <div class="justify-content-center" id="formTab">
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
                    <form action="./saveResponse.php" method="POST" onsubmit="return validate()" id="formTable" class="justify-content-cente align-items-center">
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="theory" role="tabpanel" aria-labelledby="theory-tab">
                            </div>
                            <div class="tab-pane fade" id="lab" role="tabpanel" aria-labelledby="lab-tab">
                            </div>
                        </div>
                    </form>
                </div>
                <div class="row justify-content-center">
                    <button type="submit" form="formTable" class="btn btn-success">Submit</button>
                </div>
            </div>
        </div>
    </div>
    </body>
    <script>
        function loadForm(){
            $.get("getForm.php", data={type: 'theory', category: 'Student', department: "<?php echo $dept; ?>", year: "<?php echo $year; ?>", block: "<?php echo $block; ?>", token: "<?php echo $token; ?>"}, 
            function(data, status){
                $("#theory").html(data);
            });
            $.get("getForm.php", data={type: 'lab', category: 'student', department: "<?php echo $dept; ?>", year: "<?php echo $year; ?>", block: "<?php echo $block; ?>", token: "<?php echo $token; ?>"},  
            function(data, status){
                $("#lab").html(data);
            });
        }
        function validate(){
            var check = true;
            $("input[type=radio]").each(function(e) {
                var name = $(this).attr("name");
                if($("input:radio[name="+name+"]:checked").length == 0){
                    check = false;
                }
            });
            if(!check){
                alert('Please select one option in each question in both the tabs: Theory & Lab!');
                return false;
            }
            return true;
        }
    </script>
</html>