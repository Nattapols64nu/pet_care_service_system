<?php
session_start();
include('config/connect.php');

// Check if the admin is logged in
if (!isset($_SESSION['adminID'])) {
    $_SESSION['msg'] = 'กรุณาเข้าสู่ระบบ';
    header('location: adminlogin.php');
    exit;
}

// Handle the dog detail request
if (isset($_GET['id'])) {
    $dogID = intval($_GET['id']);

    // Fetch dog details
    $sqlDogDetail = "SELECT * FROM dogservice WHERE dogID = ?";
    $stmt = $conn->prepare($sqlDogDetail);
    $stmt->bind_param("i", $dogID);
    $stmt->execute();
    $resultDogDetail = $stmt->get_result();
    
    if ($resultDogDetail->num_rows > 0) {
        $dogDetail = $resultDogDetail->fetch_assoc();
    } else {
        echo "ไม่พบรายละเอียดสำหรับสุนัขนี้.";
        exit;
    }
} else {
    echo "คำขอไม่ถูกต้อง.";
    exit;
}
if (isset($_POST['upload_image'])) {
    if (!empty($_FILES["dog_image"]["name"])) {
        $image = basename($_FILES["dog_image"]["name"]);
        $targetDir = "uploads/";
        $targetFilePath = $targetDir . $image;
        $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);
        $dogID = $_POST['dogID']; // รับค่า dogID

        // อนุญาตเฉพาะไฟล์ประเภทภาพ
        $allowTypes = array('jpg', 'png', 'jpeg', 'gif');
        if (in_array($fileType, $allowTypes)) {
            if (move_uploaded_file($_FILES['dog_image']['tmp_name'], $targetFilePath)) {
                // แทรกข้อมูลลงใน dogimages พร้อมกับ dogID
                $insert = $conn->query("INSERT INTO dogimages(dogID, image) VALUES ('".$dogID."', '".$image."')");
                if ($insert) {
                    $_SESSION['statusMsg'] = "อัพโหลดภาพสำเร็จ.";
                } else {
                    $_SESSION['statusMsg'] = "เกิดข้อผิดพลาดในการอัพโหลดภาพ.";
                }
            } else {
                $_SESSION['statusMsg'] = "มีข้อผิดพลาดในการอัพโหลดไฟล์.";
            }
        } else {
            $_SESSION['statusMsg'] = "ขอโทษ, อนุญาตให้เฉพาะไฟล์ภาพ.";
        }
        header("Location: servicedogdetail.php?id=$dogID");
        exit();
    }
}
// Fetch receipt images specific to the dogID
$query = $conn->prepare("SELECT * FROM dogreceipt WHERE dogID = ? ORDER BY uploaded_on DESC");
$query->bind_param("i", $dogID);
$query->execute();
$result = $query->get_result();

$images = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $images[] = 'eslip/' . $row['deslip'];
    }
}


// Close the connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Pet care service</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <link rel="icon" href="img/logoic.png" type="image/gif" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins&family=Roboto:wght@700&display=swap" rel="stylesheet">  
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <style>
        .custom-select {
        width: 200px;
        padding: 10px;
        border: 2px solid #343434 /* สีเขียว */
        border-radius: 5px;
        background-color: #f9f9f9; /* สีพื้นหลัง */
        font-size: 16px;
        appearance: none; /* เอาเครื่องหมายลูกศรออก */
        background-image: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16"><path fill="%234CAF50" d="M8 11.5L3 6h10L8 11.5z"/></svg>'); /* เพิ่มลูกศร */
        background-repeat: no-repeat;
        background-position: right 10px center; /* วางลูกศร */
        background-size: 12px; /* ขนาดลูกศร */
        cursor: pointer;
    }

    .custom-select:hover {
        border-color: #343434; 
    }
         .card-img {
            width: 300px; /* ปรับขนาดตามความกว้างของบรรจุภัณฑ์ */
            height: auto; /* รักษาสัดส่วน */
        }
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
    <?php if (isset($_SESSION['adminID'])): ?>
    <nav class="navbar navbar-expand-lg navbar-light shadow-sm " style="background-color:#343434;">
        <a href="adminindex.php" class="navbar-brand ms-lg-5">
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

    <div class="container">
        <h3 class="mt-4 text-center">ข้อมูลการชำระเงิน</h3>
        <hr>
        <form action="dogstatus.php" method="post" enctype="multipart/form-data" id="dogServiceForm" onsubmit="return validateForm()">
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
                <?php echo htmlspecialchars($dogDetail['dogname']); ?><br>
                <label for="doggender" class="form-label ">เพศ :</label>
                <?php echo htmlspecialchars($dogDetail['doggender']); ?><br>
                <label for="dogage" class="form-label ">อายุ :</label>
                <?php echo htmlspecialchars($dogDetail['dogage']); ?><br>
                <label for="dogspicies" class="form-label">สายพันธุ์ :</label>
                <?php echo htmlspecialchars($dogDetail['dogspicies']); ?><br>
                <label for="dogbark" class="form-label">เห่าเวลาที่เห็นสุนัขตัวอื่นหรือไม่ :</label>
                <?php echo htmlspecialchars($dogDetail['dogbark']); ?><br>
                <label for="dogbehavior" class="form-label">ลักษณะนิสัย :</label>
                <?php echo htmlspecialchars($dogDetail['dogbehavior']); ?><br>
                <label for="dogtick" class="form-label">มีเห็บ-หมัดหรือไม่ :</label>
                <?php echo htmlspecialchars($dogDetail['dogtick']); ?><br>
                <label for="dogcongen" class="form-label">โรคประจำตัว :</label>
                <?php echo htmlspecialchars($dogDetail['dogcongen']); ?><br>
                <label for="dogvac" class="form-label">รับวัคซีนครบหรือไม่ :</label>
                <?php echo htmlspecialchars($dogDetail['dogvac']); ?><br>
                <label for="dogrs" class="form-label">เลี้ยงระบบปิดหรือระบบเปิด :</label>
                <?php echo htmlspecialchars($dogDetail['dogrs']); ?><br>
                <label for="dogtrans" class="form-label">ต้องการให้ รับ-ส่งหรือไม่ :</label>
                <?php echo htmlspecialchars($dogDetail['dogtrans']); ?><br>
                <label for="dogservices" class="form-label">เลือกบริการ :</label>
                <?php echo htmlspecialchars($dogDetail['dogservices']); ?><br>
                <h6 class="mt-4 ">ระยะเวลา</h6>
                <label for="ddatetimestartd" class="form-label">ตั้งแต่ :</label>
                <?php echo htmlspecialchars($dogDetail['ddatetimestartd']); ?><br>
                <label for="ddatetimeendd" class="form-label">ถึง :</label>
                <?php echo htmlspecialchars($dogDetail['ddatetimeendd']); ?><br>
            </div><br>
            <div class="mb-3">
                <h4 class="mt-4 ">ข้อมูลเจ้าของสุนัข</h4>
                <label for="username" class="form-label">ชื่อ :</label>
                <?php echo htmlspecialchars($dogDetail['username']); ?><br>
                <label for="phone" class="form-label">หมายเลขโทรศัพท์ :</label>
                <?php echo htmlspecialchars($dogDetail['phone']); ?><br>
                <label for="facebook" class="form-label">Facebook :</label>
                <?php echo htmlspecialchars($dogDetail['facebook']); ?><br>
                <label for="line" class="form-label">Line :</label>
                <?php echo htmlspecialchars($dogDetail['line']); ?><br>
            </div>
            <div class="mb-3">
                <h4 class="mt-4">ชำระเงิน</h4>
                <input type="hidden" name="dogID" value="<?php echo htmlspecialchars($dogDetail['dogID']); ?>">
                <label for="total_price" class="form-label">ยอดชำระเงินทั้งหมด :</label>
                <?php echo htmlspecialchars($dogDetail['total_price']); ?><br>
                <label for="deslip" class="form-label">รายละเอียดการชำระเงิน :</label>
                <?php if (!empty($images)): ?>
                <?php foreach ($images as $imageURL): ?>
                    <div class="col-sm-6 col-lg-4 col-xl-3">
                        <div class="card shadow h-100">
                            <img src="<?php echo $imageURL ?>" alt="" width="100%" class="card-img">
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No image found...</p>
            <?php endif; ?>
            </div>
            <select name="status" class="custom-select" id="status">
        <option value="กำลังตรวจสอบ" <?php if ($dogDetail['status'] == 'กำลังตรวจสอบ') echo 'selected'; ?>>กำลังตรวจสอบ</option>
        <option value="กำลังดำเนินการ" <?php if ($dogDetail['status'] == 'กำลังดำเนินการ') echo 'selected'; ?>>กำลังดำเนินการ</option>
        <option value="สำเร็จ" <?php if ($dogDetail['status'] == 'สำเร็จ') echo 'selected'; ?>>สำเร็จ</option>
        <option value="ยกเลิก" <?php if ($dogDetail['status'] == 'ยกเลิก') echo 'selected'; ?>>ยกเลิก</option>
    </select><br>
        <button type="submit" name="dogstatus" class="btn1">Submit</button>
        </form>
        <form action="upload_dog_image.php" method="post" enctype="multipart/form-data">
            <input type="hidden" name="dogID" value="<?php echo htmlspecialchars($dogDetail['dogID']); ?>">
            <label for="image">เลือกภาพสุนัข:</label>
            <input type="file" name="image" id="image" >
            <button type="submit" name="upload_image" class="btn1">อัปโหลด</button>
        </form>
        <div class="row">
            <?php  if (!empty($_SESSION['statusMsg'])) { ?>
                <div class="alert alert-success" role="alert">
                    <?php 
                        echo $_SESSION['statusMsg']; 
                        unset($_SESSION['statusMsg']);
                    ?>
                </div>
            <?php } ?>
        </div>
        <hr>
    </div>
    <?php endif; ?>
</body>
</html>
