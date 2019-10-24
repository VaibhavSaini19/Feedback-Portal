<?php
    // if(!isset($_SESSION))
    //     session_start();
    // if(isset($_SESSION['user'])){
    //     header('Location: student.php?act=home');
    // }

    $error = "";
    if (isset($_GET['error']))
        $error = $_GET['error'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php
        require '../view/header.php';
    ?>
    
    <title>Login Page</title>
    <!-- Our Custom CSS -->
    <style>
        body{
            padding: 0;
            margin: 0;
            height: 90vh;
            background-image: url("../imgs/campus.jpg");
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
        }
    </style>
    
</head>

<body>
    <div class="container justify-content-center align-items-center d-flex" style="min-height: 90vh;">
        <div class="card">
            <div class="card-header">
                <img src="../imgs/mitaoe.png" class="card-img-top" alt="MIT logo" >
            </div>
            <div class="card-body">
                <div class="row mx-auto text-danger">
                    <?php
                    if(!empty($error))
                        echo "<span><i>Incorrect PRN or token...</i></span>";
                    ?>
                </div>
                <form action="?act=check" method="POST">
                    <div class="row">
                        <div class="form-grp col">
                            <label for="prn">PRN:</label>
                            <input type="text" class="form-control" name="prn" id="prn" placeholder="Enter PRN" required>
                        </div>
                        <div class="form-grp col">
                            <label for="token">Token:</label>
                            <input type="password" class="form-control" name="token" id="token" placeholder="Enter Token" required>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <input type="submit" class="btn btn-primary mx-auto" value="Submit"></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>