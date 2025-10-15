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
    <title>Profile</title>
</head>
<body>
    <?php include '../components/header.php';?>
    <?php include '../components/sidebar.php'; ?>
    <h1>Profile page</h1>

     <main id="home">
        <section>
        <h2>Welcome this is Profile page</h2>
        <p>This is the main content area beside the sidebar.</p>
        </section>
    </main>
</body>
</html>