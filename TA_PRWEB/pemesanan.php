<?php
include 'conf/connection.php';
session_start();
if (!isset($_SESSION['user_email'])) {
    echo "<script>
    alert('You must login first!!');
    window.location.href='index.php';
    </script>";
}
$isLoggedIn = isset($_SESSION['user_email']) && $_SESSION['user_email'] !== null;
$query = "SELECT user_nama FROM user WHERE user_email = '".$_SESSION['user_email']."'";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($result);
$user_nama = $row['user_nama'];
$_GET['user_nama'] = $user_nama;

$concertId = isset($_GET['id']) ? $_GET['id'] : null;

$sql = "SELECT nama_konser FROM data_konser WHERE datakonser_id = ?";

try {
    if ($concertId) {
        $stmt_concert = $conn->prepare($sql);
        $stmt_concert->bind_param("i", $concertId);
        $stmt_concert->execute();
        $result_concert = $stmt_concert->get_result();
        $row_concert = $result_concert->fetch_assoc();
        $concertName = $row_concert['nama_konser'];

        $sql_ticket = "SELECT jenis, harga, stock FROM jenis_tiket WHERE datakonser_id = ?";
        $stmt_ticket = $conn->prepare($sql_ticket);
        $stmt_ticket->bind_param("i", $concertId);
        $stmt_ticket->execute();
        $result_ticket = $stmt_ticket->get_result();
        $ticketTypes = array();

        while ($row_ticket = $result_ticket->fetch_assoc()) {
            $ticketTypes[] = $row_ticket;
        }

        usort($ticketTypes, function ($a, $b) {
            return $a['harga'] - $b['harga'];
        });

        // Fetch the stage image
        $sql_stage = "SELECT gambar_stage FROM stage WHERE datakonser_id = ?";
        $stmt_stage = $conn->prepare($sql_stage);
        $stmt_stage->bind_param("i", $concertId);
        $stmt_stage->execute();
        $result_stage = $stmt_stage->get_result();
        $row_stage = $result_stage->fetch_assoc();
        $gambar_stage = $row_stage['gambar_stage'];
    }

    $stmt_concert->close();
    $stmt_ticket->close();
    $stmt_stage->close();

    // Check if the form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Get the selected ticket type and quantity from the form
        $selectedTicket = $_POST['jenistiket'];
        $selectedQuantity = $_POST['jumlah'];

        // Get the stock quantity for the selected ticket type
        $stockQuantity = 0;
        foreach ($ticketTypes as $ticket) {
            if ($ticket['jenis'] === $selectedTicket) {
                $stockQuantity = $ticket['stock'];
                break;
            }
        }

        // Compare the selected quantity with the available stock
        if ($selectedQuantity > $stockQuantity) {
            // If selected quantity exceeds available stock, display an alert
            $errorMessage = "Sorry, the selected quantity exceeds the available stock for this ticket type.";
        } else {
            // If quantity is within available stock, proceed with booking
            // Your booking logic here
            $errorMessage = ""; // Clear the error message if booking is successful
        }
    } else {
        $errorMessage = "";
    }
} catch (mysqli_sql_exception $e) {
    echo "Error: " . $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AVH Tickets</title>
    <link rel="stylesheet" href="asset/style/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        .content {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            padding: 20px;
        }

        .stage-image {
            flex: 1;
            margin-right: 20px;
        }

        .form-container {
            flex: 1;
        }

        .stage-image img {
            max-width: 100%;
            height: auto;
        }
    </style>
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
                    if (isset($_SESSION['email']) && $_SESSION['email'] === 'admin@gmail.com') {
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
                            <?php if ($isLoggedIn) : ?>
                                <li><a href="#" class="nav-link"><?php echo $_GET['user_nama']; ?></a></li>
                                <li><a href="riwayat.php" class="nav-link">Riwayat</a></li>
                                <li><a href="conf/logout.php" class="nav-link">Logout</a></li>
                            <?php else : ?>
                                <li><a href="masuk.php" class="nav-link">Login</a></li>
                            <?php endif; ?>
                        </div>
                    </div>
                </ul>
            </nav>
    </div>
    <div class="title">
        <h1><?php if (isset($concertName)) echo $concertName; ?></h1>
    </div>
    <div class="content_form">
        <div class="stage-image">
            <?php if (isset($gambar_stage)) : ?>
                <img src="asset/tmp/stage/<?php echo $gambar_stage; ?>" alt="Gambar Stage">
            <?php endif; ?>
        </div>
        <div class="form-container">
            <div id="input_pemesanan">
                <div class="form_pemesanan">
                    <form id="bookingForm" action="conf/log_pesan.php" method="post" enctype="multipart/form-data">
                        <table>
                            <tr>
                                <td><label for="nama_pemesan"><b>Nama</b></label></td>
                                <td>: <input type="text" name="nama_pemesan" id="nama_pemesan" required></td>
                            </tr>
                            <tr>
                                <td><label for="tlp_pemesan"><b>No Tlp</b></label></td>
                                <td>: <input type="number" name="tlp_pemesan" id="tlp_pemesan" required></td>
                            </tr>
                            <tr>
                                <td><label for="email_pemesan"><b>E-Mail</b></label></td>
                                <td>: <input type="email" name="email_pemesan" id="email_pemesan" required></td>
                            </tr>
                            <tr>
                                <td><label for="jenistiket"><b>Pilih Tiket</b></label></td>
                                <td>:
                                    <select name="jenistiket" id="jenistiket" required>
                                        <option value="" selected disabled><b>Pilih Jenis Tiket</b></option>
                                        <?php foreach ($ticketTypes as $type) : ?>
                                            <option value="<?php echo $type['jenis']; ?>"><?php echo $type['jenis']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td><label for="jumlah"><b>Jumlah</b></label></td>
                                <td>: <input type="number" name="jumlah" id="jumlah" value="1" required></td>
                            </tr>
                            <tr>
                                <td id="errorStock">
                                    <p></p>
                                </td>
                            </tr>
                            <tr>
                                <td><label for="harga"><b>Harga Satuan</b></label></td>
                                <td>: <input type="text" name="harga" id="harga" disabled></td>
                            </tr>
                            <tr>
                                <td><label for="total"><b>Total Harga</b></label></td>
                                <td>: <input type="text" name="total" id="total" disabled></td>
                            </tr>
                            <tr>
                                <td><button class="button_pesan" type="button" onclick="confirmBooking()">Pesan</button></td>
                            </tr>
                        </table>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script id="ticketData" type="application/json"><?php echo json_encode($ticketTypes); ?></script>
    <script src="asset/js/script.js"></script>
</body>

</html>
