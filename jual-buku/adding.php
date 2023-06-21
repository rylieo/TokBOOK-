<?php
// memanggil file koneksi.php untuk melakukan koneksi database
include 'conn.php';
include 'auth.php'; //user access privileges

  if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
      die($_SERVER['REQUEST_METHOD'] . ' method access not permitted');
  } 
  
  // membuat variabel untuk menampung data dari form
  $book_name        = mysqli_real_escape_string($conn, $_POST['book_name']);
  $book_description = mysqli_real_escape_string($conn, $_POST['book_description']);
  $book_author      = mysqli_real_escape_string($conn, $_POST['book_author']);
  $book_price       = mysqli_real_escape_string($conn, $_POST['book_price']);
  $book_picture     = mysqli_real_escape_string($conn, $_FILES['book_picture']['name']);

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


//cek dulu jika ada gambar buku jalankan coding ini
if($book_picture != "") {
  $file_extension = array('png','jpg'); //ekstensi file gambar yang bisa diupload 
  $x = explode('.', $book_picture); //memisahkan nama file dengan ekstensi yang diupload
  $extension = strtolower(end($x));
  $file_tmp = $_FILES['book_picture']['tmp_name'];   
  $random_number  = rand(1,999);
  $new_image_name = $random_number.'-'.$book_picture; //menggabungkan angka acak dengan nama file sebenarnya
        if(in_array($extension, $file_extension) === true)  {     
                move_uploaded_file($file_tmp, 'img/'.$new_image_name); //memindah file gambar ke folder gambar
                  // jalankan query INSERT untuk menambah data ke database pastikan sesuai urutan (id tidak perlu karena dibikin otomatis)
                  $query = "INSERT INTO books (book_name, book_description, book_author, book_price, book_picture, user_id) VALUES ('$book_name', '$book_description', '$book_author', '$book_price', '$new_image_name', '$user_id')";
                  $result = mysqli_query($conn, $query);
                  // periska query apakah ada error
                  if(!$result){
                      die ("Query gagal dijalankan: ".mysqli_errno($conn).
                           " - ".mysqli_error($conn));
                  } else {
                    //tampil alert dan akan redirect ke halaman index.php
                    //silahkan ganti index.php sesuai halaman yang akan dituju
                    echo "<script>alert('Buku \"{$book_name}\" berhasil ditambah.');window.location='dashboard.php';</script>";
                  }

            } else {     
             //jika file ekstensi tidak jpg dan png maka alert ini yang tampil
                echo "<script>alert('Ekstensi gambar yang boleh hanya jpg atau png.');window.location='add_book.php';</script>";
            }
} else {
   $query = "INSERT INTO books (book_name, book_description, book_author, book_price, book_picture, user_id) VALUES ('$book_name', '$book_description', '$book_author', '$book_price', null, '$user_id')";
                  $result = mysqli_query($conn, $query);
                  // periska query apakah ada error
                  if(!$result){
                      die ("Query gagal dijalankan: ".mysqli_errno($conn).
                           " - ".mysqli_error($conn));
                  } else {
                    //tampil alert dan akan redirect ke halaman dashboard.php
                    echo "<script>alert('buku \"{$book_name}\" berhasil ditambahkan');window.location='dashboard.php';</script>";
                  }
}