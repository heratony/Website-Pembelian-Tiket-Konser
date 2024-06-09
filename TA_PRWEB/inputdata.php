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
    $isLoggedIn = isset($_SESSION['user_email']) && $_SESSION['user_email'] !== null;
    $query = "SELECT user_nama FROM user WHERE user_email = '".$_SESSION['user_email']."'";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
    $user_nama = $row['user_nama'];
    $_GET['user_nama'] = $user_nama;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AVH Tickets</title>
    <link rel="stylesheet" href="asset/style/style.css">
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
                <!-- <li><a href="conf/logout.php" class="nav-link">Logout</a></li> -->
                <div class="closeMenu"><i class="fa fa-times"></i></div>
                <span class="icons">
                    <i class="fab fa-github"></i>
                </span>
                <div class="dropdown">
                    <button onclick="myFunction()" class="dropbtn"><i class="fa-solid fa-user"></i></button>
                    <div id="myDropdown" class="dropdown-content">
                        <?php if ($isLoggedIn): ?>
                            <li><a href="#" class="nav-link"><?php echo $_GET['user_nama'];?></a></li>
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
    <div id="inputdata">
        <div class="form_input">
            <form action="conf/insert.php" method="post" enctype="multipart/form-data">
                <table>
                    <tr>
                        <td><label for="nama_konser">Nama Konser</label></td>
                        <td>: <input type="text" name="nama_konser" id="nama_konser" required></td>
                    </tr>
                    <tr>
                        <td><label for="tgl">Tanggal</label></td>
                        <td>: <input type="date" name="tgl" id="tgl" required></td>
                    </tr>
                    <tr>
                        <td><label for="kota">Kota</label></td>
                        <td>: <input type="text" name="kota" id="kota" required></td>
                    </tr>
                    <tr>
                        <td><label for="lokasi">Lokasi</label></td>
                        <td>: <input type="text" name="lokasi" id="lokasi" required></td>
                    </tr>
                    <tr>
                        <td><label for="harga">Harga min</label></td>
                        <td>: <input type="text" name="harga_min" id="harga_min" required></td>
                    </tr>
                    <tr>
                        <td><label for="harga">Harga max</label></td>
                        <td>: <input type="text" name="harga_max" id="harga_max" required></td>
                    </tr>
                    <tr>
                        <td><label for="deskripsi">Deskripsi</label></td>
                        <td>: <input type="text" name="deskripsi" id="deskripsi" required></td>
                    </tr>
                    <tr>
                        <td><label for="gambar">Gambar</label></td>
                        <td>: <input type="file" name="gambar" id="gambar" required></td>
                    </tr>
                    <tr>
                        <td><button type="submit" name="input" value="input">Submit</button></td>
                    </tr>
                </table>
            </form>
        </div>
</body>
<script src="https://kit.fontawesome.com/ef9e5793a4.js" crossorigin="anonymous"></script>
<script src="asset/js/script.js"></script>
</html>