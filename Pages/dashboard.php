<?php 
    session_start();

        if(!isset($_SESSION['user_id'])){
            header("Location: login.php");
            exit();
        }

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
            <h2>Welcome this is DASHBOARD</h2>
                                                    <!-- CARDS -->
            <div class="card-container">
                <div class="card">
                    <h1>Shared Story</h1>
                    <p>10</p>
                </div>
                <div class="card">
                    <h1>Likes</h1>
                    <p>10</p>
                </div>
                <div class="card">
                    <h1>No idea</h1>
                    <p>10</p>
                </div>
            </div>


            <div class="mood-container">
                <canvas id="moodChart"></canvas>
                
            </div>




        
        </section>
    </main>
  

</body>
</html>