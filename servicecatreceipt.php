<?php 

session_start();
include('config/connect.php'); 

// File upload path
$targetDir = "eslip/";

if (isset($_POST['servicecatreceipt'])) {
    if (!empty($_FILES["ceslip"]["name"]) && !empty($_POST['catID'])) {
        $ceslip = basename($_FILES["ceslip"]["name"]);
        $targetFilePath = $targetDir . $ceslip;
        $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);
        $catID = $_POST['catID']; // รับค่า catID จากแบบฟอร์ม

        // Allow certain file formats
        $allowTypes = array('jpg', 'png', 'jpeg', 'gif', 'jfif');
        if (in_array($fileType, $allowTypes)) {
            if (move_uploaded_file($_FILES['ceslip']['tmp_name'], $targetFilePath)) {
                // แทรกข้อมูลลงใน catreceipt พร้อมกับ catID
                $insert = $conn->query("INSERT INTO catreceipt(catID, ceslip, uploaded_on) VALUES ('".$catID."', '".$ceslip."', NOW())");
                if ($insert) {
                    $_SESSION['statusMsg'] = "The file <b>" . $ceslip . "</b> has been uploaded successfully.";
                    header("location: history.php");
                } else {
                    $_SESSION['statusMsg'] = "File upload failed, please try again.";
                    header("location: catpay.php");
                }
            } else {
                $_SESSION['statusMsg'] = "Sorry, there was an error uploading your file.";
                header("location: catpay.php");
            }
        } else {
            $_SESSION['statusMsg'] = "Sorry, only JPG, JPEG, PNG & GIF files are allowed to upload.";
            header("location: catpay.php");
        }
    } else {
        $_SESSION['statusMsg'] = "Please select a file to upload and provide a valid cat ID.";
        header("location: index.php");
    }
}

?>
