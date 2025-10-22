<?php 

    include '../db_connection.php';



    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        $fullname = trim($_POST['fullname']);
        $email = $_POST['email'];
        $phonenumber = $_POST['phonenumber'];
        $message = $_POST['message'];


        $sql = "INSERT INTO contact (fullname,email,phone_number,message) VALUES (?,?,?,?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('ssss',$fullname,$email, $phonenumber, $message);
        
        if($stmt->execute()){
            header("Location: ../index.html?success=1");
            exit();
            
        }else {
            header("Location: ../index.html?error=1");
            exit();
            
        }
        
        $stmt->close();
        $conn->close();
    }


?>