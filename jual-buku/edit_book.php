<?php
  // memanggil file koneksi.php untuk membuat koneksi
include 'conn.php';
include 'auth.php'; //user access privileges

  // mengecek apakah di url ada nilai GET id
  if (isset($_GET['id'])) {
    // ambil nilai id dari url dan disimpan dalam variabel $id
    $id = ($_GET["id"]);

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

    // menampilkan data dari database yang mempunyai id=$id
    $query = "SELECT * FROM books WHERE id='$id' AND user_id = '$user_id'";
    $result = mysqli_query($conn, $query);
    // jika data gagal diambil maka akan tampil error berikut
    if(!$result){
      die ("Query Error: ".mysqli_errno($conn).
         " - ".mysqli_error($conn));
    }
    // mengambil data dari database
    $data = mysqli_fetch_assoc($result);
      // apabila data tidak ada pada database maka akan dijalankan perintah ini
       if (!$data) {
          echo "<script>alert('Buku tidak ditemukan pada database');window.location='dashboard.php';</script>";
       }
  } else {
    // apabila tidak ada data GET id pada akan di redirect ke dasshboard.php
    echo "<script>alert('Masukkan data id.');window.location='dashboard.php';</script>";
  }         
  ?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <title>Edit Buku <?php echo $data['book_name']; ?></title>
    <link rel="stylesheet" href="style.css">
  </head>
  <body>
    <section class="w-full md:w-4/5 bg-slate-300 m-auto p-4 md:p-8 lg:md-12">
      <script>
          document.write('<a href="' + document.referrer + '" class="inline-block px-6 py-2.5 bg-red-600 text-white font-medium text-xs leading-tight rounded shadow-md hover:bg-red-700 hover:shadow-lg focus:bg-red-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-red-800 active:shadow-lg transition duration-150 ease-in-out">Go Back</a>');
      </script>

      <h1 class="text-center font-bold text-3xl py-10">Edit Buku <?php echo $data['book_name']; ?></h1>
      
      <form method="POST" action="editing.php" enctype="multipart/form-data" >
        <!-- menampung nilai id produk yang akan di edit -->
        <input name="id" value="<?php echo $data['id']; ?>"  hidden />
        <div>
          <label>Judul Buku</label>
          <input type="text" name="book_name" value="<?php echo $data['book_name']; ?>" class="w-full h-12 px-4 mb-2 text-lg text-gray-700 placeholder-gray-600 border rounded-lg focus:shadow-outline" autofocus="" required="" />
        </div>
        <div>
          <label>Deskripsi Buku</label>
         <textarea name="book_description" rows="6" class="w-full px-4 mb-2 text-lg text-gray-700 placeholder-gray-600 border rounded-lg focus:shadow-outline" required=""><?php echo $data['book_description']; ?></textarea>
        </div>
        <div>
          <label>Penulis Buku</label>
         <input type="text" name="book_author" required=""value="<?php echo $data['book_author']; ?>" class="w-full h-12 px-4 mb-2 text-lg text-gray-700 placeholder-gray-600 border rounded-lg focus:shadow-outline" />
        </div>
        <div>
          <label>Harga Buku</label>
         <input type="number" name="book_price" required="" value="<?php echo $data['book_price']; ?>" class="w-full h-12 px-4 mb-2 text-lg text-gray-700 placeholder-gray-600 border rounded-lg focus:shadow-outline"/>
        </div>
        <div>
          <label class="block">Gambar Produk</label>
          <img src="img/<?php echo $data['book_picture']; ?>" style="width: 250px;float: left;margin-bottom: 5px;">
          <input type="file" name="book_picture" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100" />
          <i style="font-size: 11px;color: red">Abaikan jika tidak merubah gambar buku ini</i>
        </div>
        <div>
         <button type="submit" class="mt-12 inline-block px-6 py-2.5 bg-blue-600 text-white font-medium text-xs leading-tight rounded shadow-md hover:bg-blue-700 hover:shadow-lg focus:bg-blue-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-blue-800 active:shadow-lg transition duration-150 ease-in-out">Simpan Perubahan</button>
        </div>
      </form>
    </section>
  </body>
</html>