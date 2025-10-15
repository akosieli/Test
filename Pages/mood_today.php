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
    <link rel="stylesheet" href="../css/dashboard.css" />
    <title>Mood</title>
</head>
<body>
    <?php include '../components/header.php';?>
    <?php include '../components/sidebar.php'; ?>
    <h1>Mood Today</h1>

     <main id="home">
        <section>
        <h2>What's your mood today?</h2>
        <div class="mood-card-container">
            <div class="mood-card">
                <h3>Happy</h3>
            </div>
            <div class="mood-card">
                <h3>Happy</h3>
            </div>
            <div class="mood-card">
                <h3>Happy</h3>
            </div>
            <div class="mood-card">
                <h3>Happy</h3>
            </div><div class="mood-card">
                <h3>Happy</h3>
            </div>
            <div class="mood-card">
                <h3>Happy</h3>
            </div>
            
            
            
        </div>
        <input type="text">
        <button>Submit</button>
        </section>
    </main>
</body>
</html>