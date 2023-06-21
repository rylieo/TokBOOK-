<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <title>Registration Page</title>
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
        echo "<script>alert('Anda sudah login & terdaftar " . $_SESSION['username'] . "!');window.location='index.php';</script>";
    }
    // When form submitted, insert values into the database.
    if (isset($_REQUEST['username'])) {
        // removes backslashes
        $username = stripslashes($_REQUEST['username']);
        //escapes special characters in a string
        $username = mysqli_real_escape_string($conn, $username);
        $email    = stripslashes($_REQUEST['email']);
        $email    = mysqli_real_escape_string($conn, $email);
        $password = stripslashes($_REQUEST['password']);
        $password = mysqli_real_escape_string($conn, $password);
        $create_datetime = date("Y-m-d H:i:s");

        $select = mysqli_query($conn, "SELECT * FROM users WHERE username = '".$username."'");
        if(mysqli_num_rows($select)) {
            echo "<script>alert('username \"${username}\" sudah ada yang punya mohon registrasi ulang dengan username yang unik!');window.location='register.php';</script>";
            die('username must unique');
        }

        $cekemail = mysqli_query($conn, "SELECT * FROM users WHERE email = '".$email."'");
        if(mysqli_num_rows($cekemail)) {
            echo "<script>alert('email \"${email}\" sudah terdaftar silahkan login');window.location='login.php';</script>";
            die('email already existing in db');
        }

        $query    = "INSERT into `users` (username, password, email, create_datetime)
                     VALUES ('$username', '" . md5($password) . "', '$email', '$create_datetime')";
        $result   = mysqli_query($conn, $query);
        if ($result) {
            echo "<script>alert('Berhasil Registrasi sekarang Login dulu ya');window.location='login.php';</script>";
        } else {
            echo "<script>alert('yah registrasinya gagal');window.location='register.php';</script>";
        }
    } else {
?>
    <section class="w-full md:w-4/5 bg-slate-300 m-auto p-4 md:p-8 lg:md-12">
        <h1 class="text-center font-bold text-3xl py-10">Registration Form</h1>
        <form class="form" method="post" name="login">
            <div>
                <label>Usename</label>
                <input type="text" name="username" class="w-full h-12 px-4 mb-2 text-lg text-gray-700 placeholder-gray-600 border rounded-lg focus:shadow-outline" autofocus="" required="" />
            </div>
            <div>
                <label>Email</label>
                <input type="email" name="email" class="w-full h-12 px-4 mb-2 text-lg text-gray-700 placeholder-gray-600 border rounded-lg focus:shadow-outline" autofocus="" required="" />
            </div>
            <div>
                <label>Password</label>
                <input type="password" name="password" class="w-full h-12 px-4 mb-2 text-lg text-gray-700 placeholder-gray-600 border rounded-lg focus:shadow-outline" autofocus="" required="" />
            </div>
            <div>
                <button type="submit" class="mt-12 inline-block px-6 py-2.5 bg-blue-600 text-white font-medium text-xs leading-tight rounded shadow-md hover:bg-blue-700 hover:shadow-lg focus:bg-blue-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-blue-800 active:shadow-lg transition duration-150 ease-in-out">Register</button>
            </div>
            <div class="mt-8">
                <a class="hover:underline" href="login.php">kalo udah punya akun, Login here!</a>
            </div>
        </form>
    </section>
<?php
    }
?>
</body>
</html>