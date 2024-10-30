<?php

$servername = 'localhost';
$username = 'root';
$password = '';
$dbname = 'pet_care_service_system';

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
	die("Connection : failed (เชื่อมต่อฐานข้อมูล ไม่สำเร็จ)" . mysqli_connect_error());
}

//mysqli_close($conn); // ปิดฐานข้อมูล
?>