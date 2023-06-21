<?php
include 'conn.php';
include 'auth.php'; //user access privileges
$id = $_GET["id"];
//mengambil id yang ingin dihapus

// Get User Id based on username
$sql = "SELECT id FROM users WHERE username='{$_SESSION["username"]}'";
$res = mysqli_query($conn, $sql);
$count = mysqli_num_rows($res);
if ($count > 0) {
    $row = mysqli_fetch_assoc($res);
    $user_id = $row["id"];
} else {
    $user_id = 0;
}
$sql = null;

    $apakahada = "SELECT * FROM books WHERE id='$id' AND user_id = '$user_id'";
    $result = mysqli_query($conn, $apakahada);

    $data = mysqli_fetch_assoc($result);

    //jalankan query DELETE untuk menghapus data
    $query = "DELETE FROM books WHERE id='$id' AND user_id = '$user_id'";
    $hasil_query = mysqli_query($conn, $query);

    //periksa query, apakah ada kesalahan
    
    if(!$data) {
      echo "<script>alert('Access Denied!');window.location='dashboard.php';</script>";
    } else {
      echo "<script>alert('Buku berhasil dihapus.');window.location='dashboard.php';</script>";
    }