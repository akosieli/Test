<?php
    include '../db_connection.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <link rel="stylesheet" href="../css/style.css">
    <style>
        body {
            background: var(--gray);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .auth-container {
            background: var(--wight);
            padding: 3rem 2.5rem 2rem 2.5rem;
            border-radius: 1.2rem;
            box-shadow: 0 8px 32px 0 rgba(1, 136, 223, 0.10);
            width: 370px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .auth-container h2 {
            margin-bottom: 2rem;
            color: var(--blue);
            font-size: 2.8rem;
            font-weight: 700;
            letter-spacing: 1px;
        }
        .auth-container label {
            align-self: flex-start;
            margin-bottom: 0.4rem;
            margin-top: 1rem;
            color: var(--black);
            font-size: 1.5rem;
            font-weight: 500;
        }
        .auth-container input[type="text"],
        .auth-container input[type="email"],
        .auth-container input[type="password"] {
            width: 100%;
            padding: 1rem 1.2rem;
            margin-bottom: 0.5rem;
            border: 1.5px solid var(--gray);
            border-radius: 0.7rem;
            font-size: 1.5rem;
            background: #f8f9fa;
            transition: border 0.2s;
            outline: none;
            color: var(--black);
        }
        .auth-container input[type="text"]:focus,
        .auth-container input[type="email"]:focus,
        .auth-container input[type="password"]:focus {
            border: 1.5px solid var(--blue);
            background: var(--wight);
        }
        .auth-container button {
            width: 100%;
            padding: 1rem;
            background: var(--blue);
            color: var(--wight);
            border: none;
            border-radius: 0.7rem;
            font-size: 1.7rem;
            font-weight: 600;
            cursor: pointer;
            margin-top: 1.2rem;
            box-shadow: 0 2px 8px rgba(1,136,223,0.08);
            transition: background 0.2s, color 0.2s, letter-spacing 0.2s;
        }
        .auth-container button:hover {
            background: var(--wight);
            color: var(--blue);
            letter-spacing: .2rem;
            border: .1rem solid var(--blue);
        }
        .login-link {
            text-align: center;
            margin-top: 1.5rem;
            font-size: 1.4rem;
        }
        .login-link a {
            color: var(--blue);
            text-decoration: none;
            font-weight: 500;
            transition: color 0.2s;
        }
        .login-link a:hover {
            color: var(--black);
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="auth-container">
        <h2>Create Account</h2>
        <?php 
            if(isset($_POST['submit'])){
                $username = $conn->real_escape_string($_POST['username']);
                $email = $conn->real_escape_string($_POST['email']);
                $password = $conn->real_escape_string($_POST['password']);

                $confirm_password = $conn->real_escape_string($_POST['confirm_password']);

                if($password !== $confirm_password){
                    echo "Password Not Match";
                }else{
                    $hashed_password = password_hash($password, PASSWORD_BCRYPT);
                    $sql = "INSERT INTO users (username,email,password) VALUES ('$username','$email','$hashed_password')";
                    $result = $conn->query($sql);
                    if($result === TRUE){
                        echo "User registered successfully";
                        header("Location: login.php");
                        die();
                    }else{
                        echo "Failed to create user: " . $conn->error;
                    }

                }
            }
        
        
        
        ?>



        <form method="POST" autocomplete="off">
            <label for="username">Username</label>
            <input type="text" id="username" name="username" required autocomplete="username">

            <label for="email">Email</label>
            <input type="email" id="email" name="email" required autocomplete="email">

            <label for="password">Password</label>
            <input type="password" id="password" name="password" required autocomplete="new-password">

            <label for="confirm_password">Confirm Password</label>
            <input type="password" id="confirm_password" name="confirm_password" required autocomplete="new-password">

            <button type="submit" class="button" name="submit">Sign Up</button>
        </form>
        <div class="login-link">
            <span>Already have an account? </span>
            <a href="login.php">Sign in</a>
        </div>
    </div>
</body>
</html>