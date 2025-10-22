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
                    <div class="form-image-container">

                       <form action="../Components/edit_profile_image.php" method="POST" enctype="multipart/form-data">
                            <input type="file" name="profile_image" required>
                            <button type="submit">Upload Image</button>
                        </form>
                    </div>
                    
                </div>
                
                

                <form action="../Components/edit_profile.php" method="POST" >
                        <p><strong>User ID:</strong> <?php echo $user_id; ?></p>
                        <label for="username">Username:

                            <input type="text" name="username" value="<?php  echo htmlspecialchars($user['username']); ?>">
                        </label>
                        
                        <label for="email">Email:

                            <input type="email" name="email" value="<?php  echo htmlspecialchars($user['email']); ?>">
                        </label>
                        <label for="age">Age:

                            <input type="number" name="age" min="13" max="100" value="<?php  echo htmlspecialchars($user['age']); ?>">
                        </label>
                        
                            <label for="gender">Gender:</label>
                            <select name="gender" id="gender" required>
                                <option value="">--Select Gender--</option>
                                <option value="Male" <?php if($user['gender'] === 'Male') echo 'selected'; ?>>Male</option>
                                <option value="Female" <?php if($user['gender'] === 'Female') echo 'selected'; ?>>Female</option>
                                <option value="Other" <?php if($user['gender'] === 'Other') echo 'selected'; ?>>Other</option>
                            </select>

                        <button type="submit">Submit</button>
                </form>
               

                

                
            </div>
        </section>
        <?php include '../Components/chat-bot.php'; ?>
    </main>
</body>
</html>