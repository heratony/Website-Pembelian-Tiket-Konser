<?php
include 'conf/connection.php';
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_email']) || $_SESSION['user_email'] !== 'admin@gmail.com') {
    echo "<script>
    alert('You must login first!');
    window.location.href='index.php';
    </script>";
    exit();
}

// Handle form submission to add stage
if (isset($_POST['submitStage'])) {
    $datakonser_id = $_POST['datakonser_id'];
    $gambarStage = $_FILES['gambar_stage'];
    $maps = $_POST['maps'];

    $gambarName = $_FILES['gambar_stage']['name'];
    $gambarTmpName = $_FILES['gambar_stage']['tmp_name'];
    $gambarSize = $_FILES['gambar_stage']['size'];
    $gambarError = $_FILES['gambar_stage']['error'];
    $gambarType = $_FILES['gambar_stage']['type'];

    $gambarExt = explode('.', $gambarName);
    $gambarActualExt = strtolower(end($gambarExt));

    $allowed = array('jpg', 'jpeg', 'png');

    if (in_array($gambarActualExt, $allowed)) {
        if ($gambarError === 0) {
            if ($gambarSize < 5000000) { // 5MB
                $gambarNameNew = uniqid('', true) . "." . $gambarActualExt;
                $gambarDestination = 'asset/tmp/stage/' . $gambarNameNew;
                move_uploaded_file($gambarTmpName, $gambarDestination);

                $query = "INSERT INTO stage (datakonser_id, gambar_stage, maps) VALUES ('$datakonser_id', '$gambarNameNew', '$maps')";
                if (mysqli_query($conn, $query)) {
                    $success = "Stage berhasil ditambahkan.";
                } else {
                    $error = "Error: " . $query . "<br>" . mysqli_error($conn);
                }
            } else {
                $error = "File terlalu besar!";
            }
        } else {
            $error = "Ada error saat mengupload file!";
        }
    } else {
        $error = "Format file tidak didukung!";
    }

    // Redirect back to the previous page after submission
    header("Location: {$_SERVER['HTTP_REFERER']}");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Stage</title>
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
    <div class="form_tambahstage">
        <form action="tambahStage.php" method="POST" enctype="multipart/form-data">
            <h1>Tambah Stage</h1><br><br>
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
            <label for="gambar_stage">Gambar Stage:</label>
            <input type="file" name="gambar_stage" id="gambar_stage" required><br><br>
            <label for="maps">Maps:</label>
            <textarea name="maps" id="maps" cols="30" rows="10" required></textarea><br><br>
            <button type="submit" name="submitStage">Submit</button>
        </form>
    </div>
</body>
<script src="https://kit.fontawesome.com/ef9e5793a4.js" crossorigin="anonymous"></script>
<script src="asset/js/script.js"></script>
</html>
