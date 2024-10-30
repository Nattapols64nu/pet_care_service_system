<?php 
    session_start();
    include('config\connect.php'); 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>ไอ้เพื่อนรัก</title>
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
        .container{
            max-width: 500px;
            max-height: 750px;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-top: 10px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
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
            width: 450px;
            height: 45px;
            line-height: 0px;
        }
    </style>
    <script>
        function validatePhoneNumber(event) {
            const input = event.target;
            const value = input.value;
            // Remove non-numeric characters
            const numericValue = value.replace(/[^0-9]/g, '');
            // Update the input value with numeric characters only
            input.value = numericValue;

            // Show an error message if the length is not 10
            const errorMessage = document.getElementById('error-message');
            if (numericValue.length !== 10) {
                errorMessage.textContent = 'Phone number must be exactly 10 digits.';
            } else {
                errorMessage.textContent = '';
            }
        }
    </script>

</head>

<body>
    <!-- Navbar Start -->
    <nav class="navbar navbar-expand-lg navbar-light shadow-sm " style="background-color:#343434;">
        <a href="index.html" class="navbar-brand ms-lg-5">
            <h1 class="m-0 text-uppercase text-light"><font size="6" >ไอ้เพื่อนรัก</font></h1>
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
        <h3 class="mt-4 text-center">ลงทะเบียน</h3>
        <hr>
        <form action="admindb.php" method="post">
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
                <label for="adminID" class="form-label">admin ID</label>
                <input type="text" class="form-control" name="adminID" required>
                <label for="adminpassword" class="form-label">รหัสผ่าน</label>
                <input type="password" class="form-control" name="adminpassword" required>
                <button type="submit" name="reg_admin" class="btn1" >ลงทะเบียน</button>
            </div>
        </form>
        <hr>
    </div>

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>

    <!-- Template Javascript -->
    <script src="js/main.js"></script>
</body>

</html>