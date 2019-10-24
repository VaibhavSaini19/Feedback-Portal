<?php
    if(!isset($_SESSION))
        session_start();
    if (isset($_SESSION['user']) && isset($_SESSION['user']['token'])) {
        $act = $_GET['act'] ?? 'home';
    } else if(!isset($_SESSION['user']) && isset($_GET['act'])) {
        $act = ($_GET['act']=='check') ? "check" : "login";
    } else {
        $act = 'login';
    }
    
    // var_dump($act);
    require '../core/db.php';
    $db = new DB();

    switch($act) {
        case 'login':
            include '../view/student/login.php';
            break;
        case 'check':
            require '../model/user_model.php';
            $um = new UserModel($db);
            $status = $um->checkStudent($_POST['prn'],$_POST['token']);
            if ($status !== false) {
                $_SESSION['user'] = $um->data[0];
                if($_SESSION['user']['status'] == 0)
                    header('Location: student.php?act=home');
                else
                    header('Location: student.php?act=complete');
            } else {
                header('Location: student.php?act=login&error=invalid');
            }
            break;
        case 'logout':
            include 'model/logout.php';
            break;
        case 'home':
            require '../model/dept_model.php';
                $dm = new DepartmentModel($db);
                $deptName = $_SESSION['user']['dept'];
                $dept_data = $dm->enlistDepartment(["name='$deptName'"]);
            include '../view/student/home.php';
            break;
        case 'save_Response':
            $prn = $_SESSION['user']['prn'];
            require '../model/response_model.php';
            $rm = new ResponseModel($db);
            $res = $rm->saveData($prn);
            if ($res === TRUE){
                $_SESSION['user']['status'] = 1;
                header('Location: student.php?act=complete&msg=success');
            } else {
                echo "Error: <br>" . $rm->db->conn->error;
                header('Location: student.php?act=complete&msg=fail');
            }
        case 'complete':
            require '../view/student/complete.php';
            break;
        default:
            include '../view/404.php';
            break;
    }
?>