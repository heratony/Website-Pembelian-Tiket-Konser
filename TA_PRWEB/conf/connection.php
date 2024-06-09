<?php
    $conn = mysqli_connect("localhost", "root", "", "avh_database");
    if(!$conn) {
        die("Connection Failed: ".mysqli_connect_error());
    }
?>