<?php
    include 'conf/connection.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AVH Tickets</title>
    <link rel="stylesheet" href="asset/style/login.css">

</head>
<body>
    <div class="container">
        <div class="login">
            <h1>Login Form</h1>
            <form name="form" action="conf/login.php" method="POST">
                <div class="input-box">
                    <input type="email" name="email" placeholder="Email" required>
                    <i class="fa fa-envelope"></i>
                </div>

                <div class="input-box">
                    <input type="password" name="password" placeholder="Password" required>
                    <i class="fa fa-lock"></i>
                </div>

                <button type="submit" name="submit" value="login">LOGIN</button>

                <div class="links">
                    <a href="daftar.php">Sign Up Here!</a>
                </div>
            </form>
        </div>
    </div>
</body>
<script src="asset/js/script.js"></script>
<script src="https://kit.fontawesome.com/ef9e5793a4.js" crossorigin="anonymous"></script>
</html>