<?php
session_start();
include('config/connect.php');

if (isset($_POST['catstatus'])) {
    $catID = intval($_POST['catID']);
    $status = mysqli_real_escape_string($conn, $_POST['status']);
    
    // คำสั่ง SQL สำหรับการอัปเดตสถานะ
    $sqlUpdate = "UPDATE catservice SET status='$status' WHERE catID='$catID'";
    
    if (mysqli_query($conn, $sqlUpdate)) {
        $_SESSION['statusMsg'] = "สถานะถูกอัปเดตเรียบร้อยแล้ว.";
    } else {
        $_SESSION['statusMsg'] = "เกิดข้อผิดพลาดในการอัปเดตสถานะ.";
    }
    
    header("location: servicecatdetail.php?id=$catID");
    exit();
}
?>
