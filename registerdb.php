<?php
    session_start();
    include('config\connect.php');
    $errors = array();
    if(isset($_POST['reg_user'])){
        $email = mysqli_real_escape_string($conn,$_POST['email']);
        $password = mysqli_real_escape_string($conn,$_POST['password']);
        $username = mysqli_real_escape_string($conn,$_POST['username']);
        $phone = mysqli_real_escape_string($conn,$_POST['phone']);
        $facebook = mysqli_real_escape_string($conn,$_POST['facebook']);
        $line = mysqli_real_escape_string($conn,$_POST['line']);

        if (empty($email)) {
            array_push($errors,'กรุณาใส่ Email');
        }
        if (empty($password)) {
            array_push($errors,'รหัสผ่านไม่ถูกต้อง');
        }

        $email_check_query = "SELECT * FROM register WHERE email = '$email'";
        $query = mysqli_query($conn,$email_check_query);
        $result = mysqli_fetch_assoc($query);

        if ($result) {
            if ($result['email']===$email){
                array_push($errors,"Email already exists");
            }
        }
        if (count($errors)==0) {
            $password = md5($password);
            $sql = "INSERT INTO register (email,password,username,phone,facebook,line)VALUES ('$email','$password','$username','$phone','$facebook','$line')";
            mysqli_query($conn,$sql);
            $_SESSION['email'] = $email;
            $_SESSION['success'] = "";
            header('location: active.php');
        }else{
            array_push($errors,"email or password already exists");
            $_SESSION['error'] = "email or password already exists!";
            header('location: register.php');
        }
    }
?>