<?php
include '../db_connection.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    die("You must be logged in to upload an image.");
}

$user_id = $_SESSION['user_id'];

// Check if file is uploaded
if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] === UPLOAD_ERR_OK) {
    $file_name = $_FILES['profile_image']['name'];
    $tmp_name  = $_FILES['profile_image']['tmp_name'];

    // Create upload folder if it doesn’t exist
    $upload_dir = "../images/uploads/".$user_id . "/";
    if (!file_exists($upload_dir)) {
        mkdir($upload_dir, 0777, true);
    }

    // Path for storing image
    $image_path = $upload_dir . basename($file_name);

    // Move uploaded file to folder
    if (move_uploaded_file($tmp_name, $image_path)) {

        // Check if user already has a profile record
        $check = $conn->prepare("SELECT image_path FROM profile WHERE user_id = ?");
        $check->bind_param("i", $user_id);
        $check->execute();
        $result = $check->get_result();

        if ($result->num_rows > 0) {
            // 🟢 If profile exists — update image path
            $stmt = $conn->prepare("UPDATE profile SET image_path = ? WHERE user_id = ?");
            $stmt->bind_param("si", $image_path, $user_id);
            $stmt->execute();
        } else {
            // 🔵 If no profile yet — insert new row
            $stmt = $conn->prepare("INSERT INTO profile (user_id, image_path) VALUES (?, ?)");
            $stmt->bind_param("is", $user_id, $image_path);
            $stmt->execute();
        }

        echo "✅ Profile image saved successfully!";
        header("Location: ../Pages/profile.php");
        exit();
    } else {
        echo "❌ Failed to upload file.";
    }
} else {
    echo "❌ No file selected or upload error.";
}
?>
