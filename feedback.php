<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "feedback_portal";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
// echo "Connected successfully";

$tableName = $_GET['cat'];
$qry = "SELECT * from " . $tableName;
// $qry = "SELECT * from " . 'test';
// echo $qry;
$result = $conn->query($qry);

echo '
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta http-equiv="X-UA-Compatible" content="ie=edge" />
        <title>Feedback Form</title>

        <!-- jQuery CDN - Slim version (=without AJAX) -->
        <script
            src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
            integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
            crossorigin="anonymous"
        ></script>
        <!-- jQueryUI CDN source for sortable Drag & drop -->
        <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
        <!-- Popper.JS -->
        <script
            src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"
            integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ"
            crossorigin="anonymous"
        ></script>
        <!-- Bootstrap CSS -->
        <link
            rel="stylesheet"
            href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
            integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T"
            crossorigin="anonymous"
        />
        <!-- Bootstrap JS -->
        <script
            src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js"
            integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm"
            crossorigin="anonymous"
        ></script>

        <!-- Our custom CSS -->
        <link rel="stylesheet" href="./feedback.css" />
        <!-- Our custom JS -->
        <script src="./feedback.js"></script>
        <!-- FontAwesome kit-->
        <script src="https://kit.fontawesome.com/728d1d3dec.js"></script>
    </head>
    <body>
        <div class="container border rounded col-10 mx-auto justify-content-center m-3">
            <div class="row justify-content-end sticky-top">
                <a href="./index.html" class="btn btn-primary mt-3 mr-3">
                    <i class="fas fa-home"></i>&nbsp;
                    Home
                </a>
            </div>
            <form action="./saveQns.php" method="POST">
                <input type="hidden" name="tableName" id="tableName" value="'.$tableName.'" />
                <div class="card m-5 mx-auto">
                    <h3 class="card-title highlight">
                        <input type="text" name="title" id="title" value="'.$tableName.' Feedback Form"/>
                        <textarea name="desc" id="desc" placeholder="Form description"></textarea>
                        <button type="submit" class="btn btn-success saveBtn">
                            <i class="fas fa-plus"></i>&nbsp;
                            Save
                        </button>
                    </h3>
                    <div class="card-body" id="sortable">
                    ';
                    if ($result->num_rows > 0)
                    {
                        $qnNum = 0;
                        while($row = $result->fetch_assoc()) {
                            $qnNum += 1;
                            echo '
                        <div class="slot highlight">
                            <div class="question">
                                <input type="text" name="question'.$qnNum.'" id="question" value="'.$row["question"].'" />
                            </div>
                            <div class="options">
                            ';
                            for($i=1; $i<=5; $i++){
                                $optNum = 'option'.$i;
                                if(isset($row[$optNum])){
                                    echo '
                                    <div class="option">
                                        <i class="far fa-circle"></i>&nbsp;
                                        <input type="text" name="response'.$qnNum.'[]" id="response" value="'.$row[$optNum].'" placeholder="option"/>
                                        <div class="btn removeBtn" onclick="removeOpt(event)">
                                            <i class="fas fa-times"></i>
                                        </div>
                                    </div>
                                    ';
                                };
                                }
                                echo '
                                <div class="btn btn-outline-info addOptBtn show" onclick="addOption(event)">
                                    <i class="fas fa-plus"></i>&nbsp; Add option
                                </div>
                            </div>
                            <div class="footer">
                                <div class="btn btn-outline-primary addSlotBtn" onclick="addSlot(event)">
                                    <i class="fas fa-plus"></i>&nbsp; Add Question
                                </div>
                                <div class="btn modify copyBtn" onclick="copySlot(event)">
                                    <i class="far fa-copy"></i>&nbsp;
                                </div>
                                <div class="btn modify deleteBtn" onclick="removeSlot(event)">
                                    <i class="fas fa-trash"></i>&nbsp;
                                </div>
                                <div class="verticalRule"></div>
                                <div class="custom-control custom-switch">
                                    <input type="checkbox" class="custom-control-input" id="customSwitch1" checked="true"/>
                                    <label class="custom-control-label" for="customSwitch1">
                                        Required
                                    </label>
                                </div>
                            </div>
                        </div>
                            ';
                        }
                    }else{
                        echo '
                        <div class="slot highlight">
                            <div class="question">
                                <input type="text" name="question0" id="question" placeholder="Question" />
                            </div>
                            <div class="options">
                                <div class="option">
                                    <i class="far fa-circle"></i>&nbsp;
                                    <input type="text" name="response0[]" id="response" value="" placeholder="Option" />
                                    <div class="btn removeBtn" onclick="removeOpt(event)">
                                        <i class="fas fa-times"></i>
                                    </div>
                                </div>
                                <div class="btn btn-outline-info addOptBtn show" onclick="addOption(event)">
                                    <i class="fas fa-plus"></i>&nbsp; Add option
                                </div>
                            </div>
                            <div class="footer">
                                <div class="btn btn-outline-primary addSlotBtn" onclick="addSlot(event)">
                                    <i class="fas fa-plus"></i>&nbsp; Add Question
                                </div>
                                <div class="btn modify copyBtn" onclick="copySlot(event)">
                                    <i class="far fa-copy"></i>&nbsp;
                                </div>
                                <div class="btn modify deleteBtn" onclick="removeSlot(event)">
                                    <i class="fas fa-trash"></i>&nbsp;
                                </div>
                                <div class="verticalRule"></div>
                                <div class="custom-control custom-switch">
                                    <input type="checkbox" class="custom-control-input" id="customSwitch1" />
                                    <label class="custom-control-label" for="customSwitch1">
                                        Required
                                    </label>
                                </div>
                            </div>
                        </div>
                        ';
                    }
                    echo '
                    </div>
                </div>
            </form>
        </div>
    </body>
</html>
';
$conn->close();
