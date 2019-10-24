<?php
    session_start();
    require 'config.php';
    // session_unset();
    if (isset($_SESSION['user'])) {
        if ($_SESSION['user']['type']=='S') {
            require 'controller/student.php';
            exit();
        } elseif ($_SESSION['user']['type']=='F') {
            require 'controller/faculty.php';
            exit();
        } elseif ($_SESSION['user']['type']=='A') {
            require 'controller/admin.php';
            exit();
        }
    } elseif(!isset($_SESSION['user']) && isset($_GET['act'])) {
        $act = ($_GET['act']=='check')?"check":"login";
    } else {
        $act = 'login';
    }

    switch($act) {
        case 'login':
            $title = "Login Page";
            $heading = "User Authentication";
            include 'view/login.php';
            break;
        case 'check':
            require 'model/user_model.php';
            $user = new UserModel($db);
            $status = $user->checkUser($_POST['username'],$_POST['password']);
            if ($status !== false) {
                $_SESSION['user'] = $user->data[0];
                header('Location: index.php');
            } else {
                header('Location: index.php?act=login&error=invalid');
            }
            break;
        default:
            $title = "Error";
            $err_css = "color:red";
            $txt = "Page Not Found";
            include 'header.php';
            echo $txt;
            include 'footer.php';
    }
?>