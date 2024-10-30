<?php 
    session_start();
    include('config\connect.php'); 
    if (!isset($_SESSION['email'])) {
        $_SESSION['msg']='กรุณาเข้าสู่ระบบ';
        header('location: login.php');
    }
    if (isset($_GET['logout'])){
        session_destroy();
        unset($_SESSION['email']);
        header('location: index.html');
    }
    $sql = "SELECT username, phone, facebook, line FROM register WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $_SESSION['email']);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        $username = htmlspecialchars($row['username']);
        $phone = htmlspecialchars($row['phone']);
        $facebook = htmlspecialchars($row['facebook']);
        $line = htmlspecialchars($row['line']);
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
            max-width: 1200px;
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
    </style>
</head>

<body>
    <?php if (isset($_SESSION['email'])): ?>
    <!-- Navbar Start -->
    <nav class="navbar navbar-expand-lg bg-white navbar-light shadow-sm py-3 py-lg-0 px-3 px-lg-0">
        <a href="active.php" class="navbar-brand ms-lg-5">
            <h1 class="m-0 text-uppercase text-dark"><font size="6" >Pet care service</font></h1>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <div class="navbar-nav ms-auto py-0">
                <a href="active.php?logout='1'" class="nav-item nav-link nav-contact text-white px-5 ms-lg-5" style="background-color:#343434;" >ออกจากระบบ <i class="bi bi-arrow-right"></i></a>
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
        <div class="container2 py-5">
            <h3 class="mt-4 ">ข้อมูล</h3>
                <label for="username" class="form-label">ชื่อ :</label>
                <?php echo $username; ?><br>
                <label for="phone" class="form-label">หมายเลขโทรศัพท์ :</label>
                <?php echo $phone; ?><br>
                <label for="facebook" class="form-label">Facebook :</label>
                <?php echo $facebook; ?><br>
                <label for="line" class="form-label">Line :</label>
                <?php echo $line; ?><br>
                <a href="history.php" class="btn1">ประวัติการใช้บริการ</a>
        </div>
        
    </div>
    <!-- Main End -->


    <!-- About Start -->
    <div class="container-fluid py-5">
        <div class="container">
            <div class="row gx-5">
                <div class="col-lg-5 mb-5 mb-lg-0" style="min-height: 500px;">
                    <div class="position-relative h-100">
                        <img class="position-absolute w-100 h-90 rounded" src="img/cathotel.jpg" style="object-fit: cover;">
                    </div>
                </div>
                <div class="col-lg-7">
                    <div class="border-start border-5 ps-5 mb-5">
                        <h1 class="display-5 text-uppercase mb-0">โรงแรมแมว บริการฝากเลี้ยงแมว</h1>
                    </div>
                    <div class="bg-light p-4">
                        
                        <div class="tab-content" id="pills-tabContent">
                            <div class="tab-pane  show active" id="pills-1" role="tabpanel" aria-labelledby="pills-1-tab">
                                <p class="mb-0">ออกแบบดีไซน์ คอนโดให้เหมาะกับไลฟ์สไตล์ของแมว เช่น เปลนอน อุโมงค์ และของเล่นในมุมต่างๆ เพื่อให้น้องแมวได้สำรวจและออกกำลังกายได้อย่างเต็มที่ สำหรับใครที่เลี้ยงน้องแมวอยู่ตอนนี้ เราขอแนะนำคอนโดแมว ย่านบางแค ที่โรงพยาบาลสัตว์เศรษฐกิจสัตวแพทย์</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="container">
            <div class="row gx-5">
                <div class="col-lg-5 mb-5 mb-lg-0" style="min-height: 500px;">
                    <div class="position-relative h-100">
                        <img class="position-absolute w-100 h-90 rounded" src="img/doghotel.jpg" style="object-fit: cover;">
                    </div>
                </div>
                <div class="col-lg-7">
                    <div class="border-start border-5 ps-5 mb-5">
                        <h1 class="display-5 text-uppercase mb-0">โรงแรมสุนัข บริการฝากเลี้ยงสุนัข</h1>
                    </div>
                    <div class="bg-light p-4">
                        
                        <div class="tab-content" id="pills-tabContent">
                            <div class="tab-pane  show active" id="pills-1" role="tabpanel" aria-labelledby="pills-1-tab">
                                <p class="mb-0">คอนโดสุนัข ออกแบบเพื่อการฝากเลี้ยง และฝากรักษาหลังผ่าตัด โดยคำนึกถึงความปลอดภัย เข้าใจความต้องการของน้องหมา </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- About End -->
    
    <!-- Service Start -->
    <div class="container-fluid py-5">
        <div class="container">
            <div class="border-start border-5  ps-5 mb-5" style="max-width: 600px;">
                <h1 class="display-5 text-uppercase mb-0">เลือกบริการ</h1>
            </div>
            <div class="row g-5">
            <div class="col-md-6">
                    <div class="service-item bg-light d-flex p-4">
                        <img src="img/dog.png" style="width:100px;height:100px;margin-right:20px;">
                        <div>
                            <h4 class="text-uppercase mb-3">สุนัข</h4>
                            <a href="servicedog.php" class="nav-item nav-link nav-contact text-white px-5 " style="background-color:#343434;" >เลือก </a>
                        </div>
                    </div>
                </div><br>
                <div class="col-md-6">
                    <div class="service-item bg-light d-flex p-4">
                    <img src="img/cat.png" style="width:100px;height:100px;margin-right:20px;">
                        <div>
                            <h4 class="text-uppercase mb-3">แมว</h4>
                            <a href="servicecat.php" class="nav-item nav-link nav-contact text-white px-5 " style="background-color:#343434;">เลือก </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Service End -->

    <!-- Contact Start -->
    <div class="container-fluid bg-light mt-5 py-5">
        <div class="container">
            <div class="border-start border-5  ps-5 mb-5" style="max-width: 600px;">
                <h1 class="display-5 text-uppercase mb-0">ติดต่อเรา</h1>
            </div>
            <div class="row g-5">
                <div class="col-md-6">
                    <a href="" target="_blank">
                        <img src="img/facebook.png" alt="Button Image" style="width:45px;height:45px;">
                    </a>&nbsp;&nbsp;
                    <a href="https://www.youtube.com/watch?v=-sPvp1O11sA" target="_blank">
                        <img src="img/line.png" alt="Button Image" style="width:45px;height:45px;">
                    </a>&nbsp;&nbsp;
                    <a href="" target="_blank">
                        <img src="img/tiktok.png" alt="Button Image" style="width:45px;height:45px;">
                    </a>&nbsp;&nbsp;
                    <a href="https://maps.app.goo.gl/Zy4pPu7bLZTVsjsT6" target="_blank">
                        <img src="img/map.png" alt="Button Image" style="width:45px;height:45px;">
                    </a>&nbsp;&nbsp;
                    <a href="tel:0807930288" class="call-button">
                        <img src="img/telephone.png" alt="Button Image" style="width:45px;height:45px;">
                    </a>&nbsp;&nbsp;
                </div>
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