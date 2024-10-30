<?php
    session_start();
    include('config/connect.php'); // เชื่อมต่อฐานข้อมูล
    $errors = array();
    
    if (isset($_POST['servicecat'])) {
        // ตรวจสอบว่ามีการลงทะเบียนผู้ใช้ในตาราง register
        $email = $_SESSION['email']; // อาจได้มาจากการลงทะเบียน
        $result = mysqli_query($conn, "SELECT userID FROM register WHERE email='$email'");
        $row = mysqli_fetch_assoc($result);
        
        if ($row) {
            $userID = $row['userID']; // ดึง userID จาก register
    
            // รับค่าจากฟอร์ม
            $catname = mysqli_real_escape_string($conn,$_POST['catname']);
            $catgender = mysqli_real_escape_string($conn,$_POST['catgender']);
            $catage = mysqli_real_escape_string($conn,$_POST['catage']);
            $catspicies = mysqli_real_escape_string($conn,$_POST['catspicies']);
            $catheat = mysqli_real_escape_string($conn,$_POST['catheat']);
            $catbehavior = mysqli_real_escape_string($conn,$_POST['catbehavior']);
            $cattick = mysqli_real_escape_string($conn,$_POST['cattick']);
            $catcongen = mysqli_real_escape_string($conn,$_POST['catcongen']);
            $catvac = mysqli_real_escape_string($conn,$_POST['catvac']);
            $catrs = mysqli_real_escape_string($conn,$_POST['catrs']);
            $cattrans = mysqli_real_escape_string($conn,$_POST['cattrans']);
            if (isset($_POST['catservices']) && is_array($_POST['catservices'])) {
                $catservices = mysqli_real_escape_string($conn, implode(',', $_POST['catservices'])); // รวมค่าที่เลือก
            }
            $total_price = 0;

            if (strpos($catservices, 'อาบน้ำ-ตัดขน') !== false) {
            $total_price += 150;
            }

            if (strpos($catservices, 'ฝากเลี้ยง') !== false) {
            $cdatestart = mysqli_real_escape_string($conn, $_POST['cdatestart']);
            $dateendc = mysqli_real_escape_string($conn, $_POST['dateendc']);

    // คำนวณจำนวนวัน
            $startDate = new DateTime($cdatestart);
            $endDate = new DateTime($dateendc);
            $interval = $startDate->diff($endDate);
            $days = $interval->days;

    // คำนวณค่าใช้จ่ายจากจำนวนวัน
            $total_price += $days * 200;
        }

            $cdatestart = mysqli_real_escape_string($conn,$_POST['cdatestart']);
            $ctimestart = mysqli_real_escape_string($conn,$_POST['ctimestart']);
            $dateendc = mysqli_real_escape_string($conn,$_POST['dateendc']);
            $timeendc = mysqli_real_escape_string($conn,$_POST['timeendc']);

            $cdatetimestartc = $cdatestart . ' ' . $ctimestart;
            $cdatetimeendc = $dateendc . ' ' . $timeendc;

            $username = mysqli_real_escape_string($conn,$_POST['username']);
            $phone = mysqli_real_escape_string($conn,$_POST['phone']);
            $facebook = mysqli_real_escape_string($conn,$_POST['facebook']);
            $line = mysqli_real_escape_string($conn,$_POST['line']);
            $status = mysqli_real_escape_string($conn,$_POST['status']);
            // ... (รับค่าต่อไป)
    
            // สร้างคำสั่ง SQL สำหรับการแทรกข้อมูลลงใน catservice
            $sql = "INSERT INTO catservice (catname, catgender, catage, catspicies, catheat, catbehavior, cattick, catcongen, catvac, catrs, cattrans, catservices, cdatetimestartc, cdatetimeendc, userID, username, phone, facebook, line,total_price, status) 
                    VALUES ('$catname', '$catgender', '$catage', '$catspicies', '$catheat', '$catbehavior', '$cattick', '$catcongen', '$catvac', '$catrs', '$cattrans', '$catservices', '$cdatetimestartc', '$cdatetimeendc', '$userID','$username', '$phone', '$facebook', '$line', '$total_price', '$status')";
            
            if (mysqli_query($conn, $sql)) {
                $_SESSION['success'] = "";
                header('location: catpay.php');
                exit();
            } else {
                echo "Error: " . mysqli_error($conn);
            }
        } else {
            echo "ไม่พบผู้ใช้นี้ในระบบ.";
        }
    }
    
?>