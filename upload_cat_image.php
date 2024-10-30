<?php 
session_start();
include('config/connect.php'); 

if (isset($_POST['upload_image'])) {
    $catID = intval($_POST['catID']);
    $targetDir = "uploads/"; // โฟลเดอร์สำหรับเก็บรูป
    $image = basename($_FILES["image"]["name"]);
    $targetFilePath = $targetDir . $image;
    $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);
    
    // Allow certain file formats
    $allowTypes = array('jpg', 'png', 'jpeg', 'gif');
    if (in_array($fileType, $allowTypes)) {
        if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFilePath)) {
            // Insert image info into the database
            $insert = $conn->query("INSERT INTO catimages (catID, image) VALUES ('$catID', '$image')");
            if ($insert) {
                $_SESSION['statusMsg'] = "Uploaded successfully.";
            } else {
                $_SESSION['statusMsg'] = "Failed to save image info.";
            }
        } else {
            $_SESSION['statusMsg'] = "Error uploading your file.";
        }
    } else {
        $_SESSION['statusMsg'] = "Only JPG, JPEG, PNG & GIF files are allowed.";
    }
    header("location: servicecatdetail.php?id=$catID");
    exit();
}
?>
