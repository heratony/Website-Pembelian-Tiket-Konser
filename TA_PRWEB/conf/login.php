<?php
include 'connection.php';
session_start();

if (isset($_POST['submit'])) {
    $email = $_POST['email'];
    $pass = $_POST['password'];
    $query = "SELECT * FROM user WHERE user_email='$email' AND user_password='$pass'";
    $result = mysqli_query($conn, $query);
    $data = mysqli_fetch_assoc($result);
    
    if (mysqli_num_rows($result) > 0) {
        // Simpan user_id ke session
        $_SESSION['user_id'] = $data['user_id'];
        $_SESSION['user_email'] = $data['user_email'];
        $_SESSION['user_password'] = $data['user_password'];
        setcookie("user_email", $data['user_email'], time() + 3600);
        setcookie("user_password", $data['user_password'], time() + 3600);

        // Periksa apakah URL sebelumnya disimpan dalam sesi
        if (isset($_SESSION['redirect_url'])) {
            $redirect_url = $_SESSION['redirect_url'];
            unset($_SESSION['redirect_url']); // Hapus URL dari sesi setelah digunakan
        } else {
            $redirect_url = '../index.php'; // Ganti dengan halaman default jika tidak ada URL sebelumnya
        }

        // Redirect ke halaman sebelumnya atau halaman default
        header("Location: $redirect_url");
        exit();
    } else {
        echo "<script>
            alert('Invalid Email or Password');
            window.location.href='../masuk.php?eror';
            </script>";
    }
}
?>
