<?php 
    session_start();
    include('config\connect.php');
    $errors = array();

    if (isset($_POST['login_user'])) {
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $password = mysqli_real_escape_string($conn, $_POST['password']);

        if (empty($email)) {
            array_push($errors,'กรุณาใส่ Email');
        }
        if (empty($password)) {
            array_push($errors,'รหัสผ่านไม่ถูกต้อง');
        }
        if (count($errors)==0) {
            $password = md5($password);
            $query = "SELECT * FROM register WHERE email = '$email' AND password = '$password'";
            $result = mysqli_query($conn,$query);
            if (mysqli_num_rows($result) == 1){
                $_SESSION['email'] = $email;
                $_SESSION['success'] = "";
                header('location: active.php');
            }else{
                array_push($errors,"Wrong email/password combination");
                $_SESSION['error'] = "Wrong email or password Try again!";
                header('location: login.php');
            }
        }
    }
?>