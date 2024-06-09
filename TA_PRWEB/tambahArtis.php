<?php
include 'conf/connection.php';
session_start();

if (!isset($_SESSION['user_email']) || $_SESSION['user_email'] !== 'admin@gmail.com') {
    echo "<script>
    alert('You must login first!');
    window.location.href='index.php';
    </script>";
    exit();
}

if (isset($_POST['submitArtis'])) {
    $artistNames = $_POST['nama_artis'];
    $datakonser_id = $_POST['datakonser_id'];
    $success = "";
    $error = "";

    foreach ($artistNames as $nama_artis) {
        $nama_artis = mysqli_real_escape_string($conn, $nama_artis);
        $query = "INSERT INTO artis (nama_artis, datakonser_id) VALUES ('$nama_artis', '$datakonser_id')";
        if (mysqli_query($conn, $query)) {
            $success .= "Artis $nama_artis berhasil ditambahkan.<br>";
        } else {
            $error .= "Error: " . $query . "<br>" . mysqli_error($conn) . "<br>";
        }
    }

    header("Location: {$_SERVER['HTTP_REFERER']}");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Artis</title>
    <link rel="stylesheet" href="asset/style/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.0-2/css/all.min.css" integrity="sha256-46r060N2LrChLLb5zowXQ72/iKKNiw/lAmygmHExk/o=" crossorigin="anonymous" />
</head>
<body>
    <div id="navbar">
        <nav>
            <div class="logo"><img src="asset/img/AVH_white.png" alt="Logo" onclick="window.location.href='index.php'"></div>
            <div class="openMenu"><i class="fa fa-bars"></i></div>
            <ul class="mainMenu">
                <li><a href="index.php">Home</a></li>
                <li><a href="ticket.php">Ticket</a></li>
                <?php
                    if (isset($_SESSION['user_email']) && $_SESSION['user_email'] === 'admin@gmail.com') {
                        echo '<li><a href="inputdata.php">Input</a></li>';
                    }
                ?> 
                <li><a href="#">About</a></li>
                <li id='pencarian'>
                    <form action="search.php" method="post">
                        <input type="text" name="search" id="search" placeholder="Search">
                        <button type="submit" id="searchb"><i class="fa-solid fa-magnifying-glass" style="color: #ffffff;"></i></button>
                    </form>
                </li>
                <div class="closeMenu"><i class="fa fa-times"></i></div>
                <span class="icons">
                    <i class="fab fa-github"></i>
                </span>
                <div class="dropdown">
                    <button onclick="myFunction()" class="dropbtn"><i class="fa-solid fa-user"></i></button>
                    <div id="myDropdown" class="dropdown-content">
                        <?php if (isset($_SESSION['user_email'])): ?>
                            <li><a href="#" class="nav-link"><?php echo $_SESSION['user_email']; ?></a></li>
                            <li><a href="riwayat.php" class="nav-link">Riwayat</a></li>
                            <li><a href="conf/logout.php" class="nav-link">Logout</a></li>
                        <?php else: ?>
                            <li><a href="masuk.php" class="nav-link">Login</a></li>
                        <?php endif; ?>
                    </div>
                </div>
            </ul>
        </nav>
    </div>
    <div class="form_tambahartis">
        <form action="tambahArtis.php" method="POST">
            <h1>Tambah Nama Artis</h1><br><br>
            <label for="datakonser_id">Pilih Konser:</label>
            <select name="datakonser_id" id="datakonser_id">
                <?php
                $query_konser = "SELECT datakonser_id, nama_konser FROM data_konser";
                $result_konser = mysqli_query($conn, $query_konser);
                while ($row_konser = mysqli_fetch_assoc($result_konser)) {
                    echo '<option value="' . $row_konser['datakonser_id'] . '">' . $row_konser['nama_konser'] . '</option>';
                }
                ?>
            </select><br><br>
            <label for="jumlah">Jumlah Artis</label>
            <input type="number" name="jumlah" id="jumlah" min="1">
            <button type="submit" name="submitJumlah">Tentukan</button><br><br>
            <?php
            if (isset($_POST['submitJumlah']) && isset($_POST['jumlah']) && $_POST['jumlah'] > 0) {
                $jumlah = intval($_POST['jumlah']);
                for ($i = 1; $i <= $jumlah; $i++) {
                    echo '<label for="nama' . $i . '">Nama Artis ' . $i . ':</label><br>';
                    echo '<input type="text" name="nama_artis[]" id="nama' . $i . '" required><br><br>';
                }
                echo '<input type="hidden" name="datakonser_id" value="' . $_POST['datakonser_id'] . '">';
                echo '<button type="submit" name="submitArtis">Submit</button>';
            }
            ?>
        </form>
    </div>
</body>
<script src="https://kit.fontawesome.com/ef9e5793a4.js" crossorigin="anonymous"></script>
<script src="asset/js/script.js"></script>
</html>
