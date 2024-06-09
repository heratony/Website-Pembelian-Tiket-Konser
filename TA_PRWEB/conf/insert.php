<?php
    include 'connection.php';
    if(isset($_POST['input'])) {
        $nama_konser = $_POST['nama_konser'];
        $lokasi = $_POST['lokasi'];
        $kota = $_POST['kota'];
        $harga_min = $_POST['harga_min'];
        $harga_max = $_POST['harga_max'];
        $tgl = $_POST['tgl'];
        $gambar = $_FILES['gambar']['name'];
        $tmp = $_FILES['gambar']['tmp_name'];
        $deskripsi = $_POST['deskripsi'];
        $path = "../asset/tmp/cover/".$gambar;
        move_uploaded_file($tmp, $path);
        $sql = "INSERT INTO data_konser (nama_konser, tanggal, lokasi, kota, harga_max, harga_min, gambar,deskripsi) VALUES ('$nama_konser', '$tgl', '$lokasi', '$kota', '$harga_max', '$harga_min', '$gambar','$deskripsi')";
        $result = mysqli_query($conn, $sql);
        if($result) {
            echo "<script>
                alert('Data berhasil ditambahkan');
                window.location.href='../inputdata.php';
                </script>";
        } else {
            echo "<script>
                alert('Data gagal ditambahkan');
                window.location.href='../inputdata.php';
                </script>";
        }
    }
?>