<?php
    session_start();
    if(!isset($_SESSION["username"])) {
        echo "<script>alert('Login atau Register dulu ya untuk menjual Buku disini!');window.location='login.php';</script>";
        exit();
    }
?>