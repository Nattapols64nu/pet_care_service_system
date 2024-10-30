<?php 
session_start();
include('config/connect.php'); 

// เช็คการเข้าสู่ระบบ
if (!isset($_SESSION['email'])) {
    $_SESSION['msg'] = 'กรุณาเข้าสู่ระบบ';
    header('location: login.php');
    exit();
}

$email = $_SESSION['email'];

// ดึง userID จาก register
$sqlUser = "SELECT userID FROM register WHERE email = ?";
$stmtUser = $conn->prepare($sqlUser);
$stmtUser->bind_param("s", $email);
$stmtUser->execute();
$resultUser = $stmtUser->get_result();

if ($rowUser = $resultUser->fetch_assoc()) {
    $userID = $rowUser['userID'];

    // ดึงข้อมูลล่าสุดจาก dogservice ตาม userID
    $sqlDog = "SELECT * FROM dogservice WHERE userID = ? ORDER BY dogID DESC LIMIT 1";
    $stmtDog = $conn->prepare($sqlDog);
    $stmtDog->bind_param("i", $userID);
    $stmtDog->execute();
    $resultDog = $stmtDog->get_result();

    if ($resultDog->num_rows > 0) {
        $row = $resultDog->fetch_assoc();
        
        // ดึงข้อมูลที่ต้องการ
        $dogname = $row['dogname'];
        $doggender = $row['doggender'];
        $dogage = $row['dogage'];
        $dogspicies = $row['dogspicies'];
        $dogbark = $row['dogbark'];
        $dogbehavior = $row['dogbehavior'];
        $dogtick = $row['dogtick'];
        $dogcongen = $row['dogcongen'];
        $dogvac = $row['dogvac'];
        $dogrs = $row['dogrs'];
        $dogtrans = $row['dogtrans'];
        $dogservices = $row['dogservices'];
        $ddatetimestartd = $row['ddatetimestartd'];
        $ddatetimeendd = $row['ddatetimeendd'];
        $username = $row['username'];
        $phone = $row['phone'];
        $facebook = $row['facebook'];
        $line = $row['line'];
        $total_price = $row['total_price'];
    }

    $stmtDog->close();
} else {
    echo "ไม่พบผู้ใช้.";
    exit();
}

// ปิดการเชื่อมต่อ
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

    <div class="container">
        <h3 class="mt-4 text-center">ข้อมูลการชำระเงิน</h3>
        <hr>
        <form action="servicedogreceipt.php" method="post" enctype="multipart/form-data" id="dogServiceForm" onsubmit="return validateForm()">
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
                <?php echo $dogname; ?><br>
                <label for="doggender" class="form-label ">เพศ :</label>
                <?php echo $doggender; ?><br>
                <label for="dogage" class="form-label ">อายุ :</label>
                <?php echo $dogage; ?><br>
                <label for="dogspicies" class="form-label">สายพันธุ์ :</label>
                <?php echo $dogspicies; ?><br>
                <label for="dogbark" class="form-label">เห่าเวลาที่เห็นสุนัขตัวอื่นหรือไม่ :</label>
                <?php echo $dogbark; ?><br>
                <label for="dogbehavior" class="form-label">ลักษณะนิสัย :</label>
                <?php echo $dogbehavior; ?><br>
                <label for="dogtick" class="form-label">มีเห็บ-หมัดหรือไม่ :</label>
                <?php echo $dogtick; ?><br>
                <label for="dogcongen" class="form-label">โรคประจำตัว :</label>
                <?php echo $dogcongen; ?><br>
                <label for="dogvac" class="form-label">รับวัคซีนครบหรือไม่ :</label>
                <?php echo $dogvac; ?><br>
                <label for="dogrs" class="form-label">เลี้ยงระบบปิดหรือระบบเปิด :</label>
                <?php echo $dogrs; ?><br>
                <label for="dogtrans" class="form-label">ต้องการให้ รับ-ส่งหรือไม่ :</label>
                <?php echo $dogtrans; ?><br>
                <label for="dogservices" class="form-label">เลือกบริการ :</label>
                <?php echo $dogservices; ?><br>
                <h6 class="mt-4 ">ระยะเวลา</h6>
                <label for="ddatetimestartd" class="form-label">ตั้งแต่ :</label>
                <?php echo $ddatetimestartd; ?><br>
                <label for="ddatetimeendd" class="form-label">ถึง :</label>
                <?php echo $ddatetimeendd; ?><br>
            </div><br>
            <div class="mb-3">
                <h4 class="mt-4 ">ข้อมูลเจ้าของสุนัข</h4>
                <label for="username" class="form-label">ชื่อ :</label>
                <?php echo $username; ?><br>
                <label for="phone" class="form-label">หมายเลขโทรศัพท์ :</label>
                <?php echo $phone; ?><br>
                <label for="facebook" class="form-label">Facebook :</label>
                <?php echo $facebook; ?><br>
                <label for="line" class="form-label">Line :</label>
                <?php echo $line; ?><br>
            </div>
            <div class="mb-3">
                <h4 class="mt-4 ">ชำระเงิน</h4>
                <input type="hidden" name="dogID" value="<?php echo $row['dogID']; ?>">
                <label for="total_price" class="form-label">ยอดชำระเงินทั้งหมด :</label>
                <?php echo $total_price; ?><br>
                <img class="" src="img/getmoney.jfif" style="object-fit: cover; width: 300px; height: auto;"><br>
                <label for="deslip" class="form-label">แนบหลักฐานการชำระเงิน :</label>
                <input type="file" id="deslip" name="deslip" accept="image/*" onchange="validateFile()">
            </div>
            <button type="submit" name="servicedogreceipt" class="btn1">Submit</button>
        </form>
        <label for="cancel" class="form-label" style="color: red;">หากต้องการยกเลิกบริการ สามารถติดต่อได้ในช่องทางต่างๆของเรา </label>
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

    <script>
    function validateFile() {
        const input = document.getElementById('deslip');
        const file = input.files[0];

        if (file) {
            const fileType = file.type;
            const validTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/jfif'];

            if (!validTypes.includes(fileType)) {
                alert('โปรดเลือกไฟล์รูปภาพเท่านั้น (jpg, png, gif, jfif)');
                input.value = ''; // Clear the input
            }
        }
    }
    </script>
    <?php endif; ?>
</body>
</html>
