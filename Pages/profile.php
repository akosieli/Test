<?php 
    session_start();
    include '../db_connection.php';
        
    if(!isset($_SESSION['user_id'])){
            header("Location: login.php");
            exit();
        }


        $user_id = $_SESSION['user_id'];

        $sql = "SELECT users.username, users.email, profile.image_path,profile.gender, profile.age FROM users LEFT JOIN profile ON users.id = profile.user_id WHERE users.id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        
       
        $conn->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/dashboard.css" />
    <link rel="stylesheet" href="../css/chatbot.css" />
    <script src="../js/chat.js" defer></script>
    <title>Profile</title>
</head>
<body>
    <?php include '../components/header.php';?>
    <?php include '../components/sidebar.php'; ?>
    

    
     <main id="home">
        <section>
            <div>
                <h2>👤 My Profile</h2>
                    
            </div>

            <div class="profile-container">
                <div class="profile-header">
                    <div class="image">

                    </div>
                    <div class="image-container">
                        <?php
                            // Check if user has an image; otherwise show default
                            $image_path = !empty($user['image_path']) && file_exists($user['image_path'])
                                ? $user['image_path']
                                : '../images/default.jpg';
                        ?>
                        <img src="<?php echo htmlspecialchars($image_path); ?>" alt="Profile" >
                    </div>
                    <div class="username-container">

                        <p><?php echo htmlspecialchars($user['username']); ?></p>
                    </div>
                </div>
                

                <div class="info">
                    <label for="user">User ID:
                        <p> <?php echo $user_id; ?></p>
                    </label>
                    
                    <label for="email">Email:

                        <p><?php echo htmlspecialchars($user['email']); ?></p>
                    </label>
                    
                    <label for="age">Age:

                        <p> <?php echo htmlspecialchars($user['age']); ?></p>
                    </label>
                    
                    <label for="gender">Gender:

                        <p> <?php echo htmlspecialchars($user['gender']); ?></p>
                    </label>
                </div>
               

                

                <a href="../Pages/profile_edit.php" class="edit-btn" style="margin-top: 10px; background-color: var(--blue); color: var(--wight);  border: solid 2px var(--blue); border-radius: 4px; height: 30px; width: 180px;">✏️ Edit Profile</a>
            </div>
        </section>
        <?php include '../Components/chat-bot.php'; ?>
    </main>
</body>
</html>