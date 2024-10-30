<?php 
    session_start();
    include('config\connect.php'); 
    if (!isset($_SESSION['adminID'])) {
        $_SESSION['msg']='กรุณาเข้าสู่ระบบ';
        header('location: adminlogin.php');
    }
    if (isset($_GET['logout'])){
        session_destroy();
        unset($_SESSION['adminID']);
        header('location: index.html');
    }

    $sqlUser = "SELECT * FROM register";
    $resultUser = $conn->query($sqlUser);

    $sqlDog = "SELECT * FROM dogservice";
    $resultDog = $conn->query($sqlDog);

// ดึงข้อมูลจาก catservice
    $sqlCat = "SELECT * FROM catservice";
    $resultCat = $conn->query($sqlCat);
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
            max-width: 800px;
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
            text-align: center;
            background-color: #343434;
            color: white;
        }
    </style>
</head>

<body>
    <?php if (isset($_SESSION['adminID'])): ?>
    <!-- Navbar Start -->
    <nav class="navbar navbar-expand-lg navbar-light shadow-sm " style="background-color:#343434;">
        <a href="adminindex.php" class="navbar-brand ms-lg-5">
            <h1 class="m-0 text-uppercase text-light"><font size="6" >Pet care service</font></h1>
        </a>
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <div class="navbar-nav ms-auto py-0">
                <a href="adminindex.php?logout='1'" class="nav-item nav-link nav-contact text-black px-5 ms-lg-5" style="background-color:white;" >ออกจากระบบ <i class="bi bi-arrow-right"></i></a>
            </div>
        </div>
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
        <div class="container2 py-5" >
            <h1 class="mt-4 text-center">Order</h1>
            <div class="mb-3">
            <h3 class="mt-4 ">สุนัข</h3>
            <table id="hist" style="display: flex; justify-content: center;">
                <tr>
                    <th>ชื่อลูกค้า</th>
                    <th>หมายเลขโทรศัพท์</th>
                    <th>ชื่อสัตว์เลี้ยง</th>
                    <th>บริการ</th>
                    <th>สถานะ</th>
                    <th>รายละเอียด</th>
                </tr>
                <?php
                // ตรวจสอบและแสดงข้อมูลในตาราง
                if (isset($resultDog) && $resultDog->num_rows > 0) {
                    while ($row = $resultDog->fetch_assoc()) {
                        echo "<tr>
                                <td>{$row['username']}</td>
                                <td>{$row['phone']}</td>
                                <td>{$row['dogname']}</td>
                                <td>{$row['dogservices']}</td>
                                <td>{$row['status']}</td>
                                <td>
                                    <a href='servicedogdetail.php?id={$row['dogID']}' style='text-decoration: underline; color: #343434;'>รายละเอียด</a>
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
            <table id="hist" style="display: flex; justify-content: center;">
            <tr>
                    <th>ชื่อลูกค้า</th>
                    <th>หมายเลขโทรศัพท์</th>
                    <th>ชื่อสัตว์เลี้ยง</th>
                    <th>บริการ</th>
                    <th>สถานะ</th>
                    <th>รายละเอียด</th>
                </tr>
                <?php
                // ตรวจสอบและแสดงข้อมูลในตาราง
                if (isset($resultCat) && $resultCat->num_rows > 0) {
                    while ($row = $resultCat->fetch_assoc()) {
                        echo "<tr>
                                <td>{$row['username']}</td>
                                <td>{$row['phone']}</td>
                                <td>{$row['catname']}</td>
                                <td>{$row['catservices']}</td>
                                <td>{$row['status']}</td>
                                <td>
                                    <a href='servicecatdetail.php?id={$row['catID']}' style='text-decoration: underline; color: #343434;'>รายละเอียด</a>
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
    <!-- Contact End -->

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