<?php 
    include '../db_connection.php';
    session_start();
    $user_id = $_SESSION['user_id'];
    if(!isset($_SESSION['user_id'])){
        header("Location: ../Pages/login.php");
        exit();
    }

    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        $username = trim($_POST['username']);
        $email    = trim($_POST['email']);
        $age      = isset($_POST['age']) ? (int)$_POST['age'] : null;
        $gender   = trim($_POST['gender']);


        $conn->begin_transaction();

        try {
    // ✅ Update users table
    $stmt1 = $conn->prepare("UPDATE users SET username = ?, email = ? WHERE id = ?");
    $stmt1->bind_param("ssi", $username, $email, $user_id);
    $stmt1->execute();

    // ✅ Check if profile exists
    $check = $conn->prepare("SELECT user_id FROM profile WHERE user_id = ?");
    $check->bind_param("i", $user_id);
    $check->execute();
    $result = $check->get_result();

    if ($result->num_rows > 0) {
        // 🟢 Update existing profile
        $stmt2 = $conn->prepare("UPDATE profile SET age = ?, gender = ? WHERE user_id = ?");
        $stmt2->bind_param("isi", $age, $gender, $user_id);
    } else {
        // 🔵 Insert new profile
        $stmt2 = $conn->prepare("INSERT INTO profile (user_id, age, gender) VALUES (?, ?, ?)");
        $stmt2->bind_param("iis", $user_id, $age, $gender);
    }
    $stmt2->execute();

    // ✅ Commit both
    $conn->commit();

    echo "✅ Profile updated successfully!";
    header("Location: ../Pages/profile.php");
    exit();
} catch (Exception $e) {
    $conn->rollback();
    echo "❌ Error updating profile: " . $e->getMessage();
}
    }



?>