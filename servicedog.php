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
        body {
            margin: 0;
            padding: 0;
            font-family: 'Roboto', sans-serif;
        }
        .container {
            max-width: 600px;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin: auto; /* ทำให้กลางหน้า */
        }
        .btn1 {
            font-family: 'Roboto', sans-serif;
            background-color: #343434; 
            border: none;
            color: white;
            padding: 16px 32px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin: 6px 2px;
            transition-duration: 0.4s;
            cursor: pointer;
            width: 270px;
            height: 45px;
            line-height: 0px;
        }
        .form-label {
        display: inline-block; /* ทำให้ label แสดงเป็น inline-block */
        margin-right: 5px; /* ระยะห่างด้านขวาของ label */
        margin-top: 10px;
        }

        #species {
            margin-left: 5px; /* ระยะห่างด้านซ้ายของ select ถ้าต้องการ */
            width: 200px; /* กำหนดความกว้าง */
            text-align: center; /* ปรับข้อความใน select */
            color: white;
            background-color:#343434;
            width: 200px; /* กำหนดความกว้าง */
            height: 45px; /* กำหนดความสูง */
        }
        .form-control::placeholder {
            font-size: 14px;
        }
        .custom-input {
            width: 560px;  /* กำหนดความกว้าง */
            height: 125px; /* กำหนดความสูง */
            padding: 10px; /* เพิ่มพื้นที่ภายใน */
        }
        .datetime{
            width: 200px;           /* กำหนดความกว้าง */
            padding: 3px;          /* เพิ่มพื้นที่ภายใน */
            font-size: 16px;        /* ขนาดฟอนต์ */
            background-color: #f9f9f9; /* สีพื้นหลัง */
            text-align: center;
        }
        label {
            margin-right: 30px; /* เว้นระยะห่างขวาของป้ายกำกับ */
        }
        input[type="radio"] {
            margin-right: -5px;
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
        <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                </li>
            </ul>
        </div>
    </nav>

    <div class="container" >
        <h3 class="mt-4 text-center">แบบสำรวจข้อมูล</h3>
        <hr>
        <form action="servicedogdb.php" method="post" id="dogServiceForm" onsubmit="return validateForm()">
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
            <div class="mb-3">
            <h4 class="mt-4 ">ข้อมูลสุนัข</h4>
                <label for="dogname" class="form-label">ชื่อสัตว์เลี้ยง :</label>
                <input type="text" class="form-control" name="dogname" required >
                <label for="doggender" class="form-label ">เพศ :</label>
                    <input type="radio" name="doggender" value="ผู้">
                    <label for="ผู้">ผู้ </label>
                    <input type="radio" name="doggender" value="เมีย">
                    <label for="เมีย">เมีย </label><br>
                <label for="dogage" class="form-label ">อายุ :</label>
                <input type="text" class="form-control" name="dogage" required >
                <label for="dogspicies" class="form-label">สายพันธุ์ :</label>
                <input type="text" class="form-control" name="dogspicies">
                <label for="dogbark" class="form-label">เห่าเวลาที่เห็นสุนัขตัวอื่นหรือไม่ :</label>
                    <input type="radio" name="dogbark" value="เห่า">
                    <label for="เห่า">เห่า </label>
                    <input type="radio" name="dogbark" value="ไม่เห่า">
                    <label for="ไม่เห่า">ไม่เห่า </label><br>
                <label for="dogbehavior" class="form-label">ลักษณะนิสัย :</label>
                <input type="text" class="form-control" name="dogbehavior">
                <label for="dogtick" class="form-label">มีเห็บ-หมัดหรือไม่ :</label>
                    <input type="radio" name="dogtick" value="มี">
                    <label for="มี">มี </label>
                    <input type="radio" name="dogtick" value="ไม่มี">
                    <label for="ไม่มี">ไม่มี </label><br>
                <label for="dogcongen" class="form-label">โรคประจำตัว :</label>
                <input type="text" class="form-label" name="dogcongen">
                    <input type="checkbox" name="dogcongen" value="ไม่มี">
                    <label for="ไม่มี">ไม่มี </label><br>
                <label for="dogvac" class="form-label">รับวัคซีนครบหรือไม่ :</label>
                    <input type="radio" name="dogvac" value="ครบ">
                    <label for="ครบ">ครบ </label>
                    <input type="radio" name="dogvac" value="ไม่ครบ">
                    <label for="ไม่ครบ">ไม่ครบ </label><br>
                <label for="dogrs" class="form-label">เลี้ยงระบบปิดหรือระบบเปิด :</label>
                    <input type="radio" name="dogrs" value="ระบบปิด">
                    <label for="ระบบปิด">ระบบปิด </label>
                    <input type="radio" name="dogrs" value="ระบบเปิด">
                    <label for="ระบบเปิด">ระบบเปิด </label><br>
                <label for="dogtrans" class="form-label">ต้องการให้ รับ-ส่งหรือไม่ :</label>
                    <textarea id="address" class="form-control custom-input" name="dogtrans" placeholder="หากต้องการ กรุณาใส่ที่อยู่"></textarea>
                    <input type="checkbox" name="dogtrans" value="ไม่ต้องการ">
                    <label for="ไม่ต้องการ">ไม่ต้องการ </label><br>
                <label for="dogservices" class="form-label">เลือกบริการ :</label>
                    <input type="checkbox" name="dogservices[]" value="อาบน้ำ-ตัดขน">
                    <label for="อาบน้ำ-ตัดขน">อาบน้ำ-ตัดขน </label>
                    <input type="checkbox" name="dogservices[]" value="ฝากเลี้ยง" >
                    <label for="ฝากเลี้ยง">ฝากเลี้ยง </label>
                <h6 class="mt-4 ">ระยะเวลา</h6>
                    <label for="ddatetimestartd" class="form-label">ตั้งแต่ :</label>
                    <input type="date" class="datetime" name="ddatestart"required>
                    <input type="time" class="datetime" name="dtimestart" required><br>
                    <label for="ddatetimeendd" class="form-label">ถึง :</label>
                    <input type="date" class="datetime" name="dateendd"required>
                    <input type="time" class="datetime" name="timeendd" required>
            </div><br>
            <div class="mb-3">
            <h4 class="mt-4 ">ข้อมูลเจ้าของสุนัข</h4>
                <label for="username" class="form-label">ชื่อ :</label>
                <input type="text" class="form-control" name="username" value="<?php echo $username; ?>" required>
                <label for="phone" class="form-label">หมายเลขโทรศัพท์ :</label>
                <input type="tel" class="form-control" name="phone" oninput="validatePhoneNumber(event)"maxlength="10" value="<?php echo $phone; ?>" required>
                <label for="facebook" class="form-label">Facebook :</label>
                <input type="text" class="form-control" name="facebook" value="<?php echo $facebook; ?>">
                <label for="line" class="form-label">Line :</label>
                <input type="text" class="form-control" name="line" value="<?php echo $line; ?>"><br>
            </div>
            <button type="reset" class="btn1" >Reset</button>
            <button type="submit" name="servicedog" class="btn1">Submit</button>
        </form>
        <hr>
    </div>

    <!-- JavaScript Libraries -->
    <script>
    function validateForm() {
    const startDate = new Date(document.querySelector('input[name="ddatestart"]').value + 'T' + document.querySelector('input[name="dtimestart"]').value);
    const endDate = new Date(document.querySelector('input[name="dateendd"]').value + 'T' + document.querySelector('input[name="timeendd"]').value);
    const now = new Date();

    // ตรวจสอบว่า ddatestart >= ปัจจุบัน
    if (startDate < now) {
        alert("วันที่และเวลาไม่ถูกต้อง");
        return false;
    }

    // ตรวจสอบว่า dateendd > ddatestart
    if (endDate <= startDate) {
        alert("วันที่และเวลาไม่ถูกต้อง");
        return false;
    }

    // ตรวจสอบ checkbox ว่าถูกเลือกอย่างน้อย 1 อย่าง
    const checkboxes = document.querySelectorAll('input[name="dogservices[]"]');
    const checkedCount = Array.from(checkboxes).filter(i => i.checked).length;

    if (checkedCount === 0) {
        alert("กรุณาเลือกบริการอย่างน้อย 1 อย่าง");
        return false; // หยุดการส่งฟอร์ม
    }

    return true; // ทุกอย่างถูกต้อง สามารถส่งฟอร์มได้
}

    </script>
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