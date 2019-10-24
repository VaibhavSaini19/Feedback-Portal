<?php
    if(!isset($_SESSION))
        session_start();
    if(!isset($_SESSION['user'])){
        header ('Location: index.php?act=login');
        exit();
    }

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta http-equiv="X-UA-Compatible" content="ie=edge" />
        <title>Create Feedback Form</title>

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
        <link rel="stylesheet" href="css/feedback.css" />
        <!-- Our custom JS -->
        <script src="js/feedback.js"></script>
        <!-- FontAwesome kit-->
        <script src="https://kit.fontawesome.com/728d1d3dec.js"></script>
    </head>
    <body onload="showSaveBtn()">
        <div class="container border rounded col-10 mx-auto justify-content-center m-3">
            <div class="row justify-content-end sticky-top">
                <a href="./index.php#category" class="btn btn-primary mt-3 mr-3">
                    <i class="fas fa-home"></i>&nbsp;
                    Home
                </a>
            </div>
            <div class="card m-5 mx-auto">
                <h3 class="card-title highlight bg-light p-4">
                    <span><u><?php echo $category;?> Feedback Form</u></span>
                    <!-- <input type="text" name="title" id="title" value="<?php echo $category;?> Feedback Form"/>
                    <textarea name="desc" id="desc" placeholder="Form description"></textarea> -->
                </h3>
                <div class="justify-content-center" id="formTab">
                    <ul class="nav nav-tabs nav-fill" role="tablist" id="myTab">
                        <li class="nav-item" style="position:relative;">
                            <a class="nav-link active" id="theory-tab" data-toggle="tab" href="#theory" role="tab"
                                aria-controls="theory" aria-selected="true">
                                <h4><u>Theory</u></h4>
                            </a>
                            <button form="theoryForm" id="theoryBtn" type="submit" class="btn btn-sm btn-success saveBtn" style="position: absolute; top: 8px; right: 8px;">
                                <i class="fas fa-plus"></i>&nbsp;
                                Save
                            </button>
                        </li>
                        <li class="nav-item" style="position:relative;">
                            <a class="nav-link" id="lab-tab" data-toggle="tab" href="#lab" role="tab"
                                aria-controls="lab" aria-selected="false">
                                <h4><u>Lab</u></h4>
                            </a>
                            <button form="labForm" id="labBtn" type="submit" class="btn btn-sm btn-success saveBtn" style="position: absolute; top: 8px; right: 8px;">
                                <i class="fas fa-plus"></i>&nbsp;
                                Save
                            </button>
                        </li>
                    </ul>
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="theory" role="tabpanel" aria-labelledby="theory-tab">
                        <?php
                            echo '
                            <form action="?act=save_Qns" method="POST" id="theoryForm">
                                <input type="hidden" name="cat" id="cat" value="'.$category.'" />
                                <input type="hidden" name="type" id="type" value="theory" />
                                <div class="card-body" id="sortable">
                            ';
                            if($resultTheory && count($resultTheory))
                            {
                                $qnNum = 0;
                                foreach($resultTheory as $row){
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
                                                <input type="text" name="response'.$qnNum.'[]" class="response" value="'.$row[$optNum].'" placeholder="option"/>
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
                                            <div class="btn modify copyBtn" onclick="copySlot(event)" 
                                            data-toggle="tooltip" data-placement="top" title="Duplicate">
                                                <i class="far fa-copy"></i>&nbsp;
                                            </div>
                                            <div class="verticalRule"></div>
                                            <div class="btn modify deleteBtn" onclick="removeSlot(event)"
                                            data-toggle="tooltip" data-placement="top" title="Delete">
                                                <i class="fas fa-trash"></i>&nbsp;
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
                                                <input type="text" name="response0[]" class="response" value="" placeholder="Option" />
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
                                            <div class="btn modify copyBtn" onclick="copySlot(event)" 
                                            data-toggle="tooltip" data-placement="top" title="Duplicate">
                                                <i class="far fa-copy"></i>&nbsp;
                                            </div>
                                            <div class="verticalRule"></div>
                                            <div class="btn modify deleteBtn" onclick="removeSlot(event)"
                                            data-toggle="tooltip" data-placement="top" title="Delete">
                                                <i class="fas fa-trash"></i>&nbsp;
                                            </div>
                                        </div>
                                    </div>
                                ';
                            }
                            echo '
                                </div>
                            </form>
                            ';
                            ?>
                        </div>
                        <div class="tab-pane fade" id="lab" role="tabpanel" aria-labelledby="lab-tab">
                        <?php
                            echo '
                            <form action="?act=save_Qns" method="POST" id="labForm">
                                <input type="hidden" name="cat" id="cat" value="'.$category.'" />
                                <input type="hidden" name="type" id="type" value="lab" />
                                <div class="card-body" id="sortable">
                            ';
                            if($resultLab && count($resultLab))
                            {
                                $qnNum = 0;
                                foreach($resultLab as $row){
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
                                                <input type="text" name="response'.$qnNum.'[]" class="response" value="'.$row[$optNum].'" placeholder="option"/>
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
                                            <div class="btn modify copyBtn" onclick="copySlot(event)" 
                                            data-toggle="tooltip" data-placement="top" title="Duplicate">
                                                <i class="far fa-copy"></i>&nbsp;
                                            </div>
                                            <div class="btn modify deleteBtn" onclick="removeSlot(event)"
                                            data-toggle="tooltip" data-placement="top" title="Delete">
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
                                                <input type="text" name="response0[]" class="response" value="" placeholder="Option" />
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
                                            <div class="btn modify copyBtn" onclick="copySlot(event)" 
                                            data-toggle="tooltip" data-placement="top" title="Duplicate">
                                                <i class="far fa-copy"></i>&nbsp;
                                            </div>
                                            <div class="btn modify deleteBtn" onclick="removeSlot(event)"
                                            data-toggle="tooltip" data-placement="top" title="Delete">
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
                            echo '
                                </div>
                            </form>
                            ';
                            ?>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
<?php
// $conn->close();
?>