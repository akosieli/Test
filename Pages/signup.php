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
            font-weight: lighter;
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
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
                $username = trim($_POST['username'] ?? '');
                $email    = trim($_POST['email'] ?? '');
                $password = $_POST['password'] ?? '';

                $confirm_password = $_POST['confirm_password'] ?? '';



                if ($username === '' || $email === '' || $password === '' || $confirm_password === '') {
                    $error = "Please fill all fields.";
                }elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    echo "Invalid email address.";
                }elseif($confirm_password !== $password){
                    echo "Password not Match!";
                }else {
                    
                    $stmt = $conn->prepare("SELECT id FROM users WHERE username = ? OR email = ?");
                    $stmt->bind_param("ss", $username, $email);
                    $stmt->execute();
                    $stmt->store_result();

                    if ($stmt->num_rows > 0) {
                        
                        $error = "Username or email already taken.";
                        echo $error;
                    } else {
                       
                        $hashed = password_hash($password, PASSWORD_DEFAULT);

                        $insert = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
                        $insert->bind_param("sss", $username, $email, $hashed);

                        if ($insert->execute()) {
                            
                            echo "Account created. You can now login.";
                            header("Location: login.php");
                        } else {
                            
                            if ($conn->error === 1062) { 
                                echo "Username or email already taken.";
                            } else {
                                echo "Database error: " . $conn->error;
                            }
                        }
                        $insert->close();
                    }
                    $stmt->close();
                }
}
        
        
        
        ?>



        <form method="POST" autocomplete="off">
            <label for="username" >Username</label>
            <input type="text" id="username" name="username" maxlength="8" required autocomplete="username">

            <label for="email">Email</label>
            <input type="email" id="email" name="email" required autocomplete="email">

            <label for="password">Password</label>
            <input type="password" id="password" name="password" required autocomplete="new-password">

            <label for="confirm_password">Confirm Password</label>
            <input type="password" id="confirm_password" name="confirm_password" required autocomplete="new-password">
            <p style="font-size: 15px;">Note: For your security, please use a unique account for this site.
                Do not use login details from your school, work, or other websites.
                We recommend creating a new password that you don’t use anywhere else.</p>

            <button type="submit" class="button" name="submit">Sign Up</button>
        </form>
        <div class="login-link">
            <span>Already have an account? </span>
            <a href="login.php">Sign in</a>
        </div>
    </div>
</body>
</html>