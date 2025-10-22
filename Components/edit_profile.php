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
        // Update users table
            $stmt1 = $conn->prepare("UPDATE users SET username = ?, email = ? WHERE id = ?");
            $stmt1->bind_param("ssi", $username, $email, $user_id);
            $stmt1->execute();

            // Update profiles table
            $stmt2 = $conn->prepare("UPDATE profile SET age = ?, gender = ? WHERE user_id = ?");
            $stmt2->bind_param("isi", $age, $gender, $user_id);
            $stmt2->execute();

            // Commit both changes
            $conn->commit();
                echo "✅ Profile updated successfully!";
                header("Location: ../Pages/profile.php");
            } catch (Exception $e) {
                // If error, rollback (undo both updates)
                $conn->rollback();
                echo "❌ Error updating profile: " . $e->getMessage();
            }

    }



?>