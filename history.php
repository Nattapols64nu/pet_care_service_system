<?php
session_start();
include('config/connect.php'); // เชื่อมต่อฐานข้อมูล
$errors = array();
// ตรวจสอบว่ามี email ใน session หรือไม่
if (isset($_SESSION['email'])) {
    $email = $_SESSION['email']; // ดึง email จาก session

    // สร้างคำสั่ง SQL เพื่อดึง userID ตาม email
    $sqlUser = "SELECT userID FROM register WHERE email = ?";
    $stmtUser = $conn->prepare($sqlUser);
    $stmtUser->bind_param("s", $email);
    $stmtUser->execute();
    $resultUser = $stmtUser->get_result();

    if ($rowUser = $resultUser->fetch_assoc()) {
        $userID = $rowUser['userID']; // ดึง userID จาก register

        // สร้างคำสั่ง SQL เพื่อดึงข้อมูลจาก dogservice ตาม userID
        $sqlDog = "SELECT * FROM dogservice WHERE userID = ?";
        $stmtDog = $conn->prepare($sqlDog);
        $stmtDog->bind_param("i", $userID);
        $stmtDog->execute();
        $resultDog = $stmtDog->get_result();

        // สร้างคำสั่ง SQL เพื่อดึงข้อมูลจาก catservice ตาม userID
        $sqlCat = "SELECT * FROM catservice WHERE userID = ?";
        $stmtCat = $conn->prepare($sqlCat);
        $stmtCat->bind_param("i", $userID);
        $stmtCat->execute();
        $resultCat = $stmtCat->get_result();
    } else {
        echo "ไม่พบผู้ใช้.";
    }

    $stmtUser->close();
} else {
    $_SESSION['msg'] = 'กรุณาเข้าสู่ระบบ';
    header('location: login.php');
    exit();
}
// ตัวอย่าง SQL สำหรับดึงข้อมูล
$query = "SELECT * FROM dogimages WHERE dogID = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $row['dogID']); // เปลี่ยนเป็น dogID ตามที่คุณต้องการ
$stmt->execute();
$resultImages = $stmt->get_result();
$images = [];

// เก็บ URL ของภาพลงในอาเรย์
while ($imageRow = $resultImages->fetch_assoc()) {
    $images[] = $imageRow['image']; // สมมติว่า 'image' เป็นชื่อฟิลด์ในตาราง dogimages
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Pet care service</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="Free HTML Templates" name="keywords">
    <meta content="Free HTML Templates" name="description">

    <!-- Favicon -->
    <link rel="icon" href="img/logoic.png" type="image/gif" />

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins&family=Roboto:wght@700&display=swap" rel="stylesheet">  

    <!-- Icon Font Stylesheet -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">
    <link href="lib/flaticon/font/flaticon.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="css/style.css" rel="stylesheet">
    <style>
        .btn1 {
            font-family: 'Roboto', sans-serif;
            background-color: #343434; 
            border: none;
            color: white;
            padding: 0; /* ลบ padding */
            text-align: center;
            text-decoration: none;
            display: flex; /* ใช้ flexbox */
            justify-content: center; /* จัดแนวในแนวนอน */
            align-items: center; /* จัดแนวในแนวตั้ง */
            font-size: 16px;
            margin: 6px 2px;
            cursor: pointer;
            width: 200px;
            height: 45px;
        }
        .container2 {
            max-width: 1300px;
            max-height: 1750px;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin: 10px auto; /* ปรับให้ margin ด้านบนและด้านล่างเป็น 10px และด้านซ้ายขวาเป็น auto */
            
            flex-direction: column;
            justify-content: center;
        }

        .bg-offer {
        padding-top: 50px; /* เพิ่มพื้นที่ด้านบน */
        padding-bottom: 50px; /* เพิ่มพื้นที่ด้านล่าง */
        }
    
        .text-white {
            margin: 0; /* ลบ margin ของ <p> */
        }
    
        /* เพิ่มการจัดการความสูงตามหน้าจอ */
        @media (min-width: 768px) {
            .bg-offer {
            height: 700px; /* หรือความสูงที่ต้องการ */
            }
        }
        #้hist {
            font-family: Arial, Helvetica, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }

        #hist td, #hist th {
            border: 1px solid #ddd;
            padding: 8px;
        }
        #hist tr:nth-child(even){background-color: #f2f2f2;}
        #hist tr:hover {background-color: #ddd;}

        #hist th {
            padding-top: 12px;
            padding-bottom: 12px;
            text-align: left;
            background-color: #343434;
            color: white;
        }
    </style>
</head>

<body>
    <?php if (isset($_SESSION['email'])): ?>
    <!-- Navbar Start -->
    <nav class="navbar navbar-expand-lg navbar-light shadow-sm " style="background-color:#343434;">
        <a href="active.php" class="navbar-brand ms-lg-5">
            <h1 class="m-0 text-uppercase text-light"><font size="6" >Pet care service</font></h1>
        </a>
    </nav>
    <!-- Navbar End -->

    <!-- Notification Success -->
    <?php if (isset($_SESSION['success'])) : ?>
        <div class="success">
            <h3>
                <?php 
                    echo $_SESSION['success'];
                    unset ($_SESSION['success'])
                ?>
            </h3>
        </div>
    <?php endif ?>

    <!-- Main Start-->
    <div class="container-fluid">
        <div class="container2 py-5">
            <h1 class="mt-4 text-center">ประวัติการใช้บริการ</h1>
            <div class="mb-3">
            <h3 class="mt-4 ">สุนัข</h3>
            <table id="hist">
                <tr>
                    <th>ชื่อสัตว์เลี้ยง</th>
                    <th>เพศ</th>
                    <th>อายุ</th>
                    <th>สายพันธุ์</th>
                    <th>เห่าเวลาที่เห็นสุนัขตัวอื่นหรือไม่</th>
                    <th>ลักษณะนิสัย</th>
                    <th>มีเห็บ-หมัดหรือไม่</th>
                    <th>โรคประจำตัว</th>
                    <th>รับวัคซีนครบหรือไม่</th>
                    <th>เลี้ยงระบบปิดหรือระบบเปิด</th>
                    <th>ต้องการให้ รับ-ส่งหรือไม่</th>
                    <th>เลือกบริการ</th>
                    <th>ตั้งแต่</th>
                    <th>ถึง</th>
                    <th>สถานะ</th>
                    <th>รูป</th>
                </tr>
                <?php
                // ตรวจสอบและแสดงข้อมูลในตาราง
                if (isset($resultDog) && $resultDog->num_rows > 0) {
                    while ($row = $resultDog->fetch_assoc()) {
                        echo "<tr>
                                <td>{$row['dogname']}</td>
                                <td>{$row['doggender']}</td>
                                <td>{$row['dogage']}</td>
                                <td>{$row['dogspicies']}</td>
                                <td>{$row['dogbark']}</td>
                                <td>{$row['dogbehavior']}</td>
                                <td>{$row['dogtick']}</td>
                                <td>{$row['dogcongen']}</td>
                                <td>{$row['dogvac']}</td>
                                <td>{$row['dogrs']}</td>
                                <td>{$row['dogtrans']}</td>
                                <td>{$row['dogservices']}</td>
                                <td>{$row['ddatetimestartd']}</td>
                                <td>{$row['ddatetimeendd']}</td>
                                <td>{$row['status']}</td>
                                <td>
                                <a href='view_image.php?id={$row['dogID']}' style='text-decoration: underline; color: #343434;'>ดูรูป</a>
                                </td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='12'>ไม่มีข้อมูล</td></tr>";
                }
                ?>
            </table>
            </div>
            <div class="mb-3">
            <h3 class="mt-4 ">แมว</h3>
            <table id="hist">
                <tr>
                    <th>ชื่อสัตว์เลี้ยง</th>
                    <th>เพศ</th>
                    <th>อายุ</th>
                    <th>สายพันธุ์</th>
                    <th>ฮีทและฉี่สเปรย์หรือไม่</th>
                    <th>ลักษณะนิสัย</th>
                    <th>มีเห็บ-หมัดหรือไม่</th>
                    <th>โรคประจำตัว</th>
                    <th>รับวัคซีนครบหรือไม่</th>
                    <th>เลี้ยงระบบปิดหรือระบบเปิด</th>
                    <th>ต้องการให้ รับ-ส่งหรือไม่</th>
                    <th>เลือกบริการ</th>
                    <th>ตั้งแต่</th>
                    <th>ถึง</th>
                    <th>สถานะ</th>
                    <th>รูป</th>
                </tr>
                <?php
                // ตรวจสอบและแสดงข้อมูลในตาราง
                if (isset($resultCat) && $resultCat->num_rows > 0) {
                    while ($row = $resultCat->fetch_assoc()) {
                        echo "<tr>
                                <td>{$row['catname']}</td>
                                <td>{$row['catgender']}</td>
                                <td>{$row['catage']}</td>
                                <td>{$row['catspicies']}</td>
                                <td>{$row['catheat']}</td>
                                <td>{$row['catbehavior']}</td>
                                <td>{$row['cattick']}</td>
                                <td>{$row['catcongen']}</td>
                                <td>{$row['catvac']}</td>
                                <td>{$row['catrs']}</td>
                                <td>{$row['cattrans']}</td>
                                <td>{$row['catservices']}</td>
                                <td>{$row['cdatetimestartc']}</td>
                                <td>{$row['cdatetimeendc']}</td>
                                <td>{$row['status']}</td>
                                <td>
                                <a href='view_image2.php?id={$row['catID']}' style='text-decoration: underline; color: #343434;'>ดูรูป</a>
                                </td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='12'>ไม่มีข้อมูล</td></tr>";
                }
                ?>
            </table>
            </div>
        </div>
    </div>
    <!-- Main End --> 

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>

    <!-- Template Javascript -->
    <script src="js/main.js"></script>
<?php endif; ?>
</body>

</html>