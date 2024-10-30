<?php 
    session_start();
    include('config\connect.php');
    $errors = array();

    if (isset($_POST['login_admin'])) {
        $adminID = mysqli_real_escape_string($conn, $_POST['adminID']);
        $adminpassword = mysqli_real_escape_string($conn, $_POST['adminpassword']);

        if (empty($adminID)) {
            array_push($errors,'กรุณาใส่ admin id');
        }
        if (empty($adminpassword)) {
            array_push($errors,'รหัสผ่านไม่ถูกต้อง');
        }
        if (count($errors)==0) {
            $adminpassword = md5($adminpassword);
            $query = "SELECT * FROM admindb WHERE adminID = '$adminID' AND adminpassword = '$adminpassword'";
            $result = mysqli_query($conn,$query);
            if (mysqli_num_rows($result) == 1){
                $_SESSION['adminID'] = $adminID;
                $_SESSION['success'] = "";
                header('location: adminindex.php');
            }else{
                array_push($errors,"Wrong email/password combination");
                $_SESSION['error'] = "Wrong email or password Try again!";
                header('location: adminlogin.php');
            }
        }
    }
?>