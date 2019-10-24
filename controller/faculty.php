<?php
    
    if ($_SESSION['user']['type']=="F") {
        $act = $_GET['act'] ?? 'home';
    } else {
        $act = 'login';
    }
    
    // var_dump($act);

    switch($act) {
        case 'login':
            include 'view/login.php';
            break;
        case 'logout':
            include 'model/logout.php';
            break;
        case 'home':
            $deptName = $_SESSION['user']['name'];
            require 'model/dept_model.php';
                $dm = new DepartmentModel($db);
                $dept_data = $dm->enlistDepartment(["name='$deptName'"]);
            require 'model/category_model.php';
                $cm = new CategoryModel($db);
                $cat_data = $cm->enlistCategory();
            include 'view/faculty/home.php';
            break;
        case 'add_Load':
            require 'model/addLoad.php';
            break;
        case 'update_Load':
            require 'model/faculty/updateLoad.php';
            break;
        default:
            include 'view/404.php';
            break;
    }
?>