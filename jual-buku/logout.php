<?php
    session_start();
    // Destroy session
    if(session_destroy()) {
        // Redirecting To Home Page
        echo "<script>alert('anda berhasil logout');window.location='index.php';</script>";
    }
?>