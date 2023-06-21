<?php
$host = "sql303.infinityfree.com";
$user = "if0_34470267";
$pass = "OFaJrMLGaOJW";
$db_name = "if0_34470267_db_buku_uas"; //nama database
$conn = mysqli_connect($host, $user, $pass, $db_name); //pastikan urutan nya seperti ini, jangan tertukar

if (!$conn) { //jika tidak terkoneksi maka akan tampil error
  die("Connection Failed: " . mysql_connect_error());
}
