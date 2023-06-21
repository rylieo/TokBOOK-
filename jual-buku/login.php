<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <title>Login Page</title>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css"/>
</head>
<body>
<?php
    include 'conn.php';
    session_start();
    if(isset($_SESSION["username"])) {
        echo "<script>alert('anda sudah login " . $_SESSION['username'] . "!');window.location='dashboard.php';</script>";
    }
    // When form submitted, check and create user session.
    if (isset($_POST['username'])) {
        $username = stripslashes($_REQUEST['username']);    // removes backslashes
        $username = mysqli_real_escape_string($conn, $username);
        $password = stripslashes($_REQUEST['password']);
        $password = mysqli_real_escape_string($conn, $password);
        // Check user is exist in the database
        $query    = "SELECT * FROM `users` WHERE username='$username'
                     AND password='" . md5($password) . "'";
        $result = mysqli_query($conn, $query) or die(mysql_error());
        $rows = mysqli_num_rows($result);
        if ($rows == 1) {
            $_SESSION['username'] = $username;
            // Redirect to index page
            echo "<script>alert('Berhasil Login selamat datang " . $_SESSION['username'] . "!');window.location='dashboard.php';</script>";
        } else {
            echo "<script>alert('Password / Username salah coba diingat lagi soalnya website ini belum mendukung reset password kalau lupa, kalau tidak ingat hubungi me@aliif.space.');window.location='login.php';</script>";
        }
    } else {
?>
    <section class="w-full md:w-4/5 bg-slate-300 m-auto p-4 md:p-8 lg:md-12">
        <h1 class="text-center font-bold text-3xl py-10">Login Form</h1>
        <form class="form" method="post" name="login">
            <div>
                <label>Usename</label>
                <input type="text" name="username" class="w-full h-12 px-4 mb-2 text-lg text-gray-700 placeholder-gray-600 border rounded-lg focus:shadow-outline" autofocus="" required="" />
            </div>
            <div>
                <label>Password</label>
                <input type="password" name="password" class="w-full h-12 px-4 mb-2 text-lg text-gray-700 placeholder-gray-600 border rounded-lg focus:shadow-outline" autofocus="" required="" />
            </div>
            <div>
                <button type="submit" class="mt-12 inline-block px-6 py-2.5 bg-blue-600 text-white font-medium text-xs leading-tight rounded shadow-md hover:bg-blue-700 hover:shadow-lg focus:bg-blue-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-blue-800 active:shadow-lg transition duration-150 ease-in-out">Login</button>
            </div>
            <div class="mt-8">
                <a class="text-red-500 hover:underline" href="register.php">kalo gak punya akun, register here!</a>
            </div>
        </form>
    </section>
<?php
    }
?>
</body>
</html>