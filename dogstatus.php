<?php
session_start();
include('config/connect.php');

if (isset($_POST['dogstatus'])) {
    $dogID = intval($_POST['dogID']);
    $status = mysqli_real_escape_string($conn, $_POST['status']);
    
    // คำสั่ง SQL สำหรับการอัปเดตสถานะ
    $sqlUpdate = "UPDATE dogservice SET status='$status' WHERE dogID='$dogID'";
    
    if (mysqli_query($conn, $sqlUpdate)) {
        $_SESSION['statusMsg'] = "สถานะถูกอัปเดตเรียบร้อยแล้ว.";
    } else {
        $_SESSION['statusMsg'] = "เกิดข้อผิดพลาดในการอัปเดตสถานะ.";
    }
    
    header("location: servicedogdetail.php?id=$dogID");
    exit();
}
?>
