<?php 
    session_start();
    include '../db_connection.php';


        if(!isset($_SESSION['user_id'])){
            header("Location: login.php");
            exit();
        }

        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $user_id = $_SESSION['user_id'];
            $story = trim($_POST['story']);

            if (empty($story)) {
                echo "<script>alert('Story cannot be empty'); history.back();</script>";
                exit;
            }

        $sql = "INSERT INTO stories (user_id, story) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("is", $user_id, $story);

        if ($stmt->execute()) {
            echo "<script>
                    alert('Story shared successfully!');
                    window.location.href='share_story.php';
                </script>";
        } else {
            echo "Error: " . $stmt->error;
        }

    $stmt->close();
    
}


    $sql = "SELECT stories.story, stories.created_at, users.username 
            FROM stories 
            JOIN users ON stories.user_id = users.id 
            ORDER BY stories.created_at DESC";
    $result = $conn->query($sql);







?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/dashboard.css" />
    <title>Story</title>
</head>
<body>
    <?php include '../components/header.php';?>
    <?php include '../components/sidebar.php'; ?>
    

     <main id="home">
        <section>
            <div class="feed-container">

                <form  method="POST">
                    <h2>Share Your Story 🌻</h2>
                    <textarea name="story" placeholder="What's on your mind today?" required></textarea>
                    <button type="submit">Post Story</button>
                </form>
            </div>

            <div class="feed-container">
                <?php if ($result->num_rows > 0): ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <div class="story">
                            <div class="username" style="font-size: 1.5rem; background-color: var(--wight); width: 30%; border-radius: 4px; padding: 5px;">👤<?php echo htmlspecialchars($row['username']); ?></div>
                            <div class="date" style="font-size: 0.8rem;"><?php echo date("F j, Y, g:i a", strtotime($row['created_at'])); ?></div>
                            <div class="text" style="border: var(--wight) solid 2px; border-radius: 4px; padding: 10px; font-size: 0.8rem;"><?php echo nl2br(htmlspecialchars($row['story'])); ?></div>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <p class="no-story">No stories shared yet. Be the first to post!</p>
                <?php endif; ?>
            </div>


        </section>
        
        
    </main>
</body>
</html>