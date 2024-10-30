<?php
    session_start();
    include('config\connect.php');
    $errors = array();
    if(isset($_POST['reg_admin'])){
        $adminID = mysqli_real_escape_string($conn, $_POST['adminID']);
        $adminpassword = mysqli_real_escape_string($conn, $_POST['adminpassword']);

        if (empty($adminID)) {
            array_push($errors,'กรุณาใส่ Admin ID');
        }
        if (empty($adminpassword)) {
            array_push($errors,'รหัสผ่านไม่ถูกต้อง');
        }

        $adminID_check_query = "SELECT * FROM admindb WHERE adminID = '$adminID'";
        $query = mysqli_query($conn,$adminID_check_query);
        $result = mysqli_fetch_assoc($query);

        if ($result) {
            if ($result['adminId']===$adminID){
                array_push($errors,"Email already exists");
            }
        }
        if (count($errors)==0) {
            $adminpassword = md5($adminpassword);
            $sql = "INSERT INTO admindb (adminID,adminpassword)VALUES ('$adminID','$adminpassword')";
            mysqli_query($conn,$sql);
            $_SESSION['adminID'] = $adminID;
            $_SESSION['success'] = "";
            header('location: adminindex.php');
        }else{
            array_push($errors,"email or password already exists");
            $_SESSION['error'] = "email or password already exists!";
            header('location: register.php');
        }
    }
?>