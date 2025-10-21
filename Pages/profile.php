<?php 
    session_start();
    include '../db_connection.php';
        
    if(!isset($_SESSION['user_id'])){
            header("Location: login.php");
            exit();
        }


        $user_id = $_SESSION['user_id'];

        $sql = "SELECT username, email FROM users WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        $stories_count = $conn->query("SELECT COUNT(*) AS total FROM stories WHERE user_id = $user_id")->fetch_assoc()['total'] ?? 0;
        $mood_count = $conn->query("SELECT COUNT(*) AS total FROM mood_logs WHERE user_id = $user_id")->fetch_assoc()['total'] ?? 0;
       
        $conn->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/dashboard.css" />
    <title>Profile</title>
</head>
<body>
    <?php include '../components/header.php';?>
    <?php include '../components/sidebar.php'; ?>
    <h1>Profile page</h1>

     <main id="home">
       
        <section>
            <header>
                <h2>👤 My Profile</h2>
                    
            </header>

            <div class="profile-container">
                <div class="profile-header">
                    <img src="../images/home.png" alt="Profile" width='200'>
                    <h2><?php echo htmlspecialchars($user['username']); ?></h2>
                    
                </div>

                <div class="info"><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></div>
                <div class="info"><strong>User ID:</strong> <?php echo $user_id; ?></div>

                <div class="stats">
                    <div>
                        <span><?php echo $stories_count; ?></span>
                        Stories Shared
                    </div>
                    <div>
                        <span><?php echo $mood_count; ?></span>
                        Mood Entries
                    </div>
                </div>

                <a href="edit_profile.php" class="edit-btn">✏️ Edit Profile</a>
            </div>
        </section>

    </main>
</body>
</html>