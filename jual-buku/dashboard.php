<?php
include 'conn.php'; //agar index terhubung dengan database, maka koneksi sebagai penghubung harus di include
include 'auth.php'; //auth wall hanya yang ssudah login yang bisa masuk
if (!isset($_SESSION)) {
    session_start();
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Dashboard Toko Buku <?php echo ($_SESSION['username']); ?></title>
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
        <div class="bg-gradient-to-br from-sky-400 via-purple-600 to-purple-700 shadow-2xl rounded-lg mx-auto text-center py-12 mt-4">
            <h2 class="text-3xl leading-9 font-bold tracking-tight text-white sm:text-4xl sm:leading-10">
                Dashboard Toko Buku <?php echo ($_SESSION['username']); ?>
            </h2>
            <?php
            if (isset($_SESSION["username"])) {
                echo "<h1 class='text-lg font-bold text-white mt-4'>Halo, " . $_SESSION['username'] . "!<h1>";
            }
            ?>
            <div class="mt-8 flex justify-center">
                <div class="inline-flex rounded-md bg-white shadow">
                    <a href="index.php" class="text-gray-700 font-bold py-2 px-6">
                        Homepage
                    </a>
                </div>
            </div>
            <div class="mt-8 flex justify-center">
                <div class="inline-flex rounded-md bg-white shadow">
                    <a href="add_book.php" class="text-gray-700 font-bold py-2 px-6">
                        Add Book +
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
                </svg></label><input type="search" id="search-input" placeholder="cari" aria-label="Search"></div>
        <div class="flex flex-wrap -mx-1 lg:-mx-4">
            <?php
            // Get User Id based on username session
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
            // jalankan query untuk menampilkan semua data diurutkan dari yang terbaru ditambahkan ssesuai dengan user id nya
            $query = "SELECT * FROM books WHERE user_id='{$user_id}' ORDER BY id DESC";
            $result = mysqli_query($conn, $query);
            //mengecek apakah ada error ketika menjalankan query
            if (!$result) {
                die("Query Error: " . mysqli_errno($conn) .
                    " - " . mysqli_error($conn));
            }

            //hasil query result lalu di loop per row nya agar datanya bisa ditampilkan diakses dengan kuci nama column
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
                            <a href="edit_book.php?id=<?php echo $row['id']; ?>" class="inline-block px-6 py-2.5 bg-blue-600 text-white font-medium text-xs leading-tight rounded shadow-md hover:bg-blue-700 hover:shadow-lg focus:bg-blue-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-blue-800 active:shadow-lg transition duration-150 ease-in-out">
                                Edit
                            </a>
                            <a href="delete_book.php?id=<?php echo $row['id']; ?>" onclick="return confirm('Anda yakin akan menghapus buku <?php echo $row['book_name']; ?>?')" class="inline-block px-6 py-2.5 bg-red-600 text-white font-medium text-xs leading-tight rounded shadow-md hover:bg-red-700 hover:shadow-lg focus:bg-red-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-red-800 active:shadow-lg transition duration-150 ease-in-out">
                                Delete
                            </a>
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