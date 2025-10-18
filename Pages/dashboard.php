<?php 
    session_start();
    include '../db_connection.php';

        if(!isset($_SESSION['user_id'])){
            header("Location: login.php");
            exit();
        }

        $user_id = $_SESSION['user_id'];
        $stories_count = $conn->query("SELECT COUNT(*) AS total FROM stories WHERE user_id = $user_id")->fetch_assoc()['total'] ?? 0;
        $mood_count = $conn->query("SELECT COUNT(*) AS total FROM mood_logs WHERE user_id = $user_id")->fetch_assoc()['total'] ?? 0;
      
        $conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="../css/dashboard.css" />
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="../js/chart-script.js" defer></script>
</head>
<body>
    
    
    <?php include '../Components/header.php'; ?>
    <?php include '../Components/sidebar.php'; ?>

    

  

    <main id="home">
        <section >
            <h2>Dashboard</h2>
                                                    <!-- CARDS -->
            <div class="card-container">
                <div class="card">
                    <h1>Stories</h1>
                    <span><?php echo $stories_count ?></span>
                </div>
                <div class="card">
                    <h1>Mood</h1>
                    <span><?php echo $mood_count ?></span>
                </div>
                <div class="card">
                    <h1>Empty</h1>
                    <p>0</p>
                </div>
                <div class="card">
                    <h1>Empty</h1>
                    <p>0</p>
                </div>
            </div>


            <div class="mood-container">
                <canvas id="moodChart"></canvas>
                
            </div>




        
        </section>
    </main>
  

</body>
</html>