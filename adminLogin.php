<?php
$error = "";
if (isset($_GET['error']))
    $error = $_GET['error'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
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
    <!-- FontAwesome kit -->
    <script src="https://kit.fontawesome.com/728d1d3dec.js"></script>
    <!-- jQuery CDN -->
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <!-- Popper.JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous"></script>
    <!-- Bootstrap CSS CDN -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous" />
    <!-- Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js" integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" crossorigin="anonymous"></script>
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