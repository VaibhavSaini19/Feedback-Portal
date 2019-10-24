<?php
    if(!isset($_SESSION))
        session_start();
    if(isset($_SESSION['user']) && $_SESSION['user']['status']==0){
        $token = $_SESSION['user']['token'];
        $dept = $_SESSION['user']['dept'];
        $year = $_SESSION['user']['year'];
        $block = $_SESSION['user']['block'];
        $name = $_SESSION['user']['name'];
        $prn = $_SESSION['user']['prn'];
    }else{
        header('Location: student.php?act=complete');
        exit();
    }
    // var_dump($_SESSION['user']);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    require_once '../view/header.php';
    ?>

    <title>Feedback Form</title>

    <!-- Our Custom CSS -->

</head>

<body onload="loadForm()">
    <div class="container col-10 shadow-lg border rounded m-3 mx-auto p-3">
        <div class="card">
            <div class="card-header">
                <h1 class="text-primary text-center">
                    <u>Feedback Form:</u>
                </h1>
                <table class="table table-bordered text-center">
                    <thead class="table-success">
                        <tr>
                            <th>PRN</th>
                            <th>Name</th>
                            <th>Block</th>
                            <th>Year</th>
                            <th>Department</th>
                        </tr>
                    </thead>
                    <tbody class="table-info">
                        <tr>
                            <td><?php echo $prn;?></td>
                            <td><?php echo $name;?></td>
                            <td><?php echo $block;?></td>
                            <td><?php echo $year;?></td>
                            <td><?php echo $dept;?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="card-body">
                <div class="justify-content-center" id="formTab">
                    <ul class="nav nav-tabs nav-fill" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="theory-tab" data-toggle="tab" href="#theory" role="tab" aria-controls="theory" aria-selected="true">
                                <h4><u>Theory</u></h4>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="lab-tab" data-toggle="tab" href="#lab" role="tab" aria-controls="lab" aria-selected="false">
                                <h4><u>Lab</u></h4>
                            </a>
                        </li>
                    </ul>
                    <form action="?act=save_Response" method="POST" onsubmit="return validate()" id="formTable" class="justify-content-cente align-items-center">
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
    function loadForm() {
        $.get("../model/getForm.php", data = {
                type: 'theory',
                category: 'Student',
                department: "<?php echo $dept; ?>",
                year: "<?php echo $year; ?>",
                block: "<?php echo $block; ?>",
                token: "<?php echo $token; ?>"
            },
            function(data, status) {
                $("#theory").html(data);
            });
        $.get("../model/getForm.php", data = {
                type: 'lab',
                category: 'student',
                department: "<?php echo $dept; ?>",
                year: "<?php echo $year; ?>",
                block: "<?php echo $block; ?>",
                token: "<?php echo $token; ?>"
            },
            function(data, status) {
                $("#lab").html(data);
            });
    }

    function validate() {
        var check = true;
        $("input[type=radio]").each(function(e) {
            var name = $(this).attr("name");
            if ($("input:radio[name=" + name + "]:checked").length == 0) {
                check = false;
            }
        });
        if (!check) {
            alert('Please select one option in each question in both the tabs: Theory & Lab!');
            return false;
        }
        return true;
    }
</script>

</html>