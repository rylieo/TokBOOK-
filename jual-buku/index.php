<?php
include 'conn.php'; //agar index terhubung dengan database, maka koneksi sebagai penghubung harus di include

session_start();

?>
<!DOCTYPE html>
<html>

<head>
  <title>TokBOOK</title>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="style.css">

  <style>
    .search-article {
      position: relative;
      margin-top: 2.5rem;
      margin-bottom: 2.5rem;
    }

    .search-article label[for="search-input"] {
      position: relative;
      top: -6px;
      left: 11px;
    }

    .search-article input[type="search"] {
      top: -1rem;
      left: 0;
      border: 0;
      width: 100%;
      height: 40px;
      outline: none;
      position: absolute;
      border-radius: 5px;
      padding: 10px 10px 10px 35px;
      color: var(--base-color);
      -webkit-appearance: none;
      background-color: rgba(128, 128, 128, 0.1);
      border: 1px solid rgba(128, 128, 128, 0.1);
    }

    .search-article input[type="search"]::-webkit-input-placeholder {
      color: #808080;
    }

    .search-article input[type="search"]::-webkit-search-decoration,
    .search-article input[type="search"]::-webkit-search-results-decoration {
      display: none;
    }
  </style>
</head>

<body>

  <div class="container my-12 mx-auto px-4 md:px-12">
    <div class="bg-gradient-to-tr from-sky-400 via-purple-600 to-purple-700 shadow-2xl rounded-lg mx-auto text-center py-12 mt-4">
      <h2 class="text-3xl leading-9 font-bold tracking-tight text-white sm:text-4xl sm:leading-10">
        Selamat Datang Di TokBOOK
      </h2>
      <?php
      if (isset($_SESSION["username"])) {
        echo "<h1 class='text-lg font-bold text-white mt-4'>Halo, " . $_SESSION['username'] . "!<h1>";
      }
      ?>
      <div class="mt-8 flex justify-center">
        <div class="inline-flex rounded-md bg-white shadow">
          <a href="dashboard.php" class="text-gray-700 font-bold py-2 px-6">
            <?php
            if (isset($_SESSION["username"])) {
              echo "Dashboard";
            } else {
              echo "Mau Jual Buku?";
            }
            ?>
          </a>
        </div>
        <?php
        if (isset($_SESSION["username"])) { //heredoc style
          $logmes = <<<logmes
                  <div class="inline-flex ml-4 rounded-md bg-red-600 shadow">
                    <a href="logout.php" class="text-white font-bold py-2 px-6" onclick="return confirm('Anda yakin Logout?')">
                        Logout
                    </a>
                  </div>
                  logmes;
          echo "$logmes";
        }
        ?>
      </div>
    </div>
    <div class="search-article"><label for="search-input" aria-hidden="true"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="rgba(128,128,128,0.8)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search">
          <circle cx="11" cy="11" r="8"></circle>
          <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
        </svg></label><input type="search" id="search-input" placeholder="Cari" aria-label="Search"></div>
    <div class="flex flex-wrap -mx-1 lg:-mx-4">
      <?php
      // jalankan query untuk menampilkan semua data diurutkan berdasarkan buku yang terbaru ditambahkan
      $query = "SELECT * FROM books ORDER BY id DESC";
      $result = mysqli_query($conn, $query);
      //mengecek apakah ada error ketika menjalankan query
      if (!$result) {
        die("Query Error: " . mysqli_errno($conn) .
          " - " . mysqli_error($conn));
      }

      ////hasil query result lalu di loop per row nya agar datanya bisa ditampilkan diakses dengan kuci nama column
      while ($row = mysqli_fetch_assoc($result)) {
      ?>

        <!-- Column -->
        <div class="buku my-1 px-1 w-full md:w-1/2 lg:my-4 lg:px-4 lg:w-1/3">

          <p style="display:none;"><?php echo $row['book_name'], " ", $row['book_author']; ?></p>

          <!-- Article -->
          <article class="overflow-hidden rounded-lg shadow-lg">


            <img src="img/<?php echo $row['book_picture']; ?>" alt="<?php echo $row['book_name']; ?>" class="object-contain h-60 w-96">

            <div class="p-2 md:p-4">
              <p class="text-xl text-blue-700 font-semibold">Rp <?php echo number_format($row['book_price'], 0, ',', '.'); ?></p>

              <p class="text-2xl font-bold"><?php echo $row['book_name']; ?></p>
              <p class="italic font-semibold">Penulis : <?php echo $row['book_author']; ?></p>
              <p><?php echo substr($row['book_description'], 0, 200); ?>.</p>
            </div>


            <footer class="flex items-center justify-between leading-none p-2 md:p-4">
              <?php
              $wadau = mysqli_query($conn, "SELECT U.email, B.book_name, B.book_price, B.book_author FROM users AS U, books AS B WHERE U.id = B.user_id and B.id = {$row["id"]}");
              $count2 = mysqli_num_rows($wadau);
              if ($count2 > 0) {
                $baris2 = mysqli_fetch_assoc($wadau);
                $user_email = $baris2["email"];
                $harga_buku = $baris2["book_price"];
                $judul_buku = $baris2["book_name"];
              }
              if (isset($_SESSION["username"])) {
                // Get User Id based on username
                $sql = "SELECT id FROM users WHERE username='{$_SESSION["username"]}'";
                $res = mysqli_query($conn, $sql);
                $count = mysqli_num_rows($res);
                if ($count > 0) {
                  $baris = mysqli_fetch_assoc($res);
                  $user_id = $baris["id"];
                } else {
                  $user_id = 0;
                }
                $sql = null;
                if ($row['user_id'] == $user_id) {
                  echo "<a href='edit_book.php?id={$row['id']}' class='inline-block px-6 py-2.5 bg-blue-600 text-white font-medium text-xs leading-tight rounded shadow-md hover:bg-blue-700 hover:shadow-lg focus:bg-blue-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-blue-800 active:shadow-lg transition duration-150 ease-in-out'>
                        Edit
                        </a>";
                  $delmes = <<<delmes
                        onclick="return confirm('Anda yakin akan menghapus buku {$row['book_name']}?')"
                        delmes;
                  echo "<a href='delete_book.php?id={$row['id']}' $delmes class='inline-block px-6 py-2.5 bg-red-600 text-white font-medium text-xs leading-tight rounded shadow-md hover:bg-red-700 hover:shadow-lg focus:bg-red-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-red-800 active:shadow-lg transition duration-150 ease-in-out'>
                            Delete
                        </a>";
                } else {
                  echo "<a href='mailto:{$user_email}?subject=Pembelian Buku \"{$judul_buku}\"&body=Saya mau beli buku dengan judul \"{$judul_buku}\" \n yang harganya Rp. {$harga_buku}' class='w-full text-center px-6 py-2.5 bg-violet-600 text-white font-medium leading-tight rounded shadow-md'>
                            Beli
                        </a>";
                }
              } else {
                echo "<a href='mailto:{$user_email}?subject=Pembelian Buku \"{$judul_buku}\"&body=Saya mau beli buku dengan judul \"{$judul_buku}\" \n yang harganya Rp. {$harga_buku}' class='w-full text-center px-6 py-2.5 bg-violet-600 text-white font-medium leading-tight rounded shadow-md'>
                      Beli
                  </a>";
              }

              ?>
            </footer>

          </article>
          <!-- END Article -->

        </div>
        <!-- END Column -->
      <?php
      }
      ?>

    </div>
  </div>
  <footer class="p-12 text-center font-bold text-base">
    Copyright © 2023 by SATRIO from PPLG X-5
  </footer>
  <script src="search.js"></script>
</body>

</html>