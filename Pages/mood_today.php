<?php 
    session_start();
    include '../db_connection.php';

        if(!isset($_SESSION['user_id'])){
            header("Location: login.php");
            exit();
        }


        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $user_id = $_SESSION['user_id'];
            $mood = $_POST['mood'];
            $mood_date = date('Y-m-d'); // today's date

    // Mood-value mapping (1–10)
            $moodValues = [
                "Happy" => 9,
                "Sad" => 2,
                "Angry" => 1,
                "Calm" => 6,
                "Tired" => 3,
                "Excited" => 10,
                "Anxious" => 4,
                "Bored" => 5,
                "Motivated" => 8,
                "Relaxed" => 7
            ];

             $mood_value = $moodValues[$mood] ?? 5;

            $sql = "INSERT INTO mood_logs (user_id, mood, mood_value, mood_date) VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("isis", $user_id, $mood, $mood_value, $mood_date);

            if ($stmt->execute()) {
                echo "Mood Submit Successfully";
                header("Location: mood_today.php");
            } else {
                echo "Error: " . $stmt->error;
            }

            $stmt->close();
            $conn->close();
        }





?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/dashboard.css" />
    <link rel="stylesheet" href="../css/chatbot.css" />
    <script src="../js/chat.js" defer></script>
    <title>Mood</title>
    <title>Mood</title>
</head>
<body>
    <?php include '../components/header.php';?>
    <?php include '../components/sidebar.php'; ?>
    

     <main id="home">
        <?php include '../Components/chat-bot.php'; ?>
        <section>
        <h2>What's your mood today?</h2>
        <div class="mood-card-container">
            <div class="mood-card">
                <h3>Excited <br>🤩</h3>
            </div>
            <div class="mood-card">
                <h3>Happy <br>😊</h3>
            </div>
            <div class="mood-card">
                <h3>Motivated <br>💪</h3>
            </div>
            <div class="mood-card">
                <h3>Relaxed <br>🧘</h3>
            </div>
            <div class="mood-card">
                <h3>Calm  <br>😌</h3>
            </div>
            <div class="mood-card">
                <h3>Bored <br>🥱</h3>
            </div>
            <div class="mood-card">
                <h3>Anxious <br>😰</h3>
            </div>
            <div class="mood-card">
                <h3>Tired <br>😴</h3>
            </div>
            <div class="mood-card">
                <h3>Sad <br>😢</h3>
            </div>
            <div class="mood-card">
                <h3>Angry <br>😡</h3>
            </div>
            
            
            
        </div>

        <div class="mood-form-container">
             <form method="POST">
                 <h2 style="margin-bottom: 10px;">Hello, <?php echo htmlspecialchars($_SESSION['username']); ?> 👋</h2>
                    <p>Select your mood today:</p>
        
                    <select name="mood" required>
                        <option value="">Select Mood</option>
                        <option value="Excited">🤩 Excited</option>
                        <option value="Happy">😊 Happy</option>
                        <option value="Motivated">💪 Motivated</option>
                        <option value="Relaxed">🧘 Relaxed</option>
                        <option value="Calm">😌 Calm</option>
                        <option value="Bored">🥱 Bored</option>
                        <option value="Anxious">😰 Anxious</option>
                        <option value="Tired">😴 Tired</option>
                        <option value="Sad">😢 Sad</option>
                        <option value="Angry">😡 Angry</option>
                    </select>

                    <button type="submit">Submit Mood</button>
            </form>

        </div>
        
        </section>
    </main>
</body>
</html>