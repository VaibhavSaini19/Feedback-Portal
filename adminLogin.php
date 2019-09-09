<?php
    $error = "";
    if(isset($_GET['error']))
        $error = $_GET['error'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login</title>
</head>
<body>
    <div class="container border rounded">
        <div class="card">
            <div class="card-body">
                <form action="auth.php" method="POST">
                    <div class="form-grp">
                        <label for="username">Username:</label>
                        <input type="text" class="form-control" name="username" id="username" placeholder="Enter username">
                    </div>
                    <?php
                        // if(!empty($error))
                        //     echo "No such username exists...";
                    ?>
                    <div class="form-grp">
                        <label for="password">Password:</label>
                        <input type="password" class="form-control" name="password" id="password" placeholder="Enter password">
                    </div>
                    <button type="submit" class="btn btn-primary mx-auto" value="submit"></button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>