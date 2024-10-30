<?php
    session_start();
    include('config/connect.php'); // เชื่อมต่อฐานข้อมูล
    $errors = array();
    
    if (isset($_POST['servicedog'])) {
        // ตรวจสอบว่ามีการลงทะเบียนผู้ใช้ในตาราง register
        
        $email = $_SESSION['email']; // อาจได้มาจากการลงทะเบียน
        $result = mysqli_query($conn, "SELECT userID FROM register WHERE email='$email'");
        $row = mysqli_fetch_assoc($result);
        
        if ($row) {
            $userID = $row['userID'];// ดึง userID จาก register
    
            // รับค่าจากฟอร์ม
            $dogname = mysqli_real_escape_string($conn,$_POST['dogname']);
            $doggender = mysqli_real_escape_string($conn,$_POST['doggender']);
            $dogage = mysqli_real_escape_string($conn,$_POST['dogage']);
            $dogspicies = mysqli_real_escape_string($conn,$_POST['dogspicies']);
            $dogbark = mysqli_real_escape_string($conn,$_POST['dogbark']);
            $dogbehavior = mysqli_real_escape_string($conn,$_POST['dogbehavior']);
            $dogtick = mysqli_real_escape_string($conn,$_POST['dogtick']);
            $dogcongen = mysqli_real_escape_string($conn,$_POST['dogcongen']);
            $dogvac = mysqli_real_escape_string($conn,$_POST['dogvac']);
            $dogrs = mysqli_real_escape_string($conn,$_POST['dogrs']);
            $dogtrans = mysqli_real_escape_string($conn,$_POST['dogtrans']);
            if (isset($_POST['dogservices']) && is_array($_POST['dogservices'])) {
                $dogservices = mysqli_real_escape_string($conn, implode(',', $_POST['dogservices'])); // รวมค่าที่เลือก
            }
            $total_price = 0;

            if (strpos($dogservices, 'อาบน้ำ-ตัดขน') !== false) {
            $total_price += 200;
            }

            if (strpos($dogservices, 'ฝากเลี้ยง') !== false) {
            $ddatestart = mysqli_real_escape_string($conn, $_POST['ddatestart']);
            $dateendd = mysqli_real_escape_string($conn, $_POST['dateendd']);

    // คำนวณจำนวนวัน
            $startDate = new DateTime($ddatestart);
            $endDate = new DateTime($dateendd);
            $interval = $startDate->diff($endDate);
            $days = $interval->days;

    // คำนวณค่าใช้จ่ายจากจำนวนวัน
            $total_price += $days * 300;
        }

// ตัวแปร $ddatetimestartd และ $ddatetimeendd ยังสามารถใช้ต่อไปได้
        $dtimestart = mysqli_real_escape_string($conn, $_POST['dtimestart']);
        $timeendd = mysqli_real_escape_string($conn, $_POST['timeendd']);

        $ddatetimestartd = $ddatestart . ' ' . $dtimestart;
        $ddatetimeendd = $dateendd . ' ' . $timeendd;

// สามารถแสดงราคาทั้งหมดได้ที่นี่
            $username = mysqli_real_escape_string($conn,$_POST['username']);
            $phone = mysqli_real_escape_string($conn,$_POST['phone']);
            $facebook = mysqli_real_escape_string($conn,$_POST['facebook']);
            $line = mysqli_real_escape_string($conn,$_POST['line']);


    
            // สร้างคำสั่ง SQL สำหรับการแทรกข้อมูลลงใน dogservice
            $sql = "INSERT INTO dogservice (dogname, doggender, dogage, dogspicies, dogbark, dogbehavior, dogtick, dogcongen, dogvac, dogrs, dogtrans, dogservices, ddatetimestartd, ddatetimeendd, userID, username, phone, facebook, line, total_price) 
            VALUES ('$dogname', '$doggender', '$dogage', '$dogspicies', '$dogbark', '$dogbehavior', '$dogtick', '$dogcongen', '$dogvac', '$dogrs', '$dogtrans', '$dogservices', '$ddatetimestartd', '$ddatetimeendd', '$userID', '$username', '$phone', '$facebook', '$line', '$total_price')";
            
            if (mysqli_query($conn, $sql)) {
                $_SESSION['success'] = "";
                header('location: dogpay.php');
                exit();
            } else {
                echo "Error: " . mysqli_error($conn);
            }
        } else {
            echo "ไม่พบผู้ใช้นี้ในระบบ.";
        }
    }
    
?>