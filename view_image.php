<?php
session_start();
include('config/connect.php');

// ตรวจสอบว่า id ถูกส่งมาใน URL หรือไม่
if (isset($_GET['id'])) {
    $dogID = intval($_GET['id']);

    // ดึงข้อมูลภาพจากฐานข้อมูล
    $query = $conn->prepare("SELECT image FROM dogimages WHERE dogID = ?");
    $query->bind_param("i", $dogID);
    $query->execute();
    $result = $query->get_result();

    // ตรวจสอบว่ามีข้อมูลหรือไม่
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $imagePath = 'uploads/' . htmlspecialchars($row['image']); // กำหนดเส้นทางไฟล์ภาพ
            echo "<img src='$imagePath' alt='Dog Image' style='max-width: 100%; height: auto;'>";
        }
    } else {
        echo "ไม่พบภาพสำหรับสุนัขนี้.";
    }
} else {
    echo "ไม่มี ID ที่ถูกต้อง.";
}

// ปิดการเชื่อมต่อ
$conn->close();
?>