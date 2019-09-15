<?php
$error = "";
if (isset($_GET['error']))
    $error = $_GET['error'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php
        require_once './header.php';
    ?>
    
    <title>Login</title>
    <!-- Our Custom CSS -->
    <style>
        body{
            padding: 0;
            margin: 0;
            height: 90vh;
            background-image: url("./campus.jpg");
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
                <img src="./mitaoe.png" class="card-img-top" alt="MIT logo" >
            </div>
            <div class="card-body">
                <form action="auth.php" method="POST">
                    <div class="row">
                        <div class="form-grp col">
                            <label for="username">Username:</label>
                            <input type="text" class="form-control" name="username" id="username" placeholder="Enter username" required>
                        </div>
                        <?php
                        // if(!empty($error))
                        //     echo "No such username exists...";
                        ?>
                        <div class="form-grp col">
                            <label for="password">Password:</label>
                            <input type="password" class="form-control" name="password" id="password" placeholder="Enter password" required>
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