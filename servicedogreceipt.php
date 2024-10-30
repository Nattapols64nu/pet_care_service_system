<?php 

session_start();
include('config/connect.php'); 

// File upload path
$targetDir = "eslip/";

if (isset($_POST['servicedogreceipt'])) {
    if (!empty($_FILES["deslip"]["name"]) && !empty($_POST['dogID'])) {
        $deslip = basename($_FILES["deslip"]["name"]);
        $targetFilePath = $targetDir . $deslip;
        $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);
        $dogID = $_POST['dogID']; // รับค่า dogID จากแบบฟอร์ม

        // Allow certain file formats
        $allowTypes = array('jpg', 'png', 'jpeg', 'gif', 'jfif');
        if (in_array($fileType, $allowTypes)) {
            if (move_uploaded_file($_FILES['deslip']['tmp_name'], $targetFilePath)) {
                // แทรกข้อมูลลงใน dogreceipt พร้อมกับ dogID
                $insert = $conn->query("INSERT INTO dogreceipt(dogID, deslip, uploaded_on) VALUES ('".$dogID."', '".$deslip."', NOW())");
                if ($insert) {
                    $_SESSION['statusMsg'] = "The file <b>" . $deslip . "</b> has been uploaded successfully.";
                    header("location: history.php");
                } else {
                    $_SESSION['statusMsg'] = "File upload failed, please try again.";
                    header("location: dogpay.php");
                }
            } else {
                $_SESSION['statusMsg'] = "Sorry, there was an error uploading your file.";
                header("location: dogpay.php");
            }
        } else {
            $_SESSION['statusMsg'] = "Sorry, only JPG, JPEG, PNG & GIF files are allowed to upload.";
            header("location: dogpay.php");
        }
    } else {
        $_SESSION['statusMsg'] = "Please select a file to upload and provide a valid dog ID.";
        header("location: index.php");
    }
}

?>
