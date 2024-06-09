<?php
    include 'connection.php';
    if(isset($_POST['signup'])) {
        $username = $_POST['username'];
        $email = $_POST['email'];
        $pass = $_POST['password'];
        $query = "INSERT INTO user(user_nama, user_email, user_password) VALUES('$username', '$email','$pass');";
        $result = mysqli_query($conn, $query);
        if($result) {
            header("Location: ../masuk.php");
        } else {
            echo "Failed to Sign Up!";
        }
    }
?>