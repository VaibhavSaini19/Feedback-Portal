<?php
    if(!isset($_SESSION))
        session_start();
    if ($_SESSION['user']['type']=="A") {
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
            $title = "Home Page";
            require 'model/dept_model.php';
                $dm = new DepartmentModel($db);
                $dept_data = $dm->enlistDepartment();
            require 'model/category_model.php';
                $cm = new CategoryModel($db);
                $cat_data = $cm->enlistCategory();
            require 'model/load_dist_model.php';
                $ldm = new LoadDistributionModel($db);
                $ld_data = $ldm->enlistLoadDistribution(["distinct(course)"]);
            include 'view/admin/home.php';
            break;
        case 'add_Dept':
            require 'model/admin/addDept.php';
            break;
        case 'add_Category':
            require 'model/admin/addCategory.php';
            break;
        case 'create_fb':    
            $category = $_POST['cat'] ?? $_GET['cat'];
            require 'model/qns_model.php';
                $qm = new QuestionsModel($db);
                $resultTheory = $qm->enlistQuestions(["category='$category'", "type='theory'"], 'id');
                $resultLab = $qm->enlistQuestions(["category='$category'", "type='lab'"], 'id');
            require 'view/admin/createFeedback.php';
            break;
        case 'save_Qns':
            require 'model/admin/saveQns.php';
            break;
        case 'add_Load':
            require 'model/addLoad.php';
            break;
        case 'manage_Dept':
            $deptName = $_GET['dept'];
            require 'model/dept_model.php';
                $dm = new DepartmentModel($db);
                $dept_data = $dm->enlistDepartment(["name='$deptName'"]);
            require 'model/category_model.php';
                $cm = new CategoryModel($db);
                $cat_data = $cm->enlistCategory();
            require 'view/admin/manageDept.php';
            break;
        case 'del_Dept':
            require 'model/admin/delDept.php';
            break;
        case 'update_Dept':
            require 'model/admin/updateDept.php';
            break;
        default:
            include 'view/404.php';
            break;
    }
?>